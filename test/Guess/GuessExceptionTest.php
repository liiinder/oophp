<?php

namespace Linder\Guess;

use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException('Linder\Guess\GuessException');
        $guess = new Guess();
        $guess->makeGuess(-3);
    }
}
