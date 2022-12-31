<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;

class Dice1Rules extends AbstractBaseRules
{
    public const STRATEGY_NAME = 'DICE_1';
    public const CONSTRAINT_MAX_THROWS = 3;
    private int $value;

    public function canRoll(): bool
    {
        $this->value = parent::roll();
        $temporalPoints = $this->getCurrentPoints();

        if ($temporalPoints > 10 || (($this->throwsCounter +1) > self::CONSTRAINT_MAX_THROWS)) {
            return false;
        }

        return true;
    }

    public function roll(int $value = null): int
    {
        return $this->value;
    }
}
