<?php

declare(strict_types=1);

namespace App\Player;

final class PlayResult
{
    public int $points;
    public int $totalPoints = 0;
    public array $throws = [];

    public function __construct(public readonly string $playerName, public readonly string $diceName)
    {
    }

    public function addThrow(int $points): void
    {
        $this->throws[] = $points;
        $this->totalPoints = $this->totalPoints + $points;
    }

    public function getRoundPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points)
    {
        $this->points = $points;
    }
}
