<?php

namespace Linder\Hundred2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class TraitTest extends TestCase
{
    use HistogramTrait;

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testDefaultHistogramTrait()
    {
        $res = $this->getHistogramMax();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $this->getHistogramMin();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $this->getHistogramSerie();
        $exp = [];
        $this->assertEquals($exp, $res);
    }
}
