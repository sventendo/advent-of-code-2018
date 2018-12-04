<?php

namespace Sventendo\AdventOfCode2018\Day\Day2;

class BoxId
{
    private $id = '';
    private $duplicates = [];
    private $triplets = [];

    public function setId(string $id): void
    {
        $this->id = $id;
    }


    public function parseId(): void
    {

        $letters = str_split($this->id);
        $dictionary = [];

        foreach ($letters as $letter) {
            if (!array_key_exists($letter, $dictionary)) {
                $dictionary[$letter] = 0;
            }
            $dictionary[$letter]++;
        }

        foreach ($dictionary as $letter => $count) {
            if ($count === 2) {
                $this->duplicates[] = $letter;
            }
            if ($count === 3) {
                $this->triplets[] = $letter;
            }
        }
    }

    public function hasDuplicates(): bool
    {
        return \count($this->duplicates) > 0;
    }
    public function hasTriplets(): bool
    {
        return \count($this->triplets) > 0;
    }
}
