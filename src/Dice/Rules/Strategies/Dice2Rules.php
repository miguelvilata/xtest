<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;

final class Dice2Rules extends AbstractBaseRules
{
    const STRATEGY_NAME = 'DICE_2';

    private int $value = 0;

    public function canRoll(): bool
    {
        $this->value = parent::roll();
        $temporalPoints = $this->getCurrentPoints();

        if ($temporalPoints > 5) {
            return false;
        }

        return true;
    }

    public function roll(int $value = null): int
    {
        return $this->value;
    }
}
