<?php
namespace Sventendo\AdventOfCode2018\Day\Day11;

class Cell
{
    /**
     * @var int
     */
    private $powerLevel = 0;

    public function getPowerLevel(): int
    {
        return $this->powerLevel;
    }

    public function setPowerLevel(int $powerLevel): void
    {
        $this->powerLevel = $powerLevel;
    }
}
