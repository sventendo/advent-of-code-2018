<?php

namespace Sventendo\AdventOfCode2018\Day\Day12;

class Row
{
    /**
     * @var Pot
     */
    protected $potZero;

    protected $breedingPatterns = [];

    public function getPotZero(): Pot
    {
        return $this->potZero;
    }

    public function setBreedingPatterns(array $breedingPatterns): void
    {
        $this->breedingPatterns = $breedingPatterns;
    }

    public function setPlantsByPattern(string $pattern)
    {
        $values = str_split($pattern);
        $firstValue = array_shift($values);

        $this->potZero = new Pot();
        $this->potZero->setIndex(0);
        $this->potZero->setPatternValue($firstValue);

        $currentPot = $this->potZero;
        foreach ($values as $value) {
            $currentPot = $currentPot->getPotToTheRight();
            $currentPot->setPatternValue($value);
        }

        $this->expand();
    }

    public function getPattern(): string
    {
        $currentPot = $this->potZero;
        // Pot zero.
        $pattern = $currentPot->getPatternValue();

        // Walk left.
        while ($currentPot->getPotToTheLeft(false)) {
            $currentPot = $currentPot->getPotToTheLeft(false);
            $pattern = $currentPot->getPatternValue() . $pattern;
        }

        $currentPot = $this->potZero;
        // Walk right.
        while ($currentPot->getPotToTheRight(false)) {
            $currentPot = $currentPot->getPotToTheRight(false);
            $pattern .= $currentPot->getPatternValue();
        }

        return $pattern;
    }

    public function getTotalValue(): int
    {
        $totalValue = 0;

        $currentPot = $this->getPotFurthestToTheLeft();

        while ($currentPot->getPotToTheRight(false)) {
            if ($currentPot->hasPlant()) {
                $totalValue += $currentPot->getIndex();
            }
            $currentPot = $currentPot->getPotToTheRight(false);
        }

        if ($currentPot->hasPlant()) {
            $totalValue += $currentPot->getIndex();
        }

        return $totalValue;
    }

    public function wait($generations = 1)
    {
        for ($i = 0; $i < $generations; $i++) {
            $this->calculateFuturePatternValues();
            $this->updatePots();
        }
    }

    public function getPotFurthestToTheLeft(): Pot
    {
        $pot = $this->potZero;
        while ($pot->getPotToTheLeft(false)) {
            $pot = $pot->getPotToTheLeft(false);
        }

        return $pot;
    }

    public function getPotFurthestToTheRight(): Pot
    {
        $pot = $this->potZero;
        while ($pot->getPotToTheRight(false)) {
            $pot = $pot->getPotToTheRight(false);
        }

        return $pot;
    }

    protected function calculateFuturePatternValues(): void
    {
        // Move to center.
        $currentPot = $this->getPotZero();
        $currentPot->setFuturePatternValue($this->breedingPatterns);

        // Walk left.
        while ($currentPot->getPotToTheLeft(false) !== null) {
            $currentPot = $currentPot->getPotToTheLeft();
            // Pad left edge.
            if ($currentPot->hasPlant()) {
                $currentPot->getPotToTheLeft()
                    ->getPotToTheLeft()
                    ->getPotToTheLeft()
                    ->getPotToTheLeft();
            }
            $currentPot->setFuturePatternValue($this->breedingPatterns);
        }

        // Move back to center.
        $currentPot = $this->getPotZero();

        // Walk right.
        while ($currentPot->getPotToTheRight(false) !== null) {
            $currentPot = $currentPot->getPotToTheRight();
            // Pad right edge.
            if ($currentPot->hasPlant()) {
                $currentPot->getPotToTheRight()
                    ->getPotToTheRight()
                    ->getPotToTheRight()
                    ->getPotToTheRight();
            }
            $currentPot->setFuturePatternValue($this->breedingPatterns);
        }
    }

    protected function updatePots(): void
    {
        $currentPot = $this->getPotFurthestToTheLeft();
        while ($currentPot->getPotToTheRight(false) !== null) {
            $currentPot->setPlant($currentPot->willHavePlant());
            $currentPot = $currentPot->getPotToTheRight(false);
        }
    }

    private function expand(): void
    {
        $currentPot = $this->getPotFurthestToTheLeft();
        $currentPot->getPotToTheLeft()
            ->getPotToTheLeft()
            ->getPotToTheLeft()
            ->getPotToTheLeft();

        $currentPot = $this->getPotFurthestToTheRight();
        $currentPot->getPotToTheRight()
            ->getPotToTheRight()
            ->getPotToTheRight()
            ->getPotToTheRight();
    }
}
