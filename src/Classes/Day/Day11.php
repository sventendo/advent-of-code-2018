<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day11\Grid;

class Day11 extends Day implements DayInterface
{
    /**
     * @var Grid
     */
    private $grid;

    public function __construct(
        Container $container,
        Grid $grid
    ) {
        parent::__construct($container);
        $this->grid = $grid;
    }

    public function firstPuzzle($input): string
    {
        $this->grid->setSerialNumber($input);
        $this->grid->initializeCells(300, 300);
        $this->grid->generateSummedAreaTable();
        $this->grid->parseSubGrids();
        $subGrid = $this->grid->getLargestSubGrid();

        return ($subGrid->getX() + 1) . ',' . ($subGrid->getY() + 1);
    }

    public function secondPuzzle($input): string
    {
        $this->grid->setSerialNumber($input);
        $this->grid->initializeCells(300, 300);
        $this->grid->generateSummedAreaTable();
        for ($size = 3; $size < 300; $size++) {
            $this->grid->setSubGridSize($size);
            $this->grid->parseSubGrids();
        }
        $subGrid = $this->grid->getLargestSubGrid();

        return ($subGrid->getX() + 1) . ',' . ($subGrid->getY() + 1) . ',' . $subGrid->getWidth();
    }
}
