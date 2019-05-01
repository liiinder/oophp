<?php

namespace Linder\Hundred2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceCreateObjectTest extends TestCase
{

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Linder\Hundred2\Dice", $dice);

        $res = $dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $dice = new Dice(3);
        $this->assertInstanceOf("\Linder\Hundred2\Dice", $dice);

        $res = $dice->getSides();
        $exp = 3;
        $this->assertEquals($exp, $res);
    }




    /**
     * Testing the roll method
    */
    public function testRoll()
    {
        $die = new Dice();
        $this->assertInstanceOf("\Linder\Hundred2\Dice", $die);

        for ($i = 0; $i < 100; $i++) {
            $die->roll();
            $this->assertContains($die->getValue(), [1, 2, 3, 4, 5, 6]);
        }
    }

    /**
     * Set sides of a dice and test the result
     */
    public function testSetSides()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Linder\Hundred2\Dice", $dice);

        $res = $dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
        $dice->setSides(3);
        $res = $dice->getSides();
        $exp = 3;
        $this->assertEquals($exp, $res);
    }
}
