<?php
namespace Linder\Hundred2;

/**
 * Hundred class that handles the game.
 */
class Hundred implements HistogramInterface
{
    use HistogramTrait;

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
     * @var array $allThrows , keeping track of all the throws
     * so we can "predict" the odds.
     */
    private $allThrows;

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
            $this->players[] = new \Linder\Hundred2\Player(true, $dices);
        }
        for ($i = 0; $i < $computers; $i++) {
            $this->players[] = new \Linder\Hundred2\Player(false, $dices);
        }
        $this->turn = 0;
        $this->maxScore = $maxScore;
        $this->allThrows = [];
    }

    /**
     * @return array of all the player objects
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @return object of the current player
     */
    public function getPlayer()
    {
        return $this->players[$this->turn];
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
     * @return array , all the throws
     */
    public function getAllThrows()
    {
        return $this->allThrows;
    }


    /**
     * If the current player is safe, roll his dices
     * and add the throw to the allThrow array.
     */
    public function roll()
    {
        $player = $this->getPlayer();
        if ($player->isSafe()) {
            $player->roll();
            $this->allThrows = array_merge($this->allThrows, $player->getValues());
        }
    }

    /**
     * If the player wants to save.
     * Call the players save method
     * Change the turn to the next player
     * and if its a computers turn call the AI method.
     */
    public function save()
    {
        $this->getPlayer()->save();
        if ($this->turn < sizeof($this->players)-1) {
            $this->turn++;
        } else {
            $this->turn = 0;
        }
        if (!$this->getPlayer()->isPlayer()) {
            $this->aiTurn();
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
        $player = $this->getPlayer();
        $leader = 0;
        // Decide how much points the leader have
        foreach ($this->players as $play) {
            $leader = $play->getScore() > $leader ? $play->getScore() : $leader;
        }
        while (true) {
            $this->roll();
            $score = $player->getScore();
            $roundScore = $player->getRoundScore();
            if (($score == $leader && $roundScore >= 6) ||
            ($roundScore + $score >= $leader) ||
            ($roundScore >= 12) ||
            (!$player->isSafe())) {
                $this->save();
                break;
            }
        }
    }

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->getPlayer()->getRoundValues();
    }
}
