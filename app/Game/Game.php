<?php

declare(strict_types=1);

namespace App\Game;

use Illuminate\Http\JsonResponse;

/**
 * Class Game
 * @package App\Game
 */
class Game
{
    /**
     * @var float
     */
    private const PAYOUT3SYMBOLS = .20; // 20%

    /**
     * @var float
     */
    private const PAYOUT4SYMBOLS = 2;   // 200%

    /**
     * @var float
     */
    private const PAYOUT5SYMBOLS = 10;  // 1000%

    /**
     * @var int double
     */
    private $betAmount = 100; // 100 Cents = € 1

    /**
     * @var int
     */
    private $totalWin = 0; // 0 cents

    /**
     * @var Board
     */
    private $board;

    /**
     * @var PayLine
     */
    private $payLine;

    /**
     * Game constructor.
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board   = $board;
        $this->payLine = new PayLine($this->board);
    }

    /**
     * @param PayLine $payLines
     * @return float
     */
    private function calcTotalWin(PayLine $payLines): float
    {
        $sum = 0;

        foreach ($payLines->get() as $payLines) {
            foreach ($payLines as $payLine => $matched) {
                switch ($matched) {
                    case 3:
                        $sum += $this->betAmount * self::PAYOUT3SYMBOLS;
                        break;
                    case 4:
                        $sum += $this->betAmount * self::PAYOUT4SYMBOLS;
                        break;
                    case 5:
                        $sum += $this->betAmount * self::PAYOUT5SYMBOLS;
                        break;
                }
            }
        }

        return $this->totalWin = $sum;
    }

    /**
     * @return JsonResponse
     */
    public function play(): JsonResponse
    {
        return response()->json([
            'board'      => $this->board->get(),
            'paylines'   => $this->payLine->get(),
            'bet_amount' => $this->betAmount,
            'total_win'  => $this->calcTotalWin($this->payLine),
        ]);
    }
}
