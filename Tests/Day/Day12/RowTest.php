<?php

namespace Sventendo\AdventOfCode2018\Tests\Day\Day12;

use Sventendo\AdventOfCode2018\Day\Day12\Row;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class RowTest extends TestCase
{
    /**
     * @var Row
     */
    protected $subject;

    protected static $patterns = [
        '...##' => '#',
        '..#..' => '#',
        '.#...' => '#',
        '.#.#.' => '#',
        '.#.##' => '#',
        '.##..' => '#',
        '.####' => '#',
        '#.#.#' => '#',
        '#.###' => '#',
        '##.#.' => '#',
        '##.##' => '#',
        '###..' => '#',
        '###.#' => '#',
        '####.' => '#',
    ];

    public function setUp()
    {
        $this->subject = $this->container->make(Row::class);
    }

    public function testRowPattern()
    {
        $this->subject->setPlantsByPattern('#..#...##');

        $this->assertEquals('....#..#...##....', $this->subject->getPattern());
    }

    /**
     * @param string $pattern
     * @param int $hashSum
     *
     * @dataProvider getHashSumExamples
     */
    public function testTotalValue(string $pattern, int $hashSum)
    {
        $this->subject->setPlantsByPattern($pattern);

        $this->assertEquals($hashSum, $this->subject->getTotalValue());
    }

    public function getHashSumExamples()
    {
        return [
            [ '#..##', 7 ],
            [ '#..#.', 3 ],
        ];
    }

    public function testOneGeneration()
    {
        $this->subject->setPlantsByPattern('#..#.#..##......###...###');
        $this->subject->setBreedingPatterns(self::$patterns);
        $this->subject->wait();

        $this->assertEquals('....#...#....#.....#..#..#..#....', $this->subject->getPattern());
    }

    public function testTwentyGenerations()
    {
        $this->subject->setPlantsByPattern('#..#.#..##......###...###');
        $this->subject->setBreedingPatterns(self::$patterns);
        $this->subject->wait(20);

        $this->assertEquals('....#....##....#####...#######....#.#..##...', $this->subject->getPattern());
    }

    public function testIndex()
    {
        $this->subject->setPlantsByPattern('###');
        $this->assertEquals(-4, $this->subject->getPotFurthestToTheLeft()->getIndex());
        $this->assertEquals(6, $this->subject->getPotFurthestToTheRight()->getIndex());
    }

    public function testPotPattern()
    {
        $this->subject->setPlantsByPattern('#');
        $this->assertEquals('#', $this->subject->getPotZero()->getPatternValue());
        $this->assertEquals('..#..', $this->subject->getPotZero()->getPattern());
    }

    public function testUpdatePatternValue()
    {
        $this->subject->setPlantsByPattern('#');
        $this->subject->getPotZero()->setFuturePatternValue(self::$patterns);
        $this->assertTrue($this->subject->getPotZero()->willHavePlant());

        $this->subject->setPlantsByPattern('##');
        $this->subject->getPotZero()->setFuturePatternValue(self::$patterns);
        $this->assertFalse($this->subject->getPotZero()->willHavePlant());
    }

    public function testDoesNotAddPotsOnEmptyEdge()
    {
        $this->subject->setPlantsByPattern('#');

        $this->assertEquals('-4', $this->subject->getPotFurthestToTheLeft()->getIndex());
        $this->assertEquals('.....', $this->subject->getPotFurthestToTheLeft()->getPattern());
        $this->assertEquals('-4', $this->subject->getPotFurthestToTheLeft()->getIndex());

        $this->assertEquals('4', $this->subject->getPotFurthestToTheRight()->getIndex());
        $this->assertEquals('.....', $this->subject->getPotFurthestToTheLeft()->getPattern());
        $this->assertEquals('4', $this->subject->getPotFurthestToTheRight()->getIndex());
    }
}
