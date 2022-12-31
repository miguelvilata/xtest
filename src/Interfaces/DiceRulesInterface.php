<?php

namespace App\Interfaces;

interface DiceRulesInterface
{
    public function roll(int $value = null): int;
    public function canRoll(): bool;
    public function getName(): string;
    public function reset(): void;
}
