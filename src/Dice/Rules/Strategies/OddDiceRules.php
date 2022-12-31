<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;

final class OddDiceRules extends AbstractBaseRules
{
    public const STRATEGY_NAME = 'DICE_ODD';
    public const CONSTRAINT_MAX_THROWS = 3;

    public function __construct(array $allowedValues = null)
    {
        parent::__construct([1,3,5]);
    }

    public function canRoll(): bool
    {
        return ($this->throwsCounter < self::CONSTRAINT_MAX_THROWS);
    }
}
