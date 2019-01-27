<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day10\Light;
use Sventendo\AdventOfCode2018\Day\Day10\Printer;
use Sventendo\AdventOfCode2018\Day\Day10\Sky;
use Sventendo\AdventOfCode2018\Day\Day10\Vector;

class Day10 extends Day implements DayInterface
{
    /**
     * @var Sky
     */
    private $sky;
    /**
     * @var Printer
     */
    private $printer;

    public function __construct(Container $container, Sky $sky, Printer $printer)
    {
        parent::__construct($container);
        $this->sky = $sky;
        $this->printer = $printer;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->sky->waitForSmallestSizeX();

        $this->printer->print($this->sky);

        return '';
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->sky->waitForSmallestSizeX();

        return $this->sky->getTime();
    }

    private function parseInput($input)
    {
        $lines = explode(PHP_EOL, $input);

        $pattern = '/^position=<([\-?|\s]\d*), ([\-?|\s]\d*)> velocity=<([\-?|\s]\d*), ([\-?|\s]\d*)>$/';

        foreach ($lines as $line) {
            if (preg_match($pattern, $line, $matches)) {
                $position = new Vector($matches[1], $matches[2]);
                $velocity = new Vector($matches[3], $matches[4]);
                $this->sky->addLight(new Light($position, $velocity));
            }
        }
    }
}
