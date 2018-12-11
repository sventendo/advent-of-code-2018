<?php

namespace Sventendo\AdventOfCode2018\Day\Day8;

use Illuminate\Container\Container;

class Tree
{
    /**
     * @var int[]
     */
    private $data = [];
    /**
     * @var Container
     */
    private $container;
    /**
     * @var int
     */
    private $sum = 0;
    /**
     * @var Node
     */
    private $root;

    public function __construct(
        Container $container
    ) {
        $this->container = $container;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function traverse()
    {
        $this->root = $this->parseData();
    }

    public function getSumOfMetaDataEntries(): int
    {
        return $this->sum;
    }

    private function parseData()
    {
        $numberOfChildren = array_shift($this->data);
        $numberOfMetaData = array_shift($this->data);

        /** @var Node $node */
        $node = $this->container->make(Node::class);

        for ($childIndex = 0; $childIndex < $numberOfChildren; $childIndex++) {
            $child = $this->parseData();
            $node->addChild($child);
        }

        for ($metaDataIndex = 0; $metaDataIndex < $numberOfMetaData; $metaDataIndex++) {
            /** @var MetaData $metaData */
            $metaData = $this->container->make(MetaData::class);
            $value = array_shift($this->data);
            $this->addSum($value);
            $metaData->setValue($value);
            $node->addMetaData($metaData);
        }

        return $node;
    }

    private function addSum($value): void
    {
        $this->sum += $value;
    }
}
