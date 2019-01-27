<?php

namespace Sventendo\AdventOfCode2018\Day\Day10;

class Vector
{
    /**
     * @var int
     */
    protected $x;
    /**
     * @var int
     */
    protected $y;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
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

    public function add(Vector $vector)
    {
        $this->x = $this->x + $vector->getX();
        $this->y = $this->y + $vector->getY();
    }

    public function subtract(Vector $vector)
    {
        $this->x = $this->x - $vector->getX();
        $this->y = $this->y - $vector->getY();
    }
}
