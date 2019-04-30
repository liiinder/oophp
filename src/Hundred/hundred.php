<?php
namespace Linder\Hundred;

/**
 * Hundred class that handles the game.
 */
class Hundred
{
    /**
     * @var int $maxScore , the score needed to win
     */
    private $maxScore;
    /**
     * @var array $players , array of player objects
     */
    private $players;
    /**
     * @var int $turn , keeping track of who's turn it is.
     */
    private $turn;

    /**
     * Constructor to initiate a game of pig.
     * @param int $players amount of players
     * @param int $computers amount of computers
     * @param int $dices amount of dices to be thrown
     * @param int $maxScore , the score needed to win
     */
    public function __construct(int $players = 1, int $computers = 1, int $dices = 2, int $maxScore = 100)
    {
        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new \Linder\Hundred\Player(true, $dices);
        }
        for ($i = 0; $i < $computers; $i++) {
            $this->players[] = new \Linder\Hundred\Player(false, $dices);
        }
        $this->turn = 0;
        $this->maxScore = $maxScore;
    }

    /**
     * @return array of all the player objects
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @return int the turn which corresponds to the index in the player array of whos turn it is.
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return int , the score needed to win
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * A method to save and change turn
     * and if the new player is a computer call the AI method.
     */
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

    /**
     * @param string $action , either roll or save.
     * if you want to save or keep rolling.
     */
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

    /**
     * A method for controlling the AI players.
     * First we find the leader and then we check how the
     * computer is in relation to the leader.
     * Then it plays accordingly.
     * Its programmed really safe.
     */
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
