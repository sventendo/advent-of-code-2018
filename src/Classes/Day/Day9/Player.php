<?php

namespace Sventendo\AdventOfCode2018\Day\Day9;

class Player
{
    private $score = 0;

    public function addScore(int $score)
    {
        $this->score += $score;
    }

    public function getScore()
    {
        return $this->score;
    }
}
