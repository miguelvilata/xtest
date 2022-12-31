<?php

declare(strict_types=1);

namespace App\Dice\Rules\Strategies;

use App\Dice\Rules\AbstractBaseRules;
use App\Player\PlayResult;

final class Dice2Rules extends AbstractBaseRules
{
    const STRATEGY_NAME = 'DICE_2';

    private ?int $value = 0;

    public function canRoll(PlayResult $result): bool
    {
        $value = $this->doRoll();

        if (($result->totalPoints + $value) > 5) {
            return false;
        }

        $this->value = $value;
        parent::roll($value);

        return true;
    }

    public function roll(int $value = null): int
    {
        return $this->value;
    }
}
