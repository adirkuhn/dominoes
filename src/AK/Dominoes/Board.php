<?php
namespace AK\Dominoes;

class Board
{
    /**
     * @var Domino[] $boardPieces
     */
    private $boardPieces;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->boardPieces = [];
    }

    public function getBoardPieces(): array
    {
        return $this->boardPieces;
    }

    /**
     * @param Domino $domino
     * @return Domino|null Domino
     */
    public function addDominoToTheBoard(Domino $domino): ?Domino
    {
        // If the board is empty we can add the first piece on it
        if (empty($this->boardPieces)) {
            $this->boardPieces[] = $domino;
            return $domino;
        }

        return $this->connectToTheBoard($domino);
    }

    /**
     * @param Domino $domino
     * @return Domino|null
     */
    private function connectDominoToLeft(Domino $domino): ?Domino
    {
        if (in_array($this->getLeftValue(), $domino->getValues())) {
            if ($domino->getRightValue() !== $this->getLeftValue()) {
                $domino->inversePiece();
            }

            $connectedTo = $this->getLeftDominoPiece();
            array_unshift($this->boardPieces, $domino);
            return $connectedTo;
        }

        return null;
    }

    /**
     * @param Domino $domino
     * @return Domino|null
     */
    private function connectDominoToRight(Domino $domino): ?Domino
    {
        if (in_array($this->getRightValue(), $domino->getValues())) {
            if ($domino->getLeftValue() !== $this->getRightValue()) {
                $domino->inversePiece();
            }

            $connectedTo = $this->getRightDominoPiece();
            array_push($this->boardPieces, $domino);
            return $connectedTo;
        }

        return null;
    }

    /**
     * @param Domino $domino
     * @return Domino|null
     */
    private function connectToTheBoard(Domino $domino): ?Domino
    {
        $connectTo = $this->connectDominoToLeft($domino);

        if (is_null($connectTo)) {
            $connectTo = $this->connectDominoToRight($domino);
        }

        return $connectTo;
    }

    /**
     * @return int
     */
    public function getLeftValue(): int
    {
        return ($this->boardPieces[0])->getLeftValue();
    }

    /**
     * @return int
     */
    public function getRightValue(): int
    {
        $lastKey = count($this->boardPieces) - 1;
        return ($this->boardPieces[$lastKey])->getRightValue();
    }

    /**
     * @return Domino
     */
    private function getLeftDominoPiece(): Domino
    {
        return $this->boardPieces[0];
    }

    /**
     * @return Domino
     */
    private function getRightDominoPiece(): Domino
    {
        $lastKey = count($this->boardPieces) - 1;
        return $this->boardPieces[$lastKey];
    }

    public function toString(): string
    {
        $boardStr = '';
        foreach ($this->boardPieces as $dominoPiece) {
            $boardStr .= $dominoPiece->toString() . ' ';
        }
        return $boardStr;
    }

    public function toSymbol(): string
    {
        $boardStr = '';
        foreach ($this->boardPieces as $dominoPiece) {
            $boardStr .= $dominoPiece->toSymbol();
        }
        return $boardStr;
    }
}
