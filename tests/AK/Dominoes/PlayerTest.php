<?php
namespace Test\AK\Dominoes;

use AK\Dominoes\Domino;
use AK\Dominoes\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @param string $name
     *
     * @dataProvider dataProviderPlayerNames()
     */
    public function testGetPlayerName(string $name)
    {
        $player = new Player($name);
        $this->assertEquals($name, $player->getPlayerName());
    }

    /**
     * @return array
     */
    public function dataProviderPlayerNames(): array
    {
        return [
            ['John'],
            ['Mary'],
            ['Richard'],
            ['Helen']
        ];
    }

    /**
     * @param string $playerName
     * @param array $dominoStack
     *
     * @dataProvider dataProviderPlayerAndDominoes()
     */
    public function testPlayerAddDominoPiece(string $playerName, array $dominoStack)
    {
        $player = new Player($playerName);
        foreach ($dominoStack as $domino) {
            $player->addDominoPiece($domino);
        }

        $this->assertEquals(count($dominoStack), $player->countDominoesPieces());
    }

    /**
     * @return array
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    public function dataProviderPlayerAndDominoes(): array
    {
        return [
            ['John', []],
            ['Marcy', [new Domino(0, 0), new Domino(1, 2)]],
            ['Joseph', [new Domino(4, 4), new Domino(1, 1), new Domino(5, 5)]]
        ];
    }
}
