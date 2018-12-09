<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day6;

class Location
{
    private $x = 0;
    private $y = 0;
    protected $id = '';

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function parseCoordinates(string $coordinates)
    {
        if (preg_match('/^(\d*), (\d*)/', $coordinates, $matches)) {
            $this->setX((int)$matches[1]);
            $this->setY((int)$matches[2]);
        }
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }


}
