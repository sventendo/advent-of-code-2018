<?php

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

    public function addChild(Node $child)
    {
        $this->children[] = $child;
    }

    public function addMetaData(MetaData $metaData)
    {
        $this->metaData[] = $metaData;
    }
}
