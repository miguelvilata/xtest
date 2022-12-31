<?php

declare(strict_types=1);

namespace App\Player;

use App\Interfaces\DiceInterface;
use App\ValueObjects\UserName;

final class Player
{
    private readonly string $name;
    private DiceInterface $dice;

    public function __construct(UserName $name, DiceInterface $dice)
    {
        $this->name = $name->value();
        $this->dice = $dice;
    }

    public function __toString()
    {
        return sprintf('player_%s', $this->id);
    }

    public static function create(UserName $name, DiceInterface $dice): self
    {
        return new self($name, $dice);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiceStrategy(): string
    {
        return $this->dice->getName();
    }

    //plays a round that consists in throwing the dice until the dice rules force stop
    public function playRound(): PlayResult
    {
        $this->dice->reset();

        while ($this->dice->canRoll()) {
            $this->dice->roll();
        }

        return new PlayResult($this->name, $this->dice->getName(), $this->dice->getThrows(), $this->dice->getRoundPoints());
    }
}
