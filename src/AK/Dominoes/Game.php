<?php
namespace AK\Dominoes;

use AK\Dominoes\Exceptions\NoDominoesPiecesLeftToStartTheGameException;

class Game
{
    /**
     * max domino pieces for a game
     */
    const MAX_DOMINO_PIECES = 28;

    /**
     * num to draw per round
     */
    const NUM_DRAW = 1;

    /**
     * num pieces for each player start the game
     */
    const EACH_PLAYER_START_PIECES = 7;

    /**
     * @var Player $player1
     */
    private $player1;

    /**
     * @var Player $player2
     */
    private $player2;

    /**
     * @var Board $board
     */
    private $board;

    /**
     * @var Domino[] $dominoesPile
     */
    private $dominoesPile;

    /**
     * @var string[] $gameActions
     */
    private $gameActions;

    /**
     * @var ?Player $winner
     */
    private $winner;

    /**
     * @var bool $useSymbols
     */
    private $useSymbols = false;


    /**
     * Game constructor.
     *
     * @param Player $player1
     * @param Player $player2
     * @param Board $board
     * @param bool $useSymbols
     * @throws Exceptions\DominoInvalidRangeException
     */
    public function __construct(Player $player1, Player $player2, Board $board, bool $useSymbols = false)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->board = $board;
        $this->winner = null;
        $this->useSymbols = $useSymbols;

        $this->gameActions = [];
        $this->createDominoesPile();
    }

    /**
     * Random Play
     *
     * @throws NoDominoesPiecesLeftToStartTheGameException
     */
    public function startGame(): void
    {
        $this->player1 = $this->drawDominoesToPlayer(self::EACH_PLAYER_START_PIECES, $this->player1);
        $this->player2 = $this->drawDominoesToPlayer(self::EACH_PLAYER_START_PIECES, $this->player2);

        $this->placeFirstPieceInTheBoard();

        while (!$this->hasWinner()) {
            $this->player1 = $this->playerPlays($this->player1);
            if ($this->checkForWinner($this->player1)) {
                break;
            }

            $this->player2 = $this->playerPlays($this->player2);
            if ($this->checkForWinner($this->player2)) {
                break;
            }

            if ($this->gameIsDraw()) {
                $this->addGameAction(GameActions::gameDraw(
                    $this->player1,
                    $this->player2
                ));
                break;
            }
        }
    }

    /**
     * @return Player
     */
    public function getPlayer1(): Player
    {
        return $this->player1;
    }

    /**
     * @param Player $player1
     * @return Game
     */
    public function setPlayer1(Player $player1): Game
    {
        $this->player1 = $player1;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer2(): Player
    {
        return $this->player2;
    }

    /**
     * @param Player $player2
     * @return Game
     */
    public function setPlayer2(Player $player2): Game
    {
        $this->player2 = $player2;
        return $this;
    }

    /**
     * @return Domino[]
     */
    public function getDominoesPile(): array
    {
        return $this->dominoesPile;
    }

    /**
     * @throws Exceptions\DominoInvalidRangeException
     */
    private function createDominoesPile(): void
    {
        for ($left = Domino::MIN_VALUE; $left <= Domino::MAX_VALUE; $left++) {
            for ($right = $left; $right <= Domino::MAX_VALUE; $right++) {
                $domino = new Domino($left, $right);
                $this->dominoesPile[] = $domino->setUseSymbols($this->useSymbols);
            }
        }

        shuffle($this->dominoesPile);
    }

    /**
     * @param int $numPieces
     * @param Player $player
     *
     * @return Player
     */
    public function drawDominoesToPlayer(int $numPieces, Player $player): Player
    {
        for ($count = 0; $count < $numPieces; $count++) {
            $piece = $this->drawDominoFromPile();

            if (!is_null($piece)) {
                $player->addDominoPiece($piece);

                if ($numPieces !== self::EACH_PLAYER_START_PIECES) {
                    $this->addGameAction(GameActions::playerDrawDomino($player, $piece));
                }
            }
        }

        return $player;
    }

    private function hasDominoesInPile()
    {
        return count($this->dominoesPile) > 0;
    }

    private function addGameAction(string $gameAction): void
    {
        $this->gameActions[] = $gameAction;
    }

    /**
     * @throws NoDominoesPiecesLeftToStartTheGameException
     */
    private function placeFirstPieceInTheBoard(): void
    {
        $piece = $this->drawDominoFromPile();
        if (is_null($piece)) {
            throw new NoDominoesPiecesLeftToStartTheGameException;
        }

        $this->board->addDominoToTheBoard($piece);
        $this->addGameAction(GameActions::gameStart($piece));
    }

    /**
     * @return Domino
     */
    private function drawDominoFromPile(): ?Domino
    {
        $piece = null;
        if ($this->hasDominoesInPile()) {
            /** @var Domino $piece */
            $piece = array_pop($this->dominoesPile);
        }

        return $piece;
    }

    /**
     * @return string[] game actions log
     */
    public function getGameActions(): array
    {
        return $this->gameActions;
    }

    /**
     * @return bool
     */
    private function hasWinner(): bool
    {
        return $this->winner !== null;
    }

    /**
     * @param Player $player
     * @return Player
     */
    private function playerPlays(Player $player): Player
    {
        $dominoPiece = $player->getDominoPieceWithSides(
            $this->board->getLeftValue(),
            $this->board->getRightValue()
        );

        if (!is_null($dominoPiece)) {
            $connectToPiece = $this->board->addDominoToTheBoard($dominoPiece);

            if (!is_null($connectToPiece)) {
                $this->addGameAction(
                    GameActions::playerPlays($player, $dominoPiece, $connectToPiece)
                );

                $this->addGameAction(
                    GameActions::boardStatus($this->board)
                );
            }
        } elseif ($this->hasDominoesInPile()) {
            $player = $this->drawDominoesToPlayer(self::NUM_DRAW, $player);
            //recursive call
            $player = $this->playerPlays($player);
        } else {
            //can't play, pass the turn
            $this->addGameAction(GameActions::playerCantPlayAndNoDominoes($player));
        }

        return $player;
    }

    private function checkForWinner(Player $player): bool
    {
        if ($player->countDominoesPieces() === 0) {
            $this->addGameAction(GameActions::winner($player));
            $this->winner = $player;

            return true;
        }

        return false;
    }

    /**
     * print game actions
     */
    public function printGameActions(): string
    {
        return implode(PHP_EOL, $this->gameActions);
    }

    private function gameIsDraw(): bool
    {
        if ($this->hasNoDominoesInPile()
            && $this->player1->cantPlayWithBoard($this->board)
            && $this->player2->cantPlayWithBoard($this->board)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasNoDominoesInPile(): bool
    {
        return !$this->hasDominoesInPile();
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param bool $useSymbols
     * @return Game
     */
    public function setUseSymbols(bool $useSymbols): Game
    {
        $this->useSymbols = $useSymbols;
        return $this;
    }

    public function getUseSymbols(): bool
    {
        return $this->useSymbols;
    }
}
