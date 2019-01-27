<?php

namespace Sventendo\AdventOfCode2018\Day\Day10;

class Light
{
    /**
     * @var Vector
     */
    protected $position;
    /**
     * @var Vector
     */
    protected $velocity;

    public function __construct(Vector $position = null, Vector $velocity = null)
    {
        $position = $position ?? new Vector();
        $this->position = $position;

        $velocity = $velocity ?? new Vector();
        $this->velocity = $velocity;
    }

    public function move(int $steps)
    {
        if ($steps > 0) {
            $this->position->add($this->velocity);
        } elseif ($steps < 0) {
            $this->position->subtract($this->velocity);
        }
    }

    public function getPositionX()
    {
        return $this->position->getX();
    }

    public function getPositionY()
    {
        return $this->position->getY();
    }
}
