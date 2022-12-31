<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;
use App\Player\PlayResult;

final class OddDiceRules extends AbstractBaseRules
{
    const STRATEGY_NAME = 'DICE_ODD';
    const CONSTRAINT_MAX_THROWS = 3;

    public function __construct(array $allowedValues = null)
    {
        parent::__construct([1,3,5]);
    }

    public function canRoll(PlayResult $result): bool
    {
        return ($this->throwsCounter < self::CONSTRAINT_MAX_THROWS);
    }
}
