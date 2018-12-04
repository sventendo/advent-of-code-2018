<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;

abstract class Day
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var mixed
     */
    protected $data;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
