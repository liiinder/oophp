<?php
namespace Linder\Hundred2;

/**
 * Player class that handles the players dices and score.
 */
class Player
{
    /**
     * @var array $dices, array of dices
     */
    private $dices;
    /**
     * @var bool $player if its a player or computer
     */
    private $player;
    /**
     * @var int $score of player
     */
    private $score;
    /**
     * @var int $round , sum of this round.
     */
    private $roundScore;
    /**
     * @var array $roundValues , values of this round.
     */
    private $roundValues;
    /**
     * @var bool $safe , if player is safe
     */
    private $safe;


    /**
     * Constructor to initiate a player with a number of dices.
     *
     * @param bool $player if its a player or a computer
     * @param int $amount Number of dices to create, defaults to five.
     */
    public function __construct(bool $player = true, int $amount = 2)
    {
        for ($i = 0; $i < $amount; $i++) {
            $die = new \Linder\Hundred2\Dice();
            $this->dices[] = $die;
        }
        $this->player = $player;
        $this->score = 0;
        $this->roundScore = 0;
        $this->roundValues = [];
        $this->safe = true;
    }

    /**
     * @return int how many dices we play with.
     */
    public function getHandSize()
    {
        return sizeof($this->dices);
    }

    /**
     * @return bool if its a player or not.
     */
    public function isPlayer()
    {
        return $this->player;
    }


    /**
     * @return bool if player is safe or not.
     */
    public function isSafe()
    {
        return $this->safe;
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        foreach ($this->dices as $die) {
            $die->roll();
            if ($die->getValue() == 1) {
                $this->resetRound();
                $this->safe = false;
            }
        }
        if ($this->safe) {
            $this->updateRound();
        }
    }


    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function getValues()
    {
        $array = array();
        if (is_array($this->dices)) {
            foreach ($this->dices as $die) {
                $array[] = $die->getValue();
            }
        }
        return $array;
    }


    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function getSum()
    {
        return array_sum($this->getValues());
    }


    /**
     * Get the score of player.
     *
     * @return int of player score.
     */
    public function getScore()
    {
        return $this->score;
    }


    /**
     * @return int $round
     */
    public function getRoundScore()
    {
        return $this->roundScore;
    }


    /**
     * @return array $roundValues
     */
    public function getRoundValues()
    {
        return $this->roundValues;
    }

    /**
     * reset the round variables.
     *
     */
    public function resetRound()
    {
        $this->roundScore = 0;
        $this->roundValues = [];
    }

    /**
     * update the round variables.
     *
     */
    public function updateRound()
    {
        $this->roundScore += $this->getSum();
        $this->roundValues = array_merge($this->roundValues, $this->getValues());
    }


    /**
     * Set the score of player.
     *
     * @return int of players new score.
     */
    public function save()
    {
        $this->score += $this->roundScore;
        $this->safe = true;
        $this->resetRound();
        return $this->score;
    }
}
