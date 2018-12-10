<?php

namespace Sventendo\AdventOfCode2018\Day\Day7;

class Step
{
    private $id = '';
    /**
     * @var Step[]
     */
    private $previous = [];
    /**
     * @var Step[]
     */
    private $next = [];

    public function addNext(Step $step)
    {
        $this->next[] = $step;
    }

    public function hasPrevious(): bool
    {
        return \count($this->previous) > 0;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function addPrevious(Step $step)
    {
        $this->previous[] = $step;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getTimeNeeded()
    {
        return 60 + (ord($this->id) - ord('A') + 1);
    }
}
