<?php
namespace AK\Dominoes\Exceptions;

class NoDominoesPiecesLeftToStartTheGameException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No dominoes left in the pile to start the game', 0, null);
    }
}
