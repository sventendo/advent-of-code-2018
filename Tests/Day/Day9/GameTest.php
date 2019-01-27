<?php

namespace Sventendo\AdventOfCode2018\Tests\Day\Day9;

use Sventendo\AdventOfCode2018\Day\Day9\Game;
use Sventendo\AdventOfCode2018\Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * @var Game
     */
    public $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Game::class);
    }

    public function testPlaceMarble()
    {
        $this->subject->setBoard([ 5, 1, 6, 3, 7, 0, 8, 4, 9, 2, 10 ]);
        $this->subject->placeMarble(11);

        $this->assertEquals([ 1, 6, 3, 7, 0, 8, 4, 9, 2, 10, 5, 11 ], $this->subject->getBoard());
    }

    /**
     * @param int $rounds
     * @param array $board
     *
     * @dataProvider getPlayExamples
     */
    public function testPlay(int $rounds, array $board)
    {
        $this->subject->generatePlayers(4);
        $this->subject->play($rounds);
        $this->assertEquals($board, $this->subject->getBoard());
    }

    /**
     * @param int $players
     * @param int $rounds
     * @param int $highScore
     *
     * @dataProvider getBestPlayerScoreExamples
     */
    public function testBestPlayerScore(int $players, int $rounds, int $highScore)
    {
        $this->subject->generatePlayers($players);
        $this->subject->play($rounds);
        $this->assertEquals($highScore, $this->subject->getBestPlayerScore());
    }

    public function getPlayExamples()
    {
        return [
            [ 1, [ 0, 1 ] ],
            [ 3, [ 0, 2, 1, 3 ] ],
            [ 8, [ 4, 2, 5, 1, 6, 3, 7, 0, 8 ] ],
            [ 23, [ 2, 20, 10, 21, 5, 22, 11, 1, 12, 6, 13, 3, 14, 7, 15, 0, 16, 8, 17, 4, 18, 19 ] ],
        ];
    }

    public function getBestPlayerScoreExamples()
    {
        return [
            [ 9, 25, 32 ],
            [ 10, 1618, 8317 ],
            [ 13, 7999, 146373 ],
            [ 17, 1104, 2764 ],
            [ 21, 6111, 54718 ],
            [ 30, 5807, 37305 ],
        ];
    }
}
