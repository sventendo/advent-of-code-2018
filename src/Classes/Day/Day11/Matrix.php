<?php
namespace Sventendo\AdventOfCode2018\Day\Day11;

class Matrix
{
    /**
     * @var array[]
     */
    private $rows = [];

    public function initialize(int $rows, int $columns): void
    {
        for ($y = 0; $y < $rows; $y++) {
            $this->$rows[] = array_fill(0, $columns, 0);
        }
    }

    public function setCoordinate(int $x, int $y, int $value): void
    {
        $this->rows[$y][$x] = $value;
    }

    public function getCoordinate(int $x, int $y): int
    {
        if ($x < 0 || $y < 0) {
            return 0;
        }

        return $this->rows[$y][$x];
    }

    public function applyPowerLevelToSubGrid(SubGrid $subGrid)
    {
        $powerLevel = $this->getPowerLevelForSubGrid($subGrid);

        $subGrid->setTotalPowerLevel($powerLevel);
    }

    /**
     * @param SubGrid $subGrid
     * @return int
     */
    public function getPowerLevelForSubGrid(SubGrid $subGrid): int
    {
        $left = $subGrid->getX() - 1;
        $top = $subGrid->getY() - 1;
        $right = $left + $subGrid->getWidth();
        $bottom = $top + $subGrid->getHeight();

        $powerLevel = $this->getCoordinate($left, $top)
            + $this->getCoordinate($right, $bottom)
            - $this->getCoordinate($right, $top)
            - $this->getCoordinate($left, $bottom);

        return $powerLevel;
    }

    public function setCoordinateByPriorValues(int $x, int $y, int $powerLevel)
    {
        $this->setCoordinate(
            $x,
            $y,
            $powerLevel
            + $this->getCoordinate($x, $y - 1)
            + $this->getCoordinate($x - 1, $y)
            - $this->getCoordinate($x - 1, $y - 1)
        );
    }
}
