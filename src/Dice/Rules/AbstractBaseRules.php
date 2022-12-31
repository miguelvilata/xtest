<?php

namespace App\Dice\Rules;

use App\Interfaces\DiceInterface;
use App\Interfaces\DiceRulesInterface;

abstract class AbstractBaseRules implements DiceRulesInterface, DiceInterface
{
    protected readonly array $allowedValues;
    protected int $throwsCounter = 0;
    protected ?int $roundPoints = 0;
    protected ?int $points = 0;

    public function __construct(array $allowedValues = null)
    {
        $this->allowedValues = $allowedValues ?? range(1, 6);
    }

    public function getName(): string
    {
        return static::STRATEGY_NAME;
    }

    public function roll(int $value = null): int
    {
        $this->throwsCounter++;
        $value = $value ?? $this->doRoll();
        $this->roundPoints = $this->roundPoints + $value;

        return $value;
    }

    protected function doRoll(): int
    {
        return $this->allowedValues[array_rand($this->allowedValues)];
    }

    public function reset(): void
    {
        $this->roundPoints = 0;
        $this->throwsCounter = 0;
    }

    public function getRoundPoints(): int
    {
        $points = $this->calculateRoundPoints();
        $this->points = $points;

        return $this->points;
    }

    private function calculateRoundPoints(): int
    {
        return $this->roundPoints <= 10
            ? $this->roundPoints
            : 0;
    }
}
