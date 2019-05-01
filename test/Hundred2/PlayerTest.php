<?php

namespace Linder\Hundred2;

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
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

        $res = $player->getHandSize();
        $exp = 2;
        $this->assertEquals($exp, $res);

        $res = $player->isPlayer();
        $this->assertTrue($res);

        $res = $player->getScore();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $player->getRoundScore();
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
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

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
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

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
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

        for ($i = 0; $i < 10; $i++) {
            $tempArray = $player->getValues();
            $this->assertEquals($tempArray, $player->getValues());
            $player->roll();
            $this->assertNotEquals($tempArray, $player->getValues());
        }
    }

    /**
     * Test getRoundValues()
     */
    public function testGetRoundValues()
    {
        $player = new Player(true, 100);
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

        for ($i = 0; $i < 10; $i++) {
            $player->roll();
            if (in_array(1, $player->getValues())) {
                $this->assertEquals([], $player->getRoundValues());
                $player->save();
            } else {
                $this->assertEquals($player->getValues(), $player->getRoundValues());
            }
        }
    }



    /**
     * Test if the getSum returns the correct value
     */
    public function testGetSum()
    {
        $player = new Player();
        $this->assertInstanceOf("\Linder\Hundred2\Player", $player);

        $arr = $player->getValues();
        $sum = 0;
        foreach ($arr as $die) {
            $sum += $die;
        }
        $res = $player->getSum();
        $this->assertEquals($sum, $res);
    }
}
