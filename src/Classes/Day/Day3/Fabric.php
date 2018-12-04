<?php

namespace Sventendo\AdventOfCode2018\Day\Day3;

class Fabric
{
    private $matrix = [];

    public function __construct()
    {
        foreach (range(0, 1000) as $row) {
            $this->matrix[$row] = array_fill(0, 1000, 0);
        }
    }

    public function addClaim(Claim $claim)
    {
        for ($x = $claim->getLeft(); $x < $claim->getRight(); $x++) {
            for ($y = $claim->getTop(); $y < $claim->getBottom(); $y++) {
                $this->matrix[$x][$y]++;
            }
        }
    }

    public function getCriticalInches(): int
    {
        $criticalInches = 0;
        foreach ($this->matrix as $row) {
            foreach ($row as $squareInch) {
                if ($squareInch > 1) {
                    $criticalInches++;
                }
            }
        }

        return $criticalInches;
    }

    public function isUndisputed(Claim $claim)
    {
        for ($x = $claim->getLeft(); $x < $claim->getRight(); $x++) {
            for ($y = $claim->getTop(); $y < $claim->getBottom(); $y++) {
                if ($this->matrix[$x][$y] !== 1) {
                    return false;
                }
            }
        }

        return true;
    }
}
