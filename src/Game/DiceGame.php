<?php

declare(strict_types=1);

namespace App\Game;

final class DiceGame
{
    private array $results = [];

    public function __construct(private readonly array $players)
    {
    }

    public static function create(array $players): self
    {
        return new self($players);
    }

    public function play($rounds = 1): self
    {
        foreach ($this->players as $player) {
            $gameResult = new GameResult($player->getName(), $player->getDiceStrategy());
            $this->playRounds($rounds, $player, $gameResult);
            $this->results[] = $gameResult;
        }

        return $this;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    private function playRounds(mixed $rounds, mixed $player, GameResult $gameResult): void
    {
        for ($i = 0; $i < $rounds; $i++) {
            $roundResult = $player->playRound();
            $gameResult->addPoints($roundResult->getRoundPoints());
            $gameResult->addThrow($i, $roundResult->throws, $roundResult->getRoundPoints());
        }
    }
}
