<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day8\Tree;

class Day8 extends Day implements DayInterface
{
    /**
     * @var Tree
     */
    private $tree;

    public function __construct(
        Container $container,
        Tree $tree
    ) {
        parent::__construct($container);
        $this->tree = $tree;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        $this->tree->setData($this->data);
        $this->tree->traverse();

        return (string) $this->tree->getSumOfMetaDataEntries();
    }

    public function secondPuzzle($input): string
    {
        return '';
    }

    private function parseInput($input)
    {
        $this->data = explode(' ', trim($input));
    }
}
