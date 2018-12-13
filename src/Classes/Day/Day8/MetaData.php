<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day8;

class MetaData
{
    /**
     * @var int
     */
    private $value = 0;

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = (int) $value;
    }
}
