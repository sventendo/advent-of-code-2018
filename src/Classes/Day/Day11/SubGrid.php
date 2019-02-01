<?php
namespace Sventendo\AdventOfCode2018\Day\Day11;

class SubGrid
{
    private $width = 3;
    private $height = 3;
    private $totalPowerLevel = 0;
    private $x = 0;
    private $y = 0;

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getTotalPowerLevel(): int
    {
        return $this->totalPowerLevel;
    }

    public function setTotalPowerLevel(int $totalPowerLevel): void
    {
        $this->totalPowerLevel = $totalPowerLevel;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }
}
