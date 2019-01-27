<?php

namespace Sventendo\AdventOfCode2018\Tests\Day;

use Sventendo\AdventOfCode2018\Day\Day10;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class Day10Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day10::class);
        $this->input = file_get_contents(__DIR__ . '/Day10/input.txt');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testFirstPuzzle()
    {
        $this->print($this->subject->firstPuzzle($this->input));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSecondPuzzle()
    {
        $this->print($this->subject->secondPuzzle($this->input));
    }
}
