<?php
namespace Sventendo\AdventOfCode2018\Day\Day11;

class Row
{
    /**
     * @var Cell[]
     */
    private $cells;

    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    public function getCell(int $humanIndex): Cell
    {
        return $this->cells[$humanIndex - 1];
    }
}
