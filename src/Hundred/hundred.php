<?php
namespace Linder\Hundred;

/**
 * Hundred class that handles the game.
 */
class Hundred
{
    private $maxScore;
    private $players; // array of players
    private $turn; // Keeping index of whos turn it is

    public function __construct(int $players = 2, int $computers = 1, int $dices = 2, int $maxScore = 100)
    {
        for ($i = 0; $i < $players; $i++) {
            if (($players - $i) > $computers) {
                $this->players[] = new \Linder\Hundred\Player(true, $dices);
            } else {
                $this->players[] = new \Linder\Hundred\Player(false, $dices);
            }
        }
        $this->turn = 0;
        $this->maxScore = $maxScore;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getMaxScore()
    {
        return $this->maxScore;
    }

    public function turnOver()
    {
        $this->players[$this->turn]->save();
        if ($this->turn < sizeof($this->players)-1) {
            $this->turn++;
        } else {
            $this->turn = 0;
        }
        if (!$this->players[$this->turn]->isPlayer()) {
            $this->aiTurn();
        }
    }

    public function play($action)
    {
        $player = $this->players[$this->turn];
        if ($action == "roll" && $player->isSafe()) {
            $safe = $player->roll();
            if (!$safe) {
                $player->setRound(0);
                $player->setSafe(false);
            } else {
                $player->setRound($player->getRound() + $player->getSum());
            }
        }
        if ($action == "save") {
            $player->setSafe(true);
            $this->turnOver();
        }
    }

    public function aiTurn()
    {
        $player = $this->players[$this->turn];
        $leader = 0;
        // Decide how much points the leader have
        foreach ($this->players as $play) {
            $leader = $play->getScore() > $leader ? $play->getScore() : $leader;
        }
        while (true) {
            $this->play("roll"); // roll the dices
            if (($player->getScore() == $leader && $player->getRound() >= 6) ||
            ($player->getRound() + $player->getScore() >= $leader) ||
            ($player->getRound() >= 12) ||
            (!$player->isSafe())) {
                $this->play("save");
                break;
            }
        }
    }
}
