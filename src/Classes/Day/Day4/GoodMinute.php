<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class GoodMinute
{
    private $guard = 0;
    private $minute = 0;
    private $timesAsleep = 0;

    public function getGuard(): int
    {
        return $this->guard;
    }

    public function setGuard(int $guard): void
    {
        $this->guard = $guard;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): void
    {
        $this->minute = $minute;
    }

    public function getTimesAsleep(): int
    {
        return $this->timesAsleep;
    }

    public function setTimesAsleep(int $timesAsleep): void
    {
        $this->timesAsleep = $timesAsleep;
    }
}
