<?php

namespace Sventendo\AdventOfCode2018\Day\Day10;

class Sky
{
    /**
     * @var Light[]
     */
    private $lights = [];
    /**
     * @var int
     */
    private $time = 0;

    public function addLight(Light $light)
    {
        $this->lights[] = $light;
    }

    public function waitForSmallestSizeX()
    {
        $sizeX = $this->getSizeX();
        $this->wait();

        while ($this->getSizeX() < $sizeX) {
            $sizeX = $this->getSizeX();
            $this->wait();
        }

        // we just passed the smallest size
        $this->rewind();
    }

    public function wait()
    {
        foreach ($this->lights as $light) {
            $light->move(1);
        }

        $this->time++;
    }

    public function rewind()
    {
        foreach ($this->lights as $light) {
            $light->move(-1);
        }

        $this->time--;
    }

    /**
     * @return Light[]
     */
    public function getLights(): array
    {
        return $this->lights;
    }

    public function getSizeX()
    {
        $xPositions = array_map(
            function (Light $light) {
                return $light->getPositionX();
            },
            $this->lights
        );

        return max($xPositions) - min($xPositions);
    }

    public function getTime()
    {
        return $this->time;
    }
}
