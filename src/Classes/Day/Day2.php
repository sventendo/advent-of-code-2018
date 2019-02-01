<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day2\BoxId;
use Sventendo\AdventOfCode2018\Day\Day2\IdComparer;

class Day2 extends Day implements DayInterface
{
    private $data;
    /**
     * @var IdComparer
     */
    private $idComparer;

    public function __construct(
        Container $container,
        IdComparer $idComparer
    ) {
        parent::__construct($container);
        $this->idComparer = $idComparer;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        unset($input);

        $duplicates = 0;
        $triplets = 0;

        foreach ($this->data as $id) {
            /** @var BoxId $boxId */
            $boxId = $this->container->make(BoxId::class);
            $boxId->setId($id);
            $boxId->parseId();
            $duplicates += $boxId->hasDuplicates() ? 1 : 0;
            $triplets += $boxId->hasTriplets() ? 1 : 0;
        }

        return $duplicates * $triplets;
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $idCount = \count($this->data);
        foreach ($this->data as $fromIndex => $fromId) {
            for ($toIndex = $fromIndex + 1; $toIndex < $idCount; $toIndex++) {
                $toId = $this->data[$toIndex];
                $this->idComparer->setFromId($fromId);
                $this->idComparer->setToId($toId);
                if ($this->idComparer->isSimilar()) {
                    return $this->idComparer->getOverlappingLetters();
                }
            }
        }

        return '';
    }

    private function parseInput($input)
    {
        $rows = explode(PHP_EOL, $input);

        $data = [];

        foreach ($rows as $row) {
            if (!empty(trim($row))) {
                $data[] = trim($row);
            }
        }

        $this->data = $data;
    }
}
