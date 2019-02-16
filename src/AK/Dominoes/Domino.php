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

    private $useSymbols = false;

    /**
     * @var array dominoes symbols
     */
    private $dominoSymbols = [
        '0-0' => '&#x1F031;',
        '0-1' => '&#x1F032;',
        '0-2' => '&#x1F033;',
        '0-3' => '&#x1F034;',
        '0-4' => '&#x1F035;',
        '0-5' => '&#x1F036;',
        '0-6' => '&#x1F037;',
        '1-0' => '&#x1F038;',
        '1-1' => '&#x1F039;',
        '1-2' => '&#x1F03A;',
        '1-3' => '&#x1F03B;',
        '1-4' => '&#x1F03C;',
        '1-5' => '&#x1F03D;',
        '1-6' => '&#x1F03E;',
        '2-0' => '&#x1F03F;',
        '2-1' => '&#x1F040;',
        '2-2' => '&#x1F041;',
        '2-3' => '&#x1F042;',
        '2-4' => '&#x1F043;',
        '2-5' => '&#x1F044;',
        '2-6' => '&#x1F045;',
        '3-0' => '&#x1F046;',
        '3-1' => '&#x1F047;',
        '3-2' => '&#x1F048;',
        '3-3' => '&#x1F049;',
        '3-4' => '&#x1F04A;',
        '3-5' => '&#x1F04B;',
        '3-6' => '&#x1F04C;',
        '4-0' => '&#x1F04D;',
        '4-1' => '&#x1F04E;',
        '4-2' => '&#x1F04F;',
        '4-3' => '&#x1F050;',
        '4-4' => '&#x1F051;',
        '4-5' => '&#x1F052;',
        '4-6' => '&#x1F053;',
        '5-0' => '&#x1F054;',
        '5-1' => '&#x1F055;',
        '5-2' => '&#x1F056;',
        '5-3' => '&#x1F057;',
        '5-4' => '&#x1F058;',
        '5-5' => '&#x1F059;',
        '5-6' => '&#x1F05A;',
        '6-0' => '&#x1F05B;',
        '6-1' => '&#x1F05C;',
        '6-2' => '&#x1F05D;',
        '6-3' => '&#x1F05E;',
        '6-4' => '&#x1F05F;',
        '6-5' => '&#x1F060;',
        '6-6' => '&#x1F061;'
    ];

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

    /**
     * Domino string representation
     *
     * @return string
     */
    public function toString(): string
    {
        if ($this->useSymbols) {
            return $this->toSymbol();
        }

        return sprintf(
            '<%s-%s>',
            $this->getLeftValue(),
            $this->getRightValue()
        );
    }

    /**
     * @return string
     */
    public function toSymbol(): string
    {
        $key = implode('-', $this->getValues());

        return html_entity_decode(
            $this->dominoSymbols[$key],
            ENT_QUOTES,
            'UTF-8'
        );
    }

    public function setUseSymbols(bool $useSymbols): Domino
    {
        $this->useSymbols = $useSymbols;
        return $this;
    }
}
