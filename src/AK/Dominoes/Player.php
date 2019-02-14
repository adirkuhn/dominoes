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
}
