<?php

namespace Sventendo\AdventOfCode2018\Day\Day3;

class Claim
{
    private $id = '';
    private $left = 0;
    private $top = 0;
    private $width = 0;
    private $height = 0;

    public function getLeft(): int
    {
        return $this->left;
    }

    public function getTop(): int
    {
        return $this->top;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function parseClaim(string $claim): void
    {
        if (preg_match('/#(\d*)\s@\s(\d*),(\d*):\s(\d*)x(\d*)/', $claim, $matches)) {
            $this->id = $matches[1];
            $this->left = $matches[2];
            $this->top = $matches[3];
            $this->width = $matches[4];
            $this->height = $matches[5];
        }
    }

    public function getRight(): int
    {
        return $this->getLeft() + $this->getWidth();
    }

    public function getBottom(): int
    {
        return $this->getTop() + $this->getHeight();
    }

    public function getId()
    {
        return $this->id;
    }

}
