<?php
namespace Linder\Hundred2;

/**
 * Dice class
 */
class Dice
{
    /**
     * @var int $sides number of sides on the die
     * @var int $value, what side it landed on
     */
    private $sides;
    private $value;

    /**
     * Constructor to create a die
     *
     * @param int $sides number of sides on the die
     */
    public function __construct(int $sides = null)
    {
        $this->sides = $sides ?? 6;
        $this->roll();
    }

    /**
     * Method to roll the die
     *
     * @return int the roll;
     */
    public function roll()
    {
        $this->value = rand(1, $this->sides);
        return $this->value;
    }

    /**
     * Get sides of the die
     *
     * @return int sides of the die
     */
    public function getSides()
    {
        return $this->sides;
    }

    /**
     * Get value of the throw
     *
     * @return int value of the throw
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set sides of the die
     *
     * @param int Sides of the die
     */
    public function setSides(int $sides)
    {
        $this->sides = $sides;
    }
}
