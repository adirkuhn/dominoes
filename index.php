<?php
require_once __DIR__ . '/vendor/autoload.php';

try {
    $player1 = new \AK\Dominoes\Player('John');
    $player2 = new \AK\Dominoes\Player('Mary');

    $board = new \AK\Dominoes\Board();

    $useSymbols = true;
    $game = new \AK\Dominoes\Game($player1, $player2, $board, $useSymbols);

    $game->startGame();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/AK/Dominoes/View/');
    $twig = new \Twig\Environment($loader);

    echo $twig->render('game.twig', ['gameActions' => $game->getGameActions()]);
} catch (\Throwable $t) {
    print $t->getMessage();
}
