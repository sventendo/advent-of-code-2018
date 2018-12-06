<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class Shift
{
    private $guardId = 0;

    private $timeAsleep = 0;

    private $log;

    private $lastTimeAwake = 0;

    private $lastTimeAsleep = 0;

    public function __construct(
        Log $log
    ) {
        $this->log = $log;
    }

    public function getGuardId(): int
    {
        return $this->guardId;
    }

    public function setGuardId(int $guardId): void
    {
        $this->guardId = $guardId;
    }

    public function getTimeAsleep(): int
    {
        return $this->timeAsleep;
    }

    public function setTimeAsleep(int $timeAsleep): void
    {
        $this->timeAsleep = $timeAsleep;
    }

    public function addEntry(LogEntry $entry)
    {
        $this->log->addEntry($entry);
    }

    public function getLastTimeAwake(): int
    {
        return $this->lastTimeAwake;
    }

    public function setLastTimeAwake(int $lastTimeAwake): void
    {
        $this->lastTimeAwake = $lastTimeAwake;
    }

    public function getLastTimeAsleep(): int
    {
        return $this->lastTimeAsleep;
    }

    public function setLastTimeAsleep(int $lastTimeAsleep): void
    {
        $this->lastTimeAsleep = $lastTimeAsleep;
    }

    public function hasEntries(): bool
    {
        return $this->log->hasEntries();
    }

    public function updateTimeAsleep()
    {
        $this->timeAsleep += $this->getLastTimeAsleep() - $this->getLastTimeAwake();
    }

    public function getMinutesArray()
    {
        $minutesArray = array_fill(0, 60, 0);
        $lastTimeAwake = 0;
        foreach ($this->log->getEntries() as $entry) {
            if ($entry->getType() === LogEntry::TYPE_ASLEEP) {
                $lastTimeAwake = $entry->getMinutes();
            } elseif ($entry->getType() === LogEntry::TYPE_AWAKE) {
                $lastTimeAsleep = $entry->getMinutes();
                $sleepDuration = $lastTimeAsleep - $lastTimeAwake;
                array_splice($minutesArray, $lastTimeAwake, $sleepDuration, array_fill(0, $sleepDuration, 1));
            }
        }

        return $minutesArray;
    }
}
