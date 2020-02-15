<?php

declare(strict_types=1);

namespace App\Game;

use Illuminate\Support\Collection;

/**
 * Class Board
 * @package App\Game
 */
class Board
{
    /**
     * @var Collection
     */
    private $board;

    /**
     * @var Collection
     */
    private $symbols;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->symbols = $this->generateSymbols();
        $this->board   = $this->generateBoard();
    }

    /**
     * @return Collection
     */
    private function generateSymbols(): Collection
    {
        return collect([
            '9',
            '10',
            'J',
            'Q',
            'K',
            'A',
            'cat',
            'dog',
            'monkey',
            'bird',
        ]);
    }

    /**
     * @return Collection
     */
    private function generateBoard(): Collection
    {
        $board = [];

        for ($x = 0; $x <= 2; $x++) {
            for ($y = $x; $y <= 14; $y += 3) {
                $board [$x][$y] = $this->symbols->random();
            }
        }

        return collect($board);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return array_values($this->unGroupBoard()->all());
    }

    /**
     * @return Collection
     */
    public function unGroupBoard(): Collection
    {
        $board = collect([]);

        $this->board->map(function ($item, $key) use ($board) {
            foreach ($item as $k => $i) {
                $board->put($k, $i);
            }
        });

        return $board;
    }
}
