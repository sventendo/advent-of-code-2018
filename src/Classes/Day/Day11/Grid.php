<?php
namespace Sventendo\AdventOfCode2018\Day\Day11;

use Illuminate\Container\Container;

class Grid extends Matrix
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var Row[]
     */
    private $rows = [];
    /**
     * @var int
     */
    private $serialNumber = 0;
    /**
     * @var int
     */
    private $subGridWidth = 3;
    /**
     * @var int
     */
    private $subGridHeight = 3;
    /**
     * @var int
     */
    private $gridWidth = 300;
    /**
     * @var int
     */
    private $gridHeight = 300;
    /**
     * @var Matrix
     */
    private $summedAreaTable;
    /**
     * @var SubGrid
     */
    private $largestSubGrid;

    public function __construct(
        Container $container,
        Matrix $summedAreaTable
    ) {
        $this->container = $container;
        $this->summedAreaTable = $summedAreaTable;
    }

    public function getSummedAreaTable(): Matrix
    {
        return $this->summedAreaTable;
    }

    public function getRow(int $humanIndex): Row
    {
        return $this->rows[$humanIndex - 1];
    }

    public function initializeCells(int $rows = null, int $columns = null)
    {
        $rows = $rows ?? $this->gridHeight;
        $columns = $columns ?? $this->gridWidth;

        for ($y = 1; $y <= $rows; $y++) {
            /** @var Row $row */
            $row = $this->container->make(Row::class);
            $this->addRow($row);
            for ($x = 1; $x <= $columns; $x++) {
                /** @var Cell $cell */
                $cell = $this->container->make(Cell::class);
                $cell->setPowerLevel($this->calculatePowerLevel($x, $y));
                $row->addCell($cell);
            }
        }
    }

    public function setSerialNumber(int $serialNumber): void
    {
        $this->serialNumber = $serialNumber;
    }

    public function calculatePowerLevel(int $x, int $y)
    {
        // The long way:
        // $rackId = $x + 10;
        // $powerLevel = $rackId * $y;
        // $powerLevel = $powerLevel + $this->serialNumber;
        // $powerLevel = $powerLevel * $rackId;
        // $powerLevel = $this->getDecimalPosition($powerLevel, 2);
        // $powerLevel = $powerLevel - 5;

        return $this->getDecimalPosition(((($x + 10) * $y) + $this->serialNumber) * ($x + 10), 2) - 5;
    }

    /**
     * Get the value of the digit at the given position.
     * In the number 243, the '3' would be at position 0, the '4' at position 1, etc.
     * Position 4 would result in 0.
     *
     * @param int $number
     * @param int $position
     * @return int
     */
    public function getDecimalPosition(int $number, int $position)
    {
        return (int) substr(strrev((string) $number), $position, 1);
    }

    public function parseSubGrids()
    {
        for ($y = 0; $y < $this->gridWidth - $this->subGridWidth; $y++) {
            for ($x = 0; $x < $this->gridHeight - $this->subGridHeight; $x++) {
                $subGrid = $this->generateSubGrid($x, $y);
                if ($this->largestSubGrid === null) {
                    $this->largestSubGrid = $subGrid;
                }
                if ($this->largestSubGrid->getTotalPowerLevel() < $subGrid->getTotalPowerLevel()) {
                    $this->largestSubGrid = $subGrid;
                }
            }
        }
    }

    public function setSubGridSize(int $size)
    {
        $this->subGridWidth = $size;
        $this->subGridHeight = $size;
    }

    public function getLargestSubGrid()
    {
        return $this->largestSubGrid;
    }

    /**
     * @see https://en.wikipedia.org/wiki/Summed-area_table
     */
    public function generateSummedAreaTable()
    {
        for ($y = 0; $y < $this->gridHeight; $y++) {
            for ($x = 0; $x < $this->gridWidth; $x++) {
                $this->summedAreaTable->setCoordinateByPriorValues($x, $y, $this->getCellAt($x, $y)->getPowerLevel());
            }
        }
    }

    private function addRow(Row $row): void
    {
        $this->rows[] = $row;
    }

    private function generateSubGrid(int $x, int $y): SubGrid
    {
        /** @var SubGrid $subGrid */
        $subGrid = $this->container->make(SubGrid::class);
        $subGrid->setX($x);
        $subGrid->setY($y);
        $subGrid->setWidth($this->subGridWidth);
        $subGrid->setHeight($this->subGridHeight);

        $this->summedAreaTable->applyPowerLevelToSubGrid($subGrid);

        return $subGrid;
    }

    private function getCellAt(int $x, int $y): Cell
    {
        return $this->getRow($y + 1)->getCell($x + 1);
    }
}
