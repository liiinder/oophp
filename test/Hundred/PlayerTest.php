<?php

namespace Linder\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class PlayerCreateObjectTest extends TestCase
{

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $player = new Player();
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $res = $player->getHandSize();
        $exp = 2;
        $this->assertEquals($exp, $res);

        $res = $player->isPlayer();
        $this->assertTrue($res);

        $res = $player->getScore();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $player->getRound();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $player->isSafe();
        $this->assertTrue($res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $player = new Player(false);
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $res = $player->isPlayer();
        $this->assertFalse($res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use two arguments.
     */
    public function testCreateObjectTwoArguments()
    {
        $player = new Player(false, 3);
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $res = $player->getHandSize();
        $exp = 3;
        $this->assertEquals($exp, $res);

        $res = $player->isPlayer();
        $this->assertFalse($res);
    }


    /**
     * Testing the roll method
    */
    public function testRoll()
    {
        $player = new Player(true, 100);
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        for ($i = 0; $i < 10; $i++) {
            $tempArray = $player->getValues();
            $this->assertEquals($tempArray, $player->getValues());
            $player->roll();
            $this->assertNotEquals($tempArray, $player->getValues());
        }
    }


    /**
     * Testing setSafe method
    */
    public function testSetSafe()
    {
        $player = new Player(true);
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $res = $player->isSafe();
        $this->assertTrue($res);

        $player->setSafe(false);
        $res = $player->isSafe();
        $this->assertFalse($res);

        $player->setSafe(true);
        $res = $player->isSafe();
        $this->assertTrue($res);
    }


    /**
     * Test the save score method
     */
    public function testScore()
    {
        $player = new Player();
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $res = $player->getScore();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $player->setRound(10);
        $res = $player->save();
        $exp = 10;
        $this->assertEquals($exp, $res);

        $player->setRound(10);
        $res = $player->save();
        $exp = 20;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test if the getSum returns the correct value
     */
    public function testGetSum()
    {
        $player = new Player();
        $this->assertInstanceOf("\Linder\Hundred\Player", $player);

        $arr = $player->getValues();
        $sum = 0;
        foreach ($arr as $die) {
            $sum += $die;
        }
        $res = $player->getSum();
        $this->assertEquals($sum, $res);
    }
}
