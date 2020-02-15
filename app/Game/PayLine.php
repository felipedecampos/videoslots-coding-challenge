<?php

declare(strict_types=1);

namespace App\Game;

use Illuminate\Support\Collection;

/**
 * Class PayLine
 * @package App\Game
 */
class PayLine
{
    /**
     * @var array
     */
    private const PAYOUTSTARTADDRESSES = [0, 1, 2];

    /**
     * @var array
     */
    private const PAYOUTMATCHSYMBOLS = [3, 4, 5];

    /**
     * @var array
     */
    private const PAYOUTADDRESSES = [
        [0, 3, 6, 9, 12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14],
    ];

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Collection
     */
    private $payLines;

    /**
     * PayLine constructor.
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board    = $board;
        $this->payLines = $this->generatePayLines();
    }

    /**
     * @return Collection
     */
    private function generatePayLines(): Collection
    {
        $payOutAddresses = $this->extractPayOutAddresses();
        $payLines        = collect([]);

        $payOutAddresses->each(function (Collection $item, $key) use ($payLines) {
            $items = $item->all();
            $dupes = $this->filterDupes($item);

            // check if there are not dupes matching with PAYOUTSTARTADDRESSES
            if (!$dupes->count()) {
                return true; // skip iteration
            }

            $symbol               = $dupes->keys()->first();
            $startedAddress       = array_search($symbol, $items);
            $payOutStartAddresses = in_array($startedAddress, self::PAYOUTSTARTADDRESSES);

            // check if the matched symbols does not start from the PAYOUTSTARTADDRESSES
            if (true !== $payOutStartAddresses) {
                return true; // skip iteration
            }

            $addresses = array_keys($items, $symbol);

            // check if the matched symbols are in the right sequence
            $numberOfMatchedSymbol = $this->checkSequences(self::PAYOUTADDRESSES[$key], $addresses);

            // check if the matched symbols sequence does not matches with PAYOUTMATCHSYMBOLS
            if (!in_array($numberOfMatchedSymbol, self::PAYOUTMATCHSYMBOLS)) {
                return true; // skip iteration
            }

            $matchedPayLine = implode(' ', self::PAYOUTADDRESSES[$key]);

            $payLines->push([$matchedPayLine => $numberOfMatchedSymbol]);
        });

        return $payLines;
    }

    /**
     * @return Collection
     */
    private function extractPayOutAddresses(): Collection
    {
        $addressesGroup = collect([]);

        foreach (self::PAYOUTADDRESSES as $addresses) {
            $addressesGroup->push(
                $this->board->unGroupBoard()
                    ->only($addresses)
                    ->sortKeys()
            );
        }

        return $addressesGroup;
    }

    /**
     * @param Collection $items
     * @return Collection
     */
    private function filterDupes(Collection $items): Collection
    {
        return collect(array_filter(
            array_count_values($items->all()),
            function ($i) {
                return in_array($i, self::PAYOUTMATCHSYMBOLS);
            }
        ));
    }

    /**
     * @param array $payOutAddress
     * @param array $dupesSymbolsAddress
     * @return int
     */
    private function checkSequences(array $payOutAddress, array $dupesSymbolsAddress): int
    {
        $sequence = 0;

        foreach ($dupesSymbolsAddress as $key => $dupesAddress) {
            if ($dupesAddress === $payOutAddress[$key]) {
                $sequence++;

                continue;
            }

            break;
        }

        return $sequence;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->payLines->all();
    }
}
