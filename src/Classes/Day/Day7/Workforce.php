<?php

namespace Sventendo\AdventOfCode2018\Day\Day7;

use Illuminate\Container\Container;

class Workforce
{
    /**
     * @var Worker[]
     */
    private $workers;
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function initializeWorkforce(int $numberOfWorkers)
    {
        for ($i = 0; $i < $numberOfWorkers; $i++) {
            $this->workers[] = $this->container->make(Worker::class);
        }
    }

    public function assignStepToAnyFreeWorker(Step $step)
    {
        $worker = $this->getFirstFreeWorker();
        if ($worker !== null) {
            $worker->assignStep($step);
        }
    }

    public function hasFreeWorkers()
    {
        $freeWorkers = $this->getFreeWorkers();

        return \count($freeWorkers) > 0;
    }

    public function makeTimePass()
    {
        foreach ($this->workers as $worker) {
            $worker->makeTimePass();
        }
    }

    /**
     * @return array
     */
    public function getFinishedSteps(): array
    {
        $finishedWorkers = $this->getFinishedWorkers();

        $finishedSteps = [];
        foreach ($finishedWorkers as $worker) {
            $finishedSteps[] = $worker->getAssignedStep();
            $worker->relieve();
        }

        return $finishedSteps;
    }

    /**
     * @return array
     */
    private function getFreeWorkers(): array
    {
        $freeWorkers = array_filter(
            $this->workers,
            function (Worker $worker) {
                return $worker->isFree();
            }
        );
        return $freeWorkers;
    }

    private function getFirstFreeWorker(): ?Worker
    {
        $freeWorker = null;
        $freeWorkers = $this->getFreeWorkers();

        if (\count($freeWorkers) > 0) {
            $freeWorker = array_slice($freeWorkers, 0, 1)[0];
        }

        return $freeWorker;
    }

    /**
     * @return Worker[]
     */
    private function getFinishedWorkers()
    {
        $finishedWorkers = array_filter(
            $this->workers,
            function (Worker $worker) {
                return $worker->isDone();
            }
        );
        return $finishedWorkers;
    }

}
