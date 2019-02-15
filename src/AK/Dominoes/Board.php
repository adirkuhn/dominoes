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
     * @return bool
     */
    public function addDominoToTheBoard(Domino $domino): bool
    {
        // If the board is empty we can add the first piece on it
        if (empty($this->boardPieces)) {
            $this->boardPieces[] = $domino;
            return true;
        }

        return $this->connectToTheBoard($domino);
    }

    /**
     * @param Domino $domino
     * @return bool
     */
    private function connectDominoToLeft(Domino $domino): bool
    {
        if (in_array($this->getLeftValue(), $domino->getValues())) {
            if ($domino->getRightValue() !== $this->getLeftValue()) {
                $domino->inversePiece();
            }

            array_unshift($this->boardPieces, $domino);
            return true;
        }

        return false;
    }

    /**
     * @param Domino $domino
     * @return bool
     */
    private function connectDominoToRight(Domino $domino): bool
    {
        if (in_array($this->getRightValue(), $domino->getValues())) {
            if ($domino->getLeftValue() !== $this->getRightValue()) {
                $domino->inversePiece();
            }

            array_push($this->boardPieces, $domino);
            return true;
        }

        return false;
    }

    /**
     * @param Domino $domino
     * @return bool
     */
    private function connectToTheBoard(Domino $domino): bool
    {
        $pieceWasConnected = $this->connectDominoToLeft($domino);

        if (!$pieceWasConnected) {
            $pieceWasConnected = $this->connectDominoToRight($domino);
        }

        return $pieceWasConnected;
    }

    /**
     * @return int
     */
    private function getLeftValue(): int
    {
        return ($this->boardPieces[0])->getLeftValue();
    }

    /**
     * @return int
     */
    private function getRightValue(): int
    {
        $lastKey = count($this->boardPieces) - 1;
        return ($this->boardPieces[$lastKey])->getRightValue();
    }
}
