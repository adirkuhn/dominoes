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

        $this->assertEquals($left, $domino->getLeft());
        $this->assertEquals($right, $domino->getRight());
    }

    /**
     * @return array
     */
    public function dataProviderDominoes(): array
    {
        return [
            [1, 2],
            [6, 0],
            [1, 1],
            [5, 3]
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
}