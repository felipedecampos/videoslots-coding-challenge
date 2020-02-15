<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Game\Game;
use Illuminate\Console\Command;

/**
 * Class GameCommand
 * @package Laravel\Lumen\Console\Commands
 */
class GameCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'videoslots:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Play a Videoslots game.";

    /**
     * Execute the console command.
     *
     * @param Game $game
     * @return void
     */
    public function handle(Game $game)
    {
        $match = $game->play();

        switch (true) {
            case ($match->getData()->total_win ?? null) > 0:
                $color = 'green';
                break;
            default:
                $color = 'yellow';
        }

        $this->line("<fg={$color}>" . $match->getContent() . '</>');
    }
}
