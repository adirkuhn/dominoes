<?php
namespace AK\Dominoes;

class GameActions
{
    public static function playerDrawDomino(Player $player, Domino $domino = null): string
    {
        if ($domino !== null) {
            return sprintf(
                '%s can\'t play, drawing tile %s',
                $player->getPlayerName(),
                $domino->toString()
            );
        }

        return sprintf(
            '%s can\'t play, but there is no tile to draw',
            $player->getPlayerName()
        );
    }

    /**
     * @param Domino $domino
     * @return string
     */
    public static function gameStart(Domino $domino): string
    {
        return sprintf(
            'Game starting with first tile %s',
            $domino->toString()
        );
    }

    /**
     * @param Player $player
     * @param Domino $dominoPiece
     * @param Domino $connectToPiece
     * @return string
     */
    public static function playerPlays(Player $player, Domino $dominoPiece, Domino $connectToPiece): string
    {
        return sprintf(
            '%s plays %s to connect to tile %s on the board',
            $player->getPlayerName(),
            $dominoPiece->toString(),
            $connectToPiece->toString()
        );
    }

    /**
     * @param Player $player
     * @return string
     */
    public static function winner(Player $player): string
    {
        return sprintf(
            'Player %s has won!',
            $player->getPlayerName()
        );
    }

    /**
     * @param Board $board
     * @return string
     */
    public static function boardStatus(Board $board): string
    {
        return sprintf(
            'Board is now: %s',
            $board->toString()
        );
    }

    /**
     * @param Player $player
     * @return string
     */
    public static function playerCantPlayAndNoDominoes(Player $player): string
    {
        return sprintf(
            '%s can\'t play but there is no more dominoes to draw, pass turn!',
            $player->getPlayerName()
        );
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @return string
     */
    public static function gameDraw(Player $player1, Player $player2): string
    {
        return sprintf(
            '%s and %s can\'t play, game draw.',
            $player1->getPlayerName(),
            $player2->getPlayerName()
        );
    }
}
