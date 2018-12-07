<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day;

use Sventendo\AdventOfCode2018\Day\Day5\Reaction;

class Day5 extends Day implements DayInterface
{
    /**
     * @var int[]
     */
    private $optimizedPolymerLengths = [];

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        /** @var Reaction $reaction */
        $reaction = $this->container->make(Reaction::class);
        $reaction->setPolymer($this->data);
        $reaction->startWithPattern();

        return (string) $reaction->getCurrentLength();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        /** @var Reaction $reaction */
        $reaction = $this->container->make(Reaction::class);

        for ($unitIndex = ord('a'); $unitIndex < ord('z'); $unitIndex++) {
            $removedUnit = chr($unitIndex);
            $reaction->setPolymer($this->data);
            $reaction->removeUnit(chr($unitIndex));
            $reaction->startWithPattern();
            $this->optimizedPolymerLengths[$removedUnit] = $reaction->getCurrentLength();
        }

        return (string) min($this->optimizedPolymerLengths);
    }

    private function parseInput(string $input)
    {
        $this->data = trim($input);
    }
}
