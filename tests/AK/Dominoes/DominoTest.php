<?php
namespace Test\AK\Dominoes;

use AK\Dominoes\Domino;
use PHPUnit\Framework\TestCase;

class DominoTest extends TestCase
{
    /**
     * @param int $left
     * @param int $right
     *
     * @dataProvider dataProviderDominoes
     *
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    public function testDominoLeftAndRightValue(int $left, int $right)
    {
        $domino = new Domino($left, $right);

        //test original order
        $this->assertEquals($left, $domino->getLeftValue());
        $this->assertEquals($right, $domino->getRightValue());

        $domino->inversePiece();

        //test inverse order
        $this->assertEquals($right, $domino->getLeftValue());
        $this->assertEquals($left, $domino->getRightValue());
    }

    /**
     * @return array
     */
    public function dataProviderDominoes(): array
    {
        return [
            [1, 2, '🁀', '🀺'],
            [1, 1, '🀹', '🀹'],
            [5, 3, '🁋', '🁗']
        ];
    }

    /**
     * @param int $left
     * @param int $right
     *
     * @dataProvider dataProviderInvalidRangeDominoes
     *
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     */
    public function testInvalidDominoRange(int $left, int $right)
    {
        $this->expectException('\AK\Dominoes\Exceptions\DominoInvalidRangeException');
        $domino =  new Domino($left, $right);
    }

    /**
     * @return array
     */
    public function dataProviderInvalidRangeDominoes(): array
    {
        return [
            [-1, 9],
            [7, 1],
            [1, -5],
            [6, 7]
        ];
    }

    /**
     * @param int $left
     * @param int $right
     * @param string $symbol
     * @param string $inverseSymbol
     * @throws \AK\Dominoes\Exceptions\DominoInvalidRangeException
     * @dataProvider dataProviderDominoes
     */
    public function testDominoToString(int $left, int $right, string $symbol, string $inverseSymbol)
    {
        $domino = new Domino($left, $right);

        $str = '<%s-%s>';
        $normalPiece = sprintf($str, $left, $right);
        $inversePiece = sprintf($str, $right, $left);

        //test original order
        $this->assertEquals($normalPiece, $domino->toString());

        $domino->inversePiece();

        //test inverse order
        $this->assertEquals($inversePiece, $domino->toString());

        //test symbols
        $domino->setUseSymbols(true);
        $this->assertEquals($symbol, $domino->toString());
        $this->assertEquals($symbol, $domino->toSymbol());

        $domino->inversePiece();
        $this->assertEquals($inverseSymbol, $domino->toString());
        $this->assertEquals($inverseSymbol, $domino->toSymbol());
    }
}
