<?php
namespace AK\Dominoes\Exceptions;

use Throwable;

class DominoInvalidRangeException extends \Exception
{
    const ERROR_MESSAGE = 'Invalid range for side %s';
    public function __construct(string $side = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf(self::ERROR_MESSAGE, $side),
            $code,
            $previous
        );
    }
}
