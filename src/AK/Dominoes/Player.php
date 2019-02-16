<?php
namespace AK\Dominoes;

class Player
{
    /**
     * @var string $playerName
     */
    private $playerName;

    /**
     * @var Domino[] $dominoesPieces
     */
    private $dominoesPieces;

    /**
     * Player constructor.
     * @param string $playerName
     */
    public function __construct(string $playerName)
    {
        $this->playerName = $playerName;
        $this->dominoesPieces = [];
    }

    /**
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * @param Domino $domino
     * @return Player
     */
    public function addDominoPiece(Domino $domino): Player
    {
        $this->dominoesPieces[] = $domino;

        return $this;
    }

    /**
     * @return int
     */
    public function countDominoesPieces(): int
    {
        return count($this->dominoesPieces);
    }

    /**
     * @return Domino[]
     */
    public function getDominoPieces(): array
    {
        return $this->dominoesPieces;
    }

    /**
     * @param int $leftValue
     * @param int $rightValue
     * @return Domino|null
     */
    public function getDominoPieceWithSides(int $leftValue, int $rightValue): ?Domino
    {
        foreach ($this->dominoesPieces as $key => $domino) {
            if (!empty(array_intersect([$leftValue, $rightValue], $domino->getValues()))) {
                return $this->removeDominoPiece($key);
            }
        }

        return null;
    }

    /**
     * @param int $leftValue
     * @param int $rightValue
     * @return bool
     */
    public function canPlayWithSideValues(int $leftValue, int $rightValue): bool
    {
        foreach ($this->dominoesPieces as $key => $domino) {
            if (!empty(array_intersect([$leftValue, $rightValue], $domino->getValues()))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Board $board
     * @return bool
     */
    public function cantPlayWithBoard(Board $board): bool
    {
        return !$this->canPlayWithSideValues($board->getLeftValue(), $board->getRightValue());
    }

    /**
     * @param int $key
     * @return Domino
     */
    public function removeDominoPiece(int $key): Domino
    {
        $domino = $this->dominoesPieces[$key];
        unset($this->dominoesPieces[$key]);
        return $domino;
    }
}
