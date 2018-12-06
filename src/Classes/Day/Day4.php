<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day4\GoodMinute;
use Sventendo\AdventOfCode2018\Day\Day4\Guard;
use Sventendo\AdventOfCode2018\Day\Day4\Log;
use Sventendo\AdventOfCode2018\Day\Day4\LogEntry;
use Sventendo\AdventOfCode2018\Day\Day4\Shift;
use Sventendo\AdventOfCode2018\Day\Day4\Staff;

class Day4 extends Day implements DayInterface
{
    /**
     * @var Log
     */
    private $log;

    /**
     * @var Shift[]
     */
    private $shifts = [];
    /**
     * @var int[]
     */
    private $sleepHighscore = [];
    /**
     * @var Staff
     */
    private $guards;

    public function __construct(
        Container $container,
        Staff $guards
    ) {
        parent::__construct($container);
        $this->guards = $guards;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        unset($input);

        $this->log->sortEntries();
        $this->collectShifts();
        $this->collectGuards();

        $guardMostAsleep = $this->getGuardMostAsleep();
        $safestMinute = $this->getSafestMinuteForGuard($guardMostAsleep);

        return (string) ($safestMinute->getGuard() * $safestMinute->getMinute());
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        unset($input);

        $this->log->sortEntries();
        $this->collectShifts();
        $this->collectGuards();

        $safestMinute = $this->getSafestMinute();

        return (string) ($safestMinute->getGuard() * $safestMinute->getMinute());
    }

    private function parseInput($input)
    {
        $this->log = $this->container->make(Log::class);
        $rows = explode(PHP_EOL, $input);

        foreach ($rows as $row) {
            if (!empty(trim($row))) {
                $logEntry = $this->container->make(LogEntry::class);
                $logEntry->parseEntry($row);
                $this->log->addEntry($logEntry);
            }
        }
    }

    private function collectShifts()
    {
        /** @var Shift $shift */
        $shift = $this->container->make(Shift::class);

        foreach ($this->log->getEntries() as $entry) {
            if ($entry->isStartOfShift()) {
                if ($shift->hasEntries()) {
                    // wrap this shift up...
                    $this->clockTimeAsleep($shift);
                    $this->shifts[] = $shift;
                }
                // ...and start a new shift
                /** @var Shift $shift */
                $shift = $this->container->make(Shift::class);
                $shift->setGuardId($entry->getGuard());
            } else {
                $shift->addEntry($entry);
                if ($entry->getType() === LogEntry::TYPE_ASLEEP) {
                    $shift->setLastTimeAwake($entry->getMinutes());
                } elseif ($entry->getType() === LogEntry::TYPE_AWAKE) {
                    $shift->setLastTimeAsleep($entry->getMinutes());
                    $shift->updateTimeAsleep();
                }
            }
        }
    }

    private function clockTimeAsleep(Shift $shift)
    {
        if (!array_key_exists($shift->getGuardId(), $this->sleepHighscore)) {
            $this->sleepHighscore[$shift->getGuardId()] = 0;
        }
        $this->sleepHighscore[$shift->getGuardId()] += $shift->getTimeAsleep();
    }

    private function collectGuards(): void
    {
        foreach ($this->shifts as $shift) {
            $guardId = $shift->getGuardId();
            if ($this->guards->hasGuard($guardId) === false) {
                /** @var Guard $guard */
                $guard = $this->container->make(Guard::class);
                $guard->setId($guardId);
                $this->guards->addGuard($guard);
            }

            $guard = $this->guards->getGuardById($guardId);
            $guard->addShift($shift);
        }
    }

    private function getGuardMostAsleep(): Guard
    {
        $guardId = $this->getKeyWithHighestValue($this->sleepHighscore);
        return $this->guards->getGuardById($guardId);
    }

    private function getKeyWithHighestValue(array $array): int
    {
        $highestValues = array_keys($array, max($array));

        // if it's a tie we return the first key
        return $highestValues[0];
    }

    private function getSafestMinuteForGuard(Guard $guard): GoodMinute
    {
        /** @var GoodMinute $safestMinute */
        $safestMinute = $this->container->make(GoodMinute::class);
        $minutes = array_fill(0, 60, 0);
        $shifts = $this->getShiftsOfGuard($guard->getId());
        foreach ($shifts as $shift) {
            $minutes = array_map(
                function (...$arrays) {
                    return array_sum($arrays);
                },
                $minutes,
                $shift->getMinutesArray()
            );
        }

        $safestMinute->setGuard($guard->getId());
        $safestMinute->setMinute($this->getKeyWithHighestValue($minutes));
        $safestMinute->setTimesAsleep($minutes[$safestMinute->getMinute()]);

        return $safestMinute;
    }

    /**
     * @param int $guardId
     * @return Shift[]
     */
    private function getShiftsOfGuard(int $guardId): array
    {
        return $this->guards->getGuardById($guardId)->getShifts();
    }

    private function getSafestMinute(): GoodMinute
    {
        $goodMinutes = [];
        foreach ($this->guards as $guard) {
            $goodMinutes[] = $this->getSafestMinuteForGuard($guard);
        }

        usort(
            $goodMinutes,
            function (GoodMinute $a, GoodMinute $b) {
                return $a->getTimesAsleep() < $b->getTimesAsleep();
            }
        );

        return $goodMinutes[0];
    }
}
