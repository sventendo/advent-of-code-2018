<?php

namespace Sventendo\AdventOfCode2018\Day\Day2;

class IdComparer
{
    private $fromId = '';
    private $toId = '';

    public function setFromId(string $fromId): void
    {
        $this->fromId = $fromId;
    }

    public function setToId(string $toId): void
    {
        $this->toId = $toId;
    }

    public function isSimilar(): bool
    {
        if (strlen($this->fromId) !== strlen($this->toId)) {
            return false;
        }

        $nonMatchingLetters = 0;

        foreach (str_split($this->fromId) as $position => $fromLetter) {
            if ($fromLetter !== substr($this->toId, $position, 1)) {
                $nonMatchingLetters++;
            }
        }

        return $nonMatchingLetters < 2;
    }

    public function getOverlappingLetters(): string
    {
        $matchingString = '';

        foreach (str_split($this->fromId) as $position => $fromLetter) {
            if ($fromLetter === substr($this->toId, $position, 1)) {
                $matchingString .= $fromLetter;
            }
        }

        return $matchingString;
    }
}
