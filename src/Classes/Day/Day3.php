<?php

namespace Sventendo\AdventOfCode2018\Day;

use Sventendo\AdventOfCode2018\Day\Day3\Claim;
use Sventendo\AdventOfCode2018\Day\Day3\Fabric;

class Day3 extends Day implements DayInterface
{
    /**
     * @var Claim[]
     */
    private $claims = [];
    /**
     * @var Fabric
     */
    private $fabric;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        unset($input);

        $this->fabric = $this->container->make(Fabric::class);

        foreach ($this->data as $claimCode) {
            /** @var Claim $claim */
            $claim = $this->container->make(Claim::class);
            $claim->parseClaim($claimCode);
            $this->claims[] = $claim;
            $this->fabric->addClaim($claim);
        }

        return $this->fabric->getCriticalInches();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        unset($input);

        $this->fabric = $this->container->make(Fabric::class);

        foreach ($this->data as $claimCode) {
            /** @var Claim $claim */
            $claim = $this->container->make(Claim::class);
            $claim->parseClaim($claimCode);
            $this->claims[] = $claim;
            $this->fabric->addClaim($claim);
        }

        foreach ($this->claims as $claim) {
            if ($this->fabric->isUndisputed($claim)) {
                return $claim->getId();
            }
        }

        throw new \Exception('All claims are conflicting.');
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
