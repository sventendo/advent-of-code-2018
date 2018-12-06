<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class Guard
{
    private $id = 0;
    /**
     * @var Shift[]
     */
    private $shifts = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getShifts(): array
    {
        return $this->shifts;
    }

    public function addShift(Shift $shift): void
    {
        $this->shifts[] = $shift;
    }
}
