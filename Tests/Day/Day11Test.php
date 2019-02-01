<?php

namespace Sventendo\AdventOfCode2018\Tests\Day;

use Sventendo\AdventOfCode2018\Day\Day11;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class Day11Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day11::class);
        $this->input = 9798;
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
