<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class Log
{
    /**
     * @var LogEntry[]
     */
    private $entries = [];

    public function addEntry(LogEntry $entry)
    {
        $this->entries[] = $entry;
    }

    public function sortEntries()
    {
        usort(
            $this->entries,
            function (LogEntry $a, LogEntry $b) {
                return $a->getTimestamp() > $b->getTimestamp();
            }
        );
    }

    /**
     * @return LogEntry[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function hasEntries(): bool
    {
        return \count($this->entries) > 0;
    }
}
