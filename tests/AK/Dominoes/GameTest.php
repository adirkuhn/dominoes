<?php
namespace Test\AK\Dominoes;

use AK\Dominoes\Board;
use AK\Dominoes\Game;
use AK\Dominoes\Player;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param Game $game
     *
     * @dataProvider dataProviderGameAndPlayers()
     */
    public function testGameHasPlayers(Player $player1, Player $player2, Board $board, Game $game)
    {
        $this->assertEquals($player1, $game->getPlayer1());
        $this->assertEquals($player2, $game->getPlayer2());
    }

    /**
     * @return array
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    public function dataProviderGameAndPlayers(): array
    {
        return [
            [
                $player1 = new Player('John'),
                $player2 = new Player('Mary'),
                $board = new Board(),
                new Game($player1, $player2, $board)
            ],
            [
                $player1 = new Player('1'),
                $player2 = new Player('2'),
                $board = new Board(),
                new Game($player1, $player2, $board)
            ],
            [
                $player1 = new Player('Bob'),
                $player2 = new Player('Lizzy'),
                $board = new Board(),
                new Game($player1, $player2, $board)
            ]
        ];
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param Game $game
     *
     * @dataProvider dataProviderGameAndPlayers
     */
    public function testGameDominoesPile(Player $player1, Player $player2, Board $board, Game $game)
    {
        $this->assertCount($game::MAX_DOMINO_PIECES, $game->getDominoesPile());
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Game $game
     *
     * @dataProvider dataProviderGameAndPlayers
     */
    public function testIfPlayerHasDominoes(Player $player1, Player $player2, Board $board, Game $game)
    {
        $game->setPlayer1($game->drawDominoesToPlayer(
            $game::EACH_PLAYER_START_PIECES,
            $game->getPlayer1()
        ));

        $this->assertCount(
            $game::EACH_PLAYER_START_PIECES,
            $game->getPlayer1()->getDominoPieces()
        );

        $game->setPlayer2($game->drawDominoesToPlayer(
            $game::EACH_PLAYER_START_PIECES,
            $game->getPlayer2()
        ));

        $this->assertCount(
            $game::EACH_PLAYER_START_PIECES,
            $game->getPlayer2()->getDominoPieces()
        );

        $remainingPiecesInPile = $game::MAX_DOMINO_PIECES - ($game::EACH_PLAYER_START_PIECES * 2);
        $this->assertCount($remainingPiecesInPile, $game->getDominoesPile());
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param Game $game
     *
     * @throws \AK\Dominoes\Exceptions\NoDominoesPiecesLeftToStartTheGameException
     * @dataProvider dataProviderGameAndPlayers
     */
    public function testStartGame(Player $player1, Player $player2, Board $board, Game $game)
    {
        $game->startGame();

        // Has actions log
        $this->assertNotEmpty($game->getGameActions());
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param Game $game
     *
     * @dataProvider dataProviderGameAndPlayers
     */
    public function testGetBoard(Player $player1, Player $player2, Board $board, Game $game)
    {
        $this->assertEquals($board, $game->getBoard());
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param Game $game
     *
     * @dataProvider dataProviderGameAndPlayers
     */
    public function testShouldUseSymbols(Player $player1, Player $player2, Board $board, Game $game)
    {
        $this->assertFalse($game->getUseSymbols());
        $game->setUseSymbols(true);
        $this->assertTrue($game->getUseSymbols());
    }
}
