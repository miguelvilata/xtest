<?php

declare(strict_types=1);

namespace App\Player;

final class PlayResult
{
    public function __construct(
        public readonly string $playerName,
        public readonly string $diceName,
        public readonly array $throws,
        public readonly int $points
    ) {
    }

    public function getRoundPoints(): int
    {
        return $this->points;
    }
}
