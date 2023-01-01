<?php

declare(strict_types=1);

namespace App\Game;

final class DiceGameResult
{
    private int $points = 0;
    private array $throws = [];
    private int $throwsCount = 0;

    public function __construct(public string $playerName, public string $strategy)
    {
    }

    public function addPoints(int $points): void
    {
        $this->points = $this->points + $points;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function addThrow($round, array $throw, int $points): void
    {
        $this->throwsCount = $this->throwsCount + count($throw);
        $this->throws[$round] = sprintf('(%s): %s points', implode(',', $throw), $points);
    }

    public function getThrows(): array
    {
        return $this->throws;
    }

    public function getThrowsCount(): int
    {
        return $this->throwsCount;
    }
}
