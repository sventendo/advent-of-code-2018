<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day7;

class Worker
{
    /**
     * @var Step
     */
    private $assignedStep;

    /**
     * @var int
     */
    private $countdown = 0;

    public function assignStep(Step $step): void
    {
        $this->assignedStep = $step;
        $this->countdown = $step->getTimeNeeded();
    }

    public function makeTimePass(): void
    {
        if ($this->countdown > 0) {
            $this->countdown--;
        }
    }

    public function isFree(): bool
    {
        return is_null($this->assignedStep);
    }

    public function isDone(): bool
    {
        return !is_null($this->assignedStep) && $this->countdown === 0;
    }

    public function getAssignedStep()
    {
        return $this->assignedStep;
    }

    public function relieve()
    {
        $this->assignedStep = null;
    }
}
