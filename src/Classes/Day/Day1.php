<?php

namespace Sventendo\AdventOfCode2018\Day;

class Day1 implements DayInterface
{
    private $data;

    private $frequencies = [ 0 ];

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        return array_sum($this->data);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $sum = 0;
        for ($iteration = 0; $iteration < 1000000; $iteration++) {
            foreach ($this->data as $value) {
                $sum += $value;
                if (in_array($sum, $this->frequencies)) {
                    return $sum;
                } else {
                    $this->frequencies[] = $sum;
                }
            }
        }

        throw new \Exception('No duplication of frequency found after 10,000 iterations :(');
    }

    private function parseInput(string $input)
    {
        $rows = explode(PHP_EOL, $input);

        $data = [];

        foreach($rows as $row) {
            if (!empty(trim($row))) {
                $data[] = intval($row);
            }
        }

        $this->data = $data;
    }
}
