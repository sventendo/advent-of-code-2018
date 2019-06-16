<?php

namespace Sventendo\AdventOfCode2018\Tests\Day\Day12;

use Sventendo\AdventOfCode2018\Day\Day12\Pot;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class PotTest extends TestCase
{
    /**
     * @var Pot
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Pot::class);
    }

    public function testPatternValue()
    {
        $this->subject->setPatternValue('#');

        $this->assertEquals('#', $this->subject->getPatternValue());
    }
}
