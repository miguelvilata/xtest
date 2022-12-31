<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;

class Dice1Rules extends AbstractBaseRules
{
    public const STRATEGY_NAME = 'DICE_1';
    public const CONSTRAINT_MAX_THROWS = 3;

    public function canRoll(): bool
    {
        return ($this->throwsCounter < self::CONSTRAINT_MAX_THROWS);
    }
}
