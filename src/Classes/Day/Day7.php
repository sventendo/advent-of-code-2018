<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day6\Location;
use Sventendo\AdventOfCode2018\Day\Day7\Instructions;
use Sventendo\AdventOfCode2018\Day\Day7\Step;

class Day7 extends Day implements DayInterface
{
    /**
     * @var Location[]
     */
    protected $data = [];
    /**
     * @var Instructions
     */
    private $instructions;

    public function __construct(
        Container $container,
        Instructions $instructions
    ) {
        parent::__construct($container);
        $this->instructions = $instructions;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        $this->instructions->follow();

        return $this->instructions->getRoute();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        $this->instructions->initializeWorkforce(4);
        $this->instructions->followWithWorkforce();

        return (string) $this->instructions->getTimer();
    }

    private function parseInput($input): void
    {
        $rows = explode(PHP_EOL, $input);

        $this->createSteps($rows);

        foreach ($rows as $index => $row) {
            if (trim($row) !== '') {
                $this->instructions->parseInstruction($row);
            }
        }
    }

    private function createSteps(array $rows)
    {
        $stepIds = [];
        $previous = [];
        $next = [];

        foreach ($rows as $row) {
            if (preg_match(Instructions::PATTERN, $row, $matches)) {
                $stepIds[] = $matches[1];
                $stepIds[] = $matches[2];
                $previous[] = $matches[1];
                $next[] = $matches[2];
            }
        }

        $stepIds = array_unique($stepIds);

        foreach ($stepIds as $stepId) {
            /** @var Step $step */
            $step = $this->container->make(Step::class);
            $step->setId($stepId);
            $this->instructions->addStep($step);
        }
    }

}
