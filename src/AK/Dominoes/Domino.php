<?php
namespace AK\Dominoes;

use AK\Dominoes\Exceptions\DominoInvalidRangeException;

class Domino
{
    /**
     * maximum value to one domino side
     */
    const MAX_VALUE = 6;

    /**
     * minimum value to one domino side
     */
    const MIN_VALUE = 0;

    /**
     * side left
     */
    const SIDE_LEFT = 'left';

    /**
     * side right
     */
    const SIDE_RIGHT = 'right';

    /**
     * @var int $left
     */
    private $left;

    /**
     * @var int $right
     */
    private $right;

    /**
     * Domino constructor.
     *
     * @param int $left
     * @param int $right
     *
     * @throws DominoInvalidRangeException
     */
    public function __construct(int $left, int $right)
    {
        $this->setLeft($left);
        $this->setRight($right);
    }

    /**
     * @return int
     */
    public function getLeft(): int
    {
        return $this->left;
    }

    /**
     * @return int
     */
    public function getRight(): int
    {
        return $this->right;
    }

    /**
     * @param int $left
     *
     * @throws DominoInvalidRangeException
     */
    private function setLeft(int $left): void
    {
        if (!$this->isAcceptableValue($left)) {
            throw new DominoInvalidRangeException(self::SIDE_LEFT);
        }

        $this->left = $left;
    }

    /**
     * @param int $right
     * @throws DominoInvalidRangeException
     */
    private function setRight(int $right): void
    {
        if (!$this->isAcceptableValue($right)) {
            throw new DominoInvalidRangeException(self::SIDE_RIGHT);
        }

        $this->right = $right;
    }

    /**
     * @param int $sideValue
     * @return bool
     */
    private function isAcceptableValue(int $sideValue): bool
    {
        return ($sideValue >= self::MIN_VALUE && $sideValue <= self::MAX_VALUE);
    }
}
