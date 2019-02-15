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
     * Left value key
     */
    const LEFT_VALUE = 0;

    /**
     * Right value key
     */
    const RIGHT_VALUE = 1;

    /**
     * @var array $values
     */
    private $values;

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
        $this->setLeftValue($left);
        $this->setRightValue($right);
    }

    /**
     * @return int
     */
    public function getLeftValue(): int
    {
        return $this->values[self::LEFT_VALUE];
    }

    /**
     * @return int
     */
    public function getRightValue(): int
    {
        return $this->values[self::RIGHT_VALUE];
    }

    /**
     * @param int $left
     *
     * @throws DominoInvalidRangeException
     */
    private function setLeftValue(int $left): void
    {
        if (!$this->isAcceptableValue($left)) {
            throw new DominoInvalidRangeException(self::SIDE_LEFT);
        }

        $this->values[self::LEFT_VALUE] = $left;
    }

    /**
     * @param int $right
     * @throws DominoInvalidRangeException
     */
    private function setRightValue(int $right): void
    {
        if (!$this->isAcceptableValue($right)) {
            throw new DominoInvalidRangeException(self::SIDE_RIGHT);
        }

        $this->values[self::RIGHT_VALUE] = $right;
    }

    /**
     * @param int $sideValue
     * @return bool
     */
    private function isAcceptableValue(int $sideValue): bool
    {
        return ($sideValue >= self::MIN_VALUE && $sideValue <= self::MAX_VALUE);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Inverse the values of the domino
     *
     * @return Domino Domino with reversed values
     */
    public function inversePiece(): Domino
    {
        $this->values = array_reverse($this->values, false);
        return $this;
    }
}
