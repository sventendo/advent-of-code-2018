<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day5;

class Reaction
{
    private $polymer = '';

    public function getPolymer(): string
    {
        return $this->polymer;
    }

    public function setPolymer(string $polymer): void
    {
        $this->polymer = $polymer;
    }

    public function start()
    {
        $currentLength = $this->getCurrentLength();
        $lastLength = 0;

        while ($currentLength !== $lastLength) {
            $lastLength = $this->getCurrentLength();
            $units = str_split($this->getPolymer());
            $this->resetPolymer();
            for ($index = 0; $index < $lastLength; $index++) {
                if (isset($units[$index + 1]) && $this->willReact($units[$index], $units[$index + 1])) {
                    $index++;
                } else {
                    $this->addUnit($units[$index]);
                }
            }
            $currentLength = $this->getCurrentLength();
        }

        return $this->getCurrentLength();
    }

    /**
     * @return int
     */
    public function getCurrentLength(): int
    {
        return strlen($this->getPolymer());
    }

    private function resetPolymer(): void
    {
        $this->polymer = '';
    }

    private function addUnit(string $unit)
    {
        $this->polymer .= $unit;
    }

    private function willReact(string $unitA, string $unitB)
    {
        // all lowercase and uppercase letters are 32 values apart.
        return abs(ord($unitA) - ord($unitB)) === 32;
    }

}
