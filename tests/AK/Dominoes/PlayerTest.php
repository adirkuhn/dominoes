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

    public function testPlayerAddDominoPiece()
    {
        $player = new Player('Anon');

        $this->assertEquals(0, $player->countDominoesPieces());
    }
}
