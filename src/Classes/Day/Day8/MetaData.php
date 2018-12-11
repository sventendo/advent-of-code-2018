<?php

namespace Sventendo\AdventOfCode2018\Day\Day8;

class MetaData
{
    /**
     *
     */
    private $value = 0;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }
}
