<?php

namespace App\Interfaces;

use App\Player\PlayResult;

interface DiceRulesInterface
{
    public function roll(int $value = null): int;
    public function canRoll(PlayResult $result): bool;
    public function getName(): string;
    public function reset(): void;
}
