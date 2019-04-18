<?php
namespace Linder\Guess;
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     */
     private $number;
    /**
     * @var int $tries    Number of tries a guess has been made.
     */
    private $tries;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = ($number === -1) ? $this->random() : $number;
        $this->tries = $tries;
    }


    /**
     * Randomize a number between 1 and 100.
     *
     * @return int A number between 1 and 100.
     */
    public function random()
    {
        return rand(1, 100);
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries left.
     */
    public function tries()
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     * 
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        $number = (int)$number;
        if (!(is_int($number) && $number >= 1 && $number <= 100)) {
            throw new GuessException("Needs to be an integer between 1 and 100.");
        } elseif ($this->tries() == 0) {
            return "You have no guesses remaining";
        }
        $this->tries--;

        // echo ($number > $this->number());
        if ($number === $this->number()) {
            return "You guessed {$number}, your guess is right.";
        } elseif ($number > $this->number()) {
            return "You guessed {$number}, your guess is too high.";
        } elseif ($number < $this->number()) {
            return "You guessed {$number}, your guess is too low.";
        }
    }
}
