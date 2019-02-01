<?php

namespace Sventendo\AdventOfCode2018\Tests\Day\Day9;

use Sventendo\AdventOfCode2018\Day\Day11\Grid;
use Sventendo\AdventOfCode2018\Day\Day11\Matrix;
use Sventendo\AdventOfCode2018\Day\Day11\SubGrid;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class MatrixTest extends TestCase
{
    /**
     * @var Matrix
     */
    public $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Matrix::class);
        $this->subject->initialize(3, 3);

        // summed area table for these values:
        // 1 | 2 | 3
        // 4 | 5 | 6
        // 7 | 8 | 9

        // looks like this:
        //  1 |  3 |  6
        //  5 | 12 | 21
        // 12 | 27 | 45
        $this->subject->setCoordinate(0, 0, 1);
        $this->subject->setCoordinate(1, 0, 3);
        $this->subject->setCoordinate(2, 0, 6);
        $this->subject->setCoordinate(0, 1, 5);
        $this->subject->setCoordinate(1, 1, 12);
        $this->subject->setCoordinate(2, 1, 21);
        $this->subject->setCoordinate(0, 2, 12);
        $this->subject->setCoordinate(1, 2, 27);
        $this->subject->setCoordinate(2, 2, 45);
    }

    /**
     * @dataProvider getGetPowerLevelForSubGridExamples
     */
    public function testGetPowerLevelForSubGrid(int $x, int $y, int $width, int $height, int $sum)
    {
        /** @var SubGrid $subGrid */
        $subGrid = $this->container->make(SubGrid::class);
        $subGrid->setX($x);
        $subGrid->setY($y);
        $subGrid->setWidth($width);
        $subGrid->setHeight($height);
        $this->assertEquals($sum, $this->subject->getPowerLevelForSubGrid($subGrid));
    }

    public function getGetPowerLevelForSubGridExamples()
    {
        return [
            [ 1, 1, 2, 2 , 28],
            [ 0, 0, 2, 2 , 12],
        ];
    }
}
