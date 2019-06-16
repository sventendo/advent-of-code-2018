<?php

namespace Sventendo\AdventOfCode2018\Day\Day12;

class Pot
{
    public const WITH_PLANT = '#';
    public const NO_PLANT = '.';
    public const PATTERN_EMPTY = '.....';

    protected $index = 0;

    protected $hasPlant = false;

    protected $willHavePlant = false;

    /**
     * @var Pot
     */
    protected $potToTheRight;

    /**
     * @var Pot
     */
    protected $potToTheLeft;

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): void
    {
        $this->index = $index;
    }

    public function setFuturePatternValue(array $patterns): void
    {
        $pattern = $this->getPattern();
        if (preg_match('/[\.#]{5}/', $pattern) === false) {
            throw new \Exception('Unknown pattern: "%s"', $pattern);
        }

        $this->willHavePlant = false;
        if (array_key_exists($pattern, $patterns)) {
            $this->willHavePlant = $patterns[$pattern] === '#';
        }
    }

    public function getPotToTheLeft(bool $createOnDemand = true): ?Pot
    {
        if ($this->potToTheLeft === null && $createOnDemand) {
            $pot = new Pot();
            $pot->setIndex($this->getIndex() - 1);
            $pot->setPotToTheRight($this);
            $this->potToTheLeft = $pot;
        }

        return $this->potToTheLeft;
    }

    public function setPotToTheLeft(Pot $potToTheLeft): void
    {
        $this->potToTheLeft = $potToTheLeft;
    }

    public function getPotTwoToTheLeft(): ?Pot
    {
        return $this->getPotToTheLeft()->getPotToTheLeft();
    }

    public function getPotThreeToTheLeft(): ?Pot
    {
        return $this->getPotToTheLeft()->getPotToTheLeft()->getPotToTheLeft();
    }

    public function getPotToTheRight(bool $createOnDemand = true): ?Pot
    {
        if ($this->potToTheRight === null && $createOnDemand) {
            $pot = new Pot();
            $pot->setIndex($this->getIndex() + 1);
            $pot->setPotToTheLeft($this);
            $this->setPotToTheRight($pot);
        }

        return $this->potToTheRight;
    }

    public function setPotToTheRight(Pot $potToTheRight): void
    {
        $this->potToTheRight = $potToTheRight;
    }

    public function getPotTwoToTheRight(): ?Pot
    {
        return $this->getPotToTheRight()->getPotToTheRight();
    }

    public function getPotThreeToTheRight(): ?Pot
    {
        return $this->getPotToTheRight()->getPotToTheRight()->getPotToTheRight();
    }

    public function getPatternValue(): string
    {
        return $this->hasPlant ? self::WITH_PLANT : self::NO_PLANT;
    }

    public function setPatternValue(string $value)
    {
        if ($value !== self::WITH_PLANT && $value !== self::NO_PLANT) {
            throw new \Exception(sprintf('Invalid pattern value: "%s"', $value));
        }

        $this->hasPlant = $value === self::WITH_PLANT;
    }

    public function getPattern(): string
    {
        // Don't bother creating now pots if they won't create a plant next generation.
        $values = [
            '.',
            '.',
            $this->getPatternValue(),
            '.',
            '.',
        ];
        if ($this->getPotToTheLeft(false) !== null) {
            $values[1] = $this->getPotToTheLeft()->getPatternValue();
            if ($this->getPotToTheLeft()->getPotToTheLeft(false) !== null) {
                $values[0] = $this->getPotToTheLeft()->getPotToTheLeft()->getPatternValue();
            }
        }
        if ($this->getPotToTheRight(false) !== null) {
            $values[3] = $this->getPotToTheRight()->getPatternValue();
            if ($this->getPotToTheRight()->getPotToTheRight(false) !== null) {
                $values[4] = $this->getPotToTheRight()->getPotToTheRight()->getPatternValue();
            }
        }

        return implode('', $values);
    }

    public function hasPlant(): bool
    {
        return $this->hasPlant;
    }

    public function setPlant(bool $hasPlant): void
    {
        $this->hasPlant = $hasPlant;
    }

    public function willHavePlant(): bool
    {
        return $this->willHavePlant;
    }
}
