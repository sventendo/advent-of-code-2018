<?php

namespace Sventendo\AdventOfCode2018\Tests;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\DayInterface;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var DayInterface
     */
    protected $subject;
    /**
     * @var mixed
     */
    protected $input;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        $this->container = new Container();
        parent::__construct($name, $data, $dataName);
    }

    protected function print(string $output)
    {
        echo PHP_EOL . "\033[0;30m\033[42m" . $output . "\033[0m" . PHP_EOL;
    }
}
