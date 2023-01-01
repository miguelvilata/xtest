<?php

declare(strict_types=1);

namespace App\Game;

use App\Player\Player;

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
            $gameResult = new DiceGameResult($player->getName(), $player->getDiceStrategy());
            $this->playRounds($rounds, $player, $gameResult);
            $this->results[] = $gameResult;
        }

        return $this;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function print(bool $verbose = false): void
    {
        if ($verbose) {
            $this->printVerbose();
            return;
        }

        foreach ($this->getResults() as $result) {
            $playerResult = sprintf('%s: %s points %s', $result->playerName, $result->getPoints(), PHP_EOL);
            print $playerResult;
        }
    }

    private function printVerbose(): void
    {
        foreach ($this->getResults() as $result) {
            print PHP_EOL;
            print sprintf('Player: %s%s', $result->playerName, PHP_EOL);
            print sprintf('%s %s', str_repeat('-', 20), PHP_EOL);
            print sprintf("Strategy: %s%s", $result->strategy, PHP_EOL);
            print sprintf("Points: %s%s", $result->getPoints(), PHP_EOL);

            foreach ($result->getThrows() as $throw) {
                print sprintf("   Accepted throws: %s%s", $throw, PHP_EOL);
            }
            print PHP_EOL;
        }
    }

    private function playRounds(int $rounds, Player $player, DiceGameResult $gameResult): void
    {
        for ($i = 0; $i < $rounds; $i++) {
            $roundResult = $player->playRound();
            $gameResult->addPoints($roundResult->getRoundPoints());
            $gameResult->addThrow($i, $roundResult->throws, $roundResult->getRoundPoints());
        }
    }
}
