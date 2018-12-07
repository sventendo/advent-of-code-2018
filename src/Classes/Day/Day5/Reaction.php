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

    public function startWithArray()
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

    public function startWithPattern()
    {
        $currentLength = $this->getCurrentLength();
        $lastLength = 0;

        $pattern = $this->buildPattern();

        while($currentLength !== $lastLength) {
            $lastLength = $this->getCurrentLength();
            $this->polymer = preg_replace($pattern, '', $this->polymer);
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

    public function removeUnit(string $chr)
    {
        $pattern = '/[' . $chr . strtoupper($chr) . ']/';
        $this->polymer = preg_replace($pattern, '', $this->polymer);
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

    private function buildPattern()
    {
        $patternBits = [];
        for ($unitValue = ord('a'); $unitValue <= ord('z'); $unitValue++) {
            $unitCombo = chr($unitValue) . chr($unitValue - 32);
            $patternBits[] = $unitCombo;
            $patternBits[] = strrev($unitCombo);
        }

        return '/' . implode('|', $patternBits) . '/';
    }
}
