<?php

namespace Sventendo\AdventOfCode2018\Day\Day7;

class Instructions
{
    public const PATTERN = '/\s([A-Z])\s.*\s([A-Z])\s/';
    /**
     * @var Step[]
     */
    private $steps = [];
    /**
     * @var Step[]
     */
    private $nextSteps = [];
    /**
     * @var string[]
     */
    private $route = [];
    /**
     * @var Workforce
     */
    private $workforce;
    /**
     * @var int
     */
    private $timer = 0;

    public function __construct(
        Workforce $workforce
    ) {
        $this->workforce = $workforce;
    }

    public function getRoute(): string
    {
        return implode('', $this->getIds($this->route));
    }

    public function follow(): void
    {
        $this->nextSteps = $this->getInitialSteps();

        while (\count($this->nextSteps)) {
            $this->nextSteps = $this->sortSteps($this->nextSteps);
            foreach ($this->nextSteps as $nextStepCandidate) {
                if ($this->stepsFollowed($nextStepCandidate->getPrevious())) {
                    $this->addStepToRoute($nextStepCandidate);
                    $this->removeFromNextSteps($nextStepCandidate);
                    $this->addToNextSteps($nextStepCandidate->getNext());
                    break;
                }
            }
        }
    }

    public function followWithWorkforce(): void
    {
        $this->nextSteps = $this->getInitialSteps();

        while ($this->notFinishedYet()) {
            $this->workforce->makeTimePass();
            $finishedSteps = $this->getFinishedSteps();
            $this->addStepsToRoute($finishedSteps);
            foreach ($finishedSteps as $step) {
                $this->addToNextSteps($step->getNext());
            }

            $this->nextSteps = $this->sortSteps($this->nextSteps);
            foreach ($this->nextSteps as $nextStepCandidate) {
                if ($this->workforce->hasFreeWorkers() && $this->stepsFollowed($nextStepCandidate->getPrevious())) {
                    $this->workforce->assignStepToAnyFreeWorker($nextStepCandidate);
                    $this->removeFromNextSteps($nextStepCandidate);
                }
            }
            if ($this->notFinishedYet()) {
                $this->timer++;
            }
        }
    }

    public function addStep(Step $step): void
    {
        $this->steps[] = $step;
    }

    public function parseInstruction($row): void
    {
        if (preg_match(self::PATTERN, $row, $matches)) {
            $stepPrevious = $this->getStepById($matches[1]);
            $stepNext = $this->getStepById($matches[2]);
            $stepPrevious->addNext($stepNext);
            $stepNext->addPrevious($stepPrevious);
        }
    }

    public function initializeWorkforce(int $numberOfWorkers)
    {
        $this->workforce->initializeWorkforce($numberOfWorkers);
    }

    public function getTimer(): int
    {
        return $this->timer;
    }

    private function addStepToRoute(Step $step)
    {
        $this->route[] = $step;
    }

    private function getStepById(string $id): Step
    {
        $steps = array_filter(
            $this->steps,
            function (Step $step) use ($id) {
                return $step->getId() === $id;
            }
        );
        return array_slice($steps, 0, 1)[0];
    }

    private function getInitialSteps(): array
    {
        $previous = [];
        $next = [];
        foreach ($this->steps as $step) {
            $previous = array_merge($previous, $this->getIds($step->getPrevious()));
            $next = array_merge($next, $this->getIds($step->getNext()));
        }

        $previous = array_unique($previous);
        $next = array_unique($next);

        $initialStepsIds = array_diff($previous, $next);

        $initialSteps = [];
        foreach ($initialStepsIds as $id) {
            $initialSteps[] = $this->getStepById($id);
        }

        return $initialSteps;
    }

    /**
     * @param Step[] $steps
     * @return mixed
     */
    private function sortSteps(array $steps): array
    {
        usort(
            $steps,
            function (Step $stepA, Step $stepB) {
                return $stepA->getId() > $stepB->getId();
            }
        );
        return $steps;
    }

    /**
     * @param Step[] $steps
     */
    private function addToNextSteps(array $steps): void
    {
        foreach ($steps as $step) {
            if (in_array($step->getId(), $this->getIds($this->nextSteps)) === false) {
                $this->nextSteps[] = $step;
            }
        }
    }

    /**
     * @param Step[] $steps
     * @return bool
     */
    private function stepsFollowed(array $steps): bool
    {
        return \count($steps) === 0 || \count(array_diff($this->getIds($steps), $this->getIds($this->route))) === 0;
    }

    private function removeFromNextSteps(Step $step): void
    {
        if (($key = array_search($step, $this->nextSteps, true)) !== false) {
            unset($this->nextSteps[$key]);
        }
    }

    /**
     * @param Step[] $steps
     * @return array
     */
    private function getIds(array $steps): array
    {
        return array_map(
            function (Step $step) {
                return $step->getId();
            },
            $steps
        );
    }

    private function addStepsToRoute($steps): void
    {
        foreach ($steps as $step) {
            $this->addStepToRoute($step);
        }
    }

    /**
     * @return Step[]
     */
    private function getFinishedSteps(): array
    {
        $finishedSteps = $this->workforce->getFinishedSteps();
        $finishedSteps = $this->sortSteps($finishedSteps);
        return $finishedSteps;
    }

    /**
     * @return bool
     */
    private function notFinishedYet(): bool
    {
        return \count($this->route) < \count($this->steps);
    }
}
