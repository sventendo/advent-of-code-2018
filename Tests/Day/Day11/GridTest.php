<?php

namespace Sventendo\AdventOfCode2018\Tests\Day\Day9;

use Sventendo\AdventOfCode2018\Day\Day11\Grid;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class GridTest extends TestCase
{
    /**
     * @var Grid
     */
    public $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Grid::class);
    }


    public function testGetDecimalPosition()
    {
        $number = 123;

        $this->assertEquals(3, $this->subject->getDecimalPosition($number, 0));
        $this->assertEquals(1, $this->subject->getDecimalPosition($number, 2));
        $this->assertEquals(0, $this->subject->getDecimalPosition($number, 5));
    }

    /**
     * @dataProvider getPowerLevelExamples
     */
    public function testGetPowerLevel(int $x, int $y, int $serialNumber, int $powerLevel)
    {
        $this->subject->setSerialNumber($serialNumber);
        $this->assertEquals($powerLevel, $this->subject->calculatePowerLevel($x, $y));
    }

    public function getPowerLevelExamples()
    {
        return [
            [ 122, 79, 57, -5 ],
            [ 217, 196, 39, 0 ],
            [ 101, 153, 71, 4 ],
        ];
    }
}
