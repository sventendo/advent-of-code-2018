<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day;

use Sventendo\AdventOfCode2018\Day\Day6\Location;

class Day6 extends Day implements DayInterface
{
    /**
     * @var Location[]
     */
    protected $data = [];
    private $flatArrayX = [];
    private $flatArrayY = [];
    /**
     * @var Location[]
     */
    private $candidates = [];
    /**
     * @var array[]
     */
    private $grid = [];
    /**
     * @var int[]
     */
    private $highscore = [];

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        $this->candidates = $this->getFiniteLocations();
        $this->initializeGrid();
        $this->fillGridWithClosestPoint();
        $this->countAreas();

        return (string) $this->getLargestAreaSize();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        $this->candidates = $this->getFiniteLocations();
        $this->initializeGrid();
        $this->fillGridWithDistanceSumLessThan(10000);
        return (string) $this->countSmallerSums();
    }

    private function parseInput($input): void
    {
        $rows = explode(PHP_EOL, $input);
        foreach ($rows as $index => $row) {
            if (trim($row) !== '') {
                /** @var Location $location */
                $location = $this->container->make(Location::class);
                $location->parseCoordinates($row);
                $location->setId('location_' . $index);
                $this->data[] = $location;
            }
        }
    }

    private function getFiniteLocations(): array
    {
        $infiniteLocations = [];
        foreach ($this->data as $location) {
            $this->flatArrayX[$location->getId()] = $location->getX();
        }
        asort($this->flatArrayX);

        $infiniteLocations = array_merge($infiniteLocations, array_keys($this->flatArrayX, max($this->flatArrayX)));
        $infiniteLocations = array_merge($infiniteLocations, array_keys($this->flatArrayX, min($this->flatArrayX)));

        foreach ($this->data as $location) {
            $this->flatArrayY[$location->getId()] = $location->getY();
        }
        asort($this->flatArrayY);

        $infiniteLocations = array_merge($infiniteLocations, array_keys($this->flatArrayY, max($this->flatArrayY)));
        $infiniteLocations = array_merge($infiniteLocations, array_keys($this->flatArrayY, min($this->flatArrayY)));

        $infiniteLocations = array_unique($infiniteLocations, SORT_STRING);

        $finiteLocationIds = array_diff(array_keys($this->flatArrayX), $infiniteLocations);

        $finiteLocations = array_filter(
            $this->data,
            function (Location $location) use ($finiteLocationIds) {
                return in_array($location->getId(), $finiteLocationIds);
            }
        );

        return $finiteLocations;
    }

    private function initializeGrid(): void
    {
        $minX = min($this->flatArrayX);
        $maxX = max($this->flatArrayX);
        $minY = min($this->flatArrayY);
        $maxY = max($this->flatArrayY);

        $this->grid = array_fill($minY, $maxY - $minY, array_fill($minX, $maxX - $minX, null));
    }

    private function fillGridWithClosestPoint(): void
    {
        foreach ($this->grid as $yIndex => $y) {
            foreach ($y as $xIndex => $x) {
                $this->grid[$yIndex][$xIndex] = $this->getClosestPoint($yIndex, $xIndex);
            }
        }
    }

    private function getClosestPoint(int $y, int $x): string
    {
        $distances = [];
        foreach ($this->data as $location) {
            $distances[$location->getId()] = abs($y - $location->getY()) + abs($x - $location->getX());
        }

        $closestPoints = array_keys($distances, min($distances));

        return implode('|', $closestPoints);
    }

    private function countAreas(): void
    {
        foreach ($this->grid as $row) {
            foreach ($row as $column) {
                if (strpos($column, '|') === false) {
                    if (!array_key_exists($column, $this->highscore)) {
                        $this->highscore[$column] = 0;
                    }
                    $this->highscore[$column]++;
                }
            }
        }

        arsort($this->highscore);
    }

    private function getLargestAreaSize(): int
    {
        $largestSize = 0;
        $candidateIds = array_map(
            function (Location $location) {
                return $location->getId();
            },
            $this->candidates
        );
        foreach ($this->highscore as $locationId => $size) {
            if (in_array($locationId, $candidateIds)) {
                $largestSize = $size;
                break;
            }
        }

        return $largestSize;
    }

    private function fillGridWithDistanceSumLessThan(int $maxSum): void
    {
        foreach ($this->grid as $yIndex => $y) {
            foreach ($y as $xIndex => $x) {
                $this->grid[$yIndex][$xIndex] = (int) $this->isDistanceSumLessThan($yIndex, $xIndex, $maxSum);
            }
        }
    }

    private function isDistanceSumLessThan($y, $x, int $maxSum): bool
    {
        $distances = [];
        foreach ($this->data as $location) {
            $distances[$location->getId()] = abs($y - $location->getY()) + abs($x - $location->getX());
        }

        return array_sum($distances) < $maxSum;
    }

    private function countSmallerSums(): int
    {
        $count = 0;
        array_walk(
            $this->grid,
            function (array $row) use (&$count) {
                $count += array_sum($row);
            }
        );

        return $count;
    }
}
