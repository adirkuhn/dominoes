<?php
namespace Test\AK\Dominoes;

use AK\Dominoes\Board;
use AK\Dominoes\Domino;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testEmptyBoard()
    {
        $board = new Board();
        $this->assertCount(0, $board->getBoardPieces());
    }

    /**
     * @param array $dominoesPieces
     * @param array $expectedOrder
     *
     * @dataProvider dataProviderPiecesToAddInBoard()
     */
    public function testAddDominoPiecesToTheBoard(array $dominoesPieces, array $expectedOrder)
    {
        $board = new Board();
        foreach ($dominoesPieces as $domino) {
            $board->addDominoToTheBoard($domino);
        }

        $boardPieces = $board->getBoardPieces();

        //check total pieces in the board
        $this->assertCount(count($expectedOrder), $boardPieces);

        //check board order
        $this->assertEquals($expectedOrder, $boardPieces);
    }

    /**
     * @return array
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    public function dataProviderPiecesToAddInBoard(): array
    {
        $dominoes = $this->createDominoesPieces();

        return [
            [
                [$dominoes['0-0']],
                [$dominoes['0-0']]
            ],
            [
                [$dominoes['0-0'], $dominoes['0-2'], $dominoes['2-3']],
                [$dominoes['2-3'], $dominoes['0-2'], $dominoes['0-0']],
            ],
            [
                [$dominoes['6-6'], $dominoes['5-5'], $dominoes['4-4'], $dominoes['0-6']],
                [$dominoes['0-6'], $dominoes['6-6']]
            ],
            [
                [
                    new Domino(4, 1),
                    new Domino(0, 4),
                    new Domino(0, 5),
                    new Domino(1, 1),
                    new Domino(1, 6),
                    new Domino(6, 6),
                    new Domino(4, 6),
                    new Domino(5, 5),
                    new Domino(3, 4),
                    new Domino(0, 3),
                    new Domino(1, 5),
                    new Domino(0, 2),
                    new Domino(2, 3),
                    new Domino(0, 1)
                ],
                [
                    new Domino(0, 1),
                    new Domino(1, 5),
                    new Domino(5, 5),
                    new Domino(5, 0),
                    new Domino(0, 4),
                    new Domino(4, 1),
                    new Domino(1, 1),
                    new Domino(1, 6),
                    new Domino(6, 6),
                    new Domino(6, 4),
                    new Domino(4, 3),
                    new Domino(3, 0),
                    new Domino(0, 2),
                    new Domino(2, 3)
                ]
            ]
        ];
    }

    /**
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    private function createDominoesPieces(): array
    {
        $pieces = [];
        for ($l = 0; $l < 7; $l++) {
            for ($r = $l; $r < 7; $r++) {
                $key = sprintf('%s-%s', $l, $r);
                $pieces[$key] = new Domino($l, $r);
            }
        }

        return $pieces;
    }
}
