<?php
require_once __DIR__ . '/vendor/autoload.php';

try {
    $player1 = new \AK\Dominoes\Player('John');
    $player2 = new \AK\Dominoes\Player('Mary');

    $board = new \AK\Dominoes\Board();

    $game = new \AK\Dominoes\Game($player1, $player2, $board);

    $game->startGame();

    print $game->printGameActions();
} catch (\Throwable $t) {
    print $t->getMessage();
}
