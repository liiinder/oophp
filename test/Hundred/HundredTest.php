<?php

namespace Linder\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class HundredCreateObjectTest extends TestCase
{

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $game = new Hundred();
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $res = sizeof($game->getPlayers());
        $exp = 2;
        $this->assertEquals($exp, $res);

        $res = $game->getPlayers()[0]->isPlayer();
        $this->assertTrue($res);

        $res = $game->getPlayers()[1]->isPlayer();
        $this->assertFalse($res);

        $res = $game->getPlayers()[0]->getHandSize();
        $exp = 2;
        $this->assertEquals($exp, $res);

        $res = $game->getMaxScore();
        $exp = 100;
        $this->assertEquals($exp, $res);

        $res = $game->getTurn();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $game = new Hundred(4);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $res = sizeof($game->getPlayers());
        $exp = 4;
        $this->assertEquals($exp, $res);

        $res = $game->getPlayers()[2]->isPlayer();
        $this->assertTrue($res);

        $res = $game->getPlayers()[3]->isPlayer();
        $this->assertFalse($res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use two arguments.
     */
    public function testCreateObjectTwoArguments()
    {
        $game = new Hundred(4, 3);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $res = sizeof($game->getPlayers());
        $exp = 4;
        $this->assertEquals($exp, $res);

        $res = $game->getPlayers()[0]->isPlayer();
        $this->assertTrue($res);

        $res = $game->getPlayers()[1]->isPlayer();
        $this->assertFalse($res);

        $res = $game->getPlayers()[2]->isPlayer();
        $this->assertFalse($res);

        $res = $game->getPlayers()[3]->isPlayer();
        $this->assertFalse($res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. With the use of the third argument.
     */
    public function testCreateObjectThirdArgument()
    {
        $game = new Hundred(2, 1, 5);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $res = $game->getPlayers()[0]->getHandSize();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. With the use of the fourth argument.
     */
    public function testCreateObjectFourthArgument()
    {
        $game = new Hundred(2, 1, 5, 30);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $res = $game->getMaxScore();
        $exp = 30;
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing of the action with Roll argument
     */
    public function testPlayRoll()
    {
        // Create a game with 100 dices
        $game = new Hundred(2, 1, 100, 100);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $cur = $game->getPlayers()[$game->getTurn()];
        $previousRoll = $cur->getValues();
        $game->play("roll");
        $currentRoll = $cur->getValues();
        $this->assertNotEquals($previousRoll, $currentRoll);
    }

    /**
     * Testing of the action with Save argument
     */
    public function testPlayRollSave()
    {
        // Create a game with 10000 dices
        $game = new Hundred(2, 1, 10000, 100);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        $cur = $game->getPlayers()[$game->getTurn()];
        $this->assertTrue($cur->isSafe());
        $game->play("roll");
        if (in_array(1, $cur->getValues())) {
            $this->assertFalse($cur->isSafe());
            $this->assertEquals(0, $cur->getRound());
        } else {
            $this->assertTrue($cur->isSafe());
            $this->assertEquals($cur->getRound(), $cur->getSum());
        }
        $game->play("save");
        $this->assertTrue($cur->isSafe());
    }


    /**
     * Testing of the action with Save argument
     * Several rounds and only roll once.
     */
    public function testPlayRollSaveMultipleRounds()
    {
        // A game without computers
        $game = new Hundred(2, 0);
        $this->assertInstanceOf("\Linder\Hundred\Hundred", $game);

        for ($i = 0; $i < 100; $i++) {
            $cur = $game->getPlayers()[$game->getTurn()];
            $this->assertTrue($cur->isSafe());
            $prevRound = $cur->getRound();
            $game->play("roll");
            if (in_array(1, $cur->getValues())) {
                $this->assertFalse($cur->isSafe());
                $this->assertEquals(0, $cur->getRound());
            } else {
                $this->assertTrue($cur->isSafe());
                $res = $cur->getRound();
                $exp = $prevRound + $cur->getSum();
                $this->assertEquals($exp, $res);
            }
            $game->play("save");
            $this->assertTrue($cur->isSafe());
        }
    }
}
