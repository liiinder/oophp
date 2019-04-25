<?php

namespace Linder\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Linder\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Linder\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use both arguments.
     */
    public function testCreateObjectBothArguments()
    {
        $guess = new Guess(42, 7);
        $this->assertInstanceOf("\Linder\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 7;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }


    /**
     * Testing the makeGuess method
    */
    public function testMakeGuess()
    {
        $guess = new Guess(32, 6);
        $this->assertInstanceOf("\Linder\Guess\Guess", $guess);

        $exp = "You guessed 40, your guess is too high.";
        $this->assertEquals($exp, $guess->makeGuess(40));

        $exp = "You guessed 10, your guess is too low.";
        $this->assertEquals($exp, $guess->makeGuess(10));

        $exp = "You guessed 32, your guess is right.";
        $this->assertEquals($exp, $guess->makeGuess(32));
    }

    /**
     * Testing the makeGuess method
     * out of guesses
    */
    public function testMakeGuessNoGuesses()
    {
        $guess = new Guess(32, 0);
        $this->assertInstanceOf("\Linder\Guess\Guess", $guess);

        $exp = "You have no guesses remaining";
        $this->assertEquals($exp, $guess->makeGuess(40));
    }
}
