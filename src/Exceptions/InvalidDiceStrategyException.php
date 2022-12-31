<?php
declare(strict_types=1);

namespace App\Exceptions;

class InvalidDiceStrategyException extends \Exception
{
    protected $message = 'Invalid strategy for creating Dice exception';
}
