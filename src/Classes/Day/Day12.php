<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day12\Row;

class Day12 extends Day implements DayInterface
{
    /**
     * @var
     */
    private $row;

    public function __construct(
        Container $container,
        Row $row
    ) {
        parent::__construct($container);
        $this->row = $row;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        $this->row->wait(110);

        return (string) $this->row->getTotalValue();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        // Beginning with generation 102 (or so), the pattern is stable but shifts 1 pot to the right
        // with every generation:
        // 102: [...]...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###..###..###...
        // 103: [...]....###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###...###..###..###...
        // The difference in check sum value is exactly 69 for every generation after this.

        // So get the value of, say generation 110 and add 69 for the rest of the generations.
        $this->row->wait(110);
        $checkSum = $this->row->getTotalValue();
        $checkSum += (50000000000 - 110) * 69;

        return (string) $checkSum;
    }

    private function parseInput(string $input): void
    {
        $lines = explode(PHP_EOL, $input);

        // First line is the initial state.
        $initialState = array_shift($lines);
        $this->row->setPlantsByPattern($initialState);

        $breedingPatterns = [];
        foreach ($lines as $line) {
            if (preg_match('/([\.#]{5}) => #/', $line, $matches)) {
                $breedingPatterns[$matches[1]] = '#';
            }
        }
        $this->row->setBreedingPatterns($breedingPatterns);
    }
}
