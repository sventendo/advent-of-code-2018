<?php

namespace Sventendo\AdventOfCode2018\Tests\Day;

use Sventendo\AdventOfCode2018\Day\Day9;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class Day9Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day9::class);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testFirstPuzzle()
    {
        $this->print($this->subject->firstPuzzle([470, 72170]));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSecondPuzzle()
    {
        $this->print($this->subject->secondPuzzle([470, 72170 * 100]));
    }
}
