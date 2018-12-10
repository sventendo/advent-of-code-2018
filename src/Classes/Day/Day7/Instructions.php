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
    private function getFirstOfSteps(array $steps): Step
    {
        $steps = $this->sortSteps($steps);
        return $steps[0];
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
}
