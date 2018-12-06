<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day;

use Sventendo\AdventOfCode2018\Day\Day5\Reaction;

class Day5 extends Day implements DayInterface
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        /** @var Reaction $reaction */
        $reaction = $this->container->make(Reaction::class);
        $reaction->setPolymer($this->data);
        $reaction->start();

        return (string) $reaction->getCurrentLength();
    }

    public function secondPuzzle($input): string
    {
        return '';
    }

    private function parseInput(string $input)
    {
        $this->data = trim($input);
    }
}
