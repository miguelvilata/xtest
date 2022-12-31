<?php

declare(strict_types=1);

namespace App\Dice\Factory;

use App\Dice\Rules\Strategies\Dice1Rules;
use App\Dice\Rules\Strategies\Dice2Rules;
use App\Dice\Rules\Strategies\OddDiceRules;
use App\Exceptions\InvalidDiceStrategyException;
use App\Interfaces\DiceInterface;

final class DiceFactory
{
    public static function create(int $strategy = null): DiceInterface
    {
        return match ($strategy) {
            1 => new Dice1Rules(),
            2 => new Dice2Rules(),
            3 => new OddDiceRules(),
            default => throw new InvalidDiceStrategyException()
        };
    }
}
