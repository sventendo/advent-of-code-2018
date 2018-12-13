<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day8;

class Node
{
    /**
     * @var Node[]
     */
    private $children = [];

    /**
     * @var MetaData[]
     */
    private $metaData = [];
    /**
     * @var int
     */
    private $value = 0;

    public function addChild(Node $child): void
    {
        $this->children[] = $child;
    }

    public function addMetaData(MetaData $metaData): void
    {
        $this->metaData[] = $metaData;
    }

    public function collectValue(): int
    {
        if ($this->hasChildren()) {
            $value = 0;
            foreach ($this->metaData as $metaData) {
                if ($this->hasChild($metaData->getValue())) {
                    $value += $this->getChild($metaData->getValue())->collectValue();
                }
            }
        } else {
            $value = $this->getSumOfMetaData();
        }
        $this->value = $value;

        return $value;

    }

    public function getValue(): int
    {
        return $this->value;
    }

    private function hasChild(int $position): bool
    {
        $child = $this->getChild($position);

        return $child !== null;
    }

    /**
     * @param int $position
     * @return null|Node
     */
    private function getChild(int $position): ?Node
    {
        $child = null;
        $index = $position - 1;
        if ($index >= 0 && array_key_exists($index, $this->children)) {
            $child = $this->children[$index];
        }
        return $child;
    }

    private function hasChildren()
    {
        return \count($this->children) > 0;
    }

    private function getSumOfMetaData()
    {
        $sum = 0;
        foreach ($this->metaData as $metaData) {
            $sum += $metaData->getValue();
        }

        return $sum;
    }
}
