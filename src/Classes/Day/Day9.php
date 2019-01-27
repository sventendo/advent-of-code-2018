<?php

namespace Sventendo\AdventOfCode2018\Day;

use Illuminate\Container\Container;
use Sventendo\AdventOfCode2018\Day\Day9\Game;

class Day9 extends Day implements DayInterface
{
    /**
     * @var Game
     */
    private $game;

    public function __construct(Container $container, Game $game)
    {
        parent::__construct($container);
        $this->game = $game;
    }

    public function firstPuzzle($input): string
    {
        $numberOfPlayers = $input[0];
        $highestScore = $input[1];
        $this->game->generatePlayers($numberOfPlayers);
        $this->game->play($highestScore);

        return (string) $this->game->getBestPlayerScore();
    }

    public function secondPuzzle($input): string
    {
        $numberOfPlayers = $input[0];
        $highestScore = $input[1];
        $this->game->generatePlayers($numberOfPlayers);
        $this->game->play($highestScore);

        return (string) $this->game->getBestPlayerScore();
    }
}
