<?php

namespace Sventendo\AdventOfCode2018\Day\Day10;

class Printer
{
    protected $xValues = [];
    protected $yValues = [];

    protected $canvas = [];

    public function print(Sky $sky)
    {
        $this->parseValues($sky);
        $top = min($this->yValues);
        $right = max($this->xValues);
        $bottom = max($this->yValues);
        $left = min($this->xValues);

        for ($y = 0; $y < $bottom - $top + 1; $y++) {
            $this->canvas[] = array_fill(0, $right - $left + 1, '.');
        }

        foreach ($sky->getLights() as $light) {
            $positionY = $light->getPositionY() - $top;
            $positionX = $light->getPositionX() - $left;
            $this->canvas[$positionY][$positionX] = 'x';
        }

        foreach ($this->canvas as $line) {
            echo(PHP_EOL . implode('', $line));
        }
        echo(PHP_EOL);
    }

    private function parseValues(Sky $sky)
    {
        $this->xValues = array_map(
            function (Light $light) {
                return $light->getPositionX();
            },
            $sky->getLights()
        );
        $this->yValues = array_map(
            function (Light $light) {
                return $light->getPositionY();
            },
            $sky->getLights()
        );
    }
}
