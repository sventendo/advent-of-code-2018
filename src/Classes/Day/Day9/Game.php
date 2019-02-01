<?php

namespace Sventendo\AdventOfCode2018\Day\Day9;

use Illuminate\Container\Container;

class Game
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Player[]
     */
    private $players = [];
    private $currentPlayer = 0;
    /**
     * @var \SplDoublyLinkedList
     */
    private $board;
    private $currentMarble = 0;
    private $magicNumber = 23;

    public function __construct
    (
        \SplDoublyLinkedList $board,
        Container $container
    ) {

        $this->board = $board;
        $this->container = $container;
    }

    public function generatePlayers(int $numberOfPlayers)
    {
        for ($i = 0; $i < $numberOfPlayers; $i++) {
            $this->players[] = $this->container->make(Player::class);
        }
    }

    public function play(int $highestScore)
    {
        for ($round = 0; $round <= $highestScore; $round++) {
            if ($this->isSpecialRound($round)) {
                $this->keepMarble($round);
                $this->pickUpMarble(-7);
            } else {
                $this->placeMarble($round);
            }
            $this->nextPlayer();
        }
    }

    public function getBestPlayerScore()
    {
        usort(
            $this->players,
            function (Player $playerA, Player $playerB) {
                return $playerA->getScore() < $playerB->getScore();
            }
        );

        return $this->players[0]->getScore();
    }

    public function placeMarble(int $round)
    {
        if ($this->board->count() > 0) {
            $this->board->push($this->board->shift());
        }
        $this->board->push($round);
    }

    public function getBoard(): array
    {
        $length = $this->board->count();

        $items = [];

        for ($i = 0; $i < $length; $i++) {
            $items[] = $this->board->shift();
        }

        return $items;
    }

    public function setBoard(array $board)
    {
        $this->board = new \SplDoublyLinkedList();
        foreach ($board as $item) {
            $this->board->push($item);
        }
    }

    public function getCurrentMarble(): int
    {
        return $this->currentMarble;
    }

    public function setCurrentMarble(int $currentMarble)
    {
        $this->currentMarble = $currentMarble;
    }

    private function isSpecialRound(int $round)
    {
        return $round > 0 && $round % $this->magicNumber === 0;
    }

    private function nextPlayer()
    {
        $this->currentPlayer = ($this->currentPlayer + 1) % \count($this->players);
    }

    private function keepMarble(int $value)
    {
        $this->players[$this->currentPlayer]->addScore($value);
    }

    private function pickUpMarble(int $steps)
    {
        if ($steps < 0) {
            for ($i = 0; $i < abs($steps); $i++) {
                $this->board->unshift($this->board->pop());
            }
        } else {
            for ($i = 0; $i < abs($steps); $i++) {
                $this->board->push($this->board->shift());
            }
        }

        $marble = $this->board->pop();
        $this->keepMarble($marble);
        $this->board->push($this->board->shift());
    }
}
