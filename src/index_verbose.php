<?php

declare(strict_types=1);

namespace App;

require '../vendor/autoload.php';

use App\Dice\Factory\DiceFactory;
use App\Game\DiceGame;
use App\Player\Player;
use App\ValueObjects\UserName;

const DICE_STRATEGY_1 = 1;
const DICE_STRATEGY_2 = 2;
const DICE_STRATEGY_3 = 3;
const ROUNDS_TO_PLAY = 3;

$players = [
    Player::create(new UserName('John'), DiceFactory::create(DICE_STRATEGY_1)),
    Player::create(new UserName('Hal'), DiceFactory::create(DICE_STRATEGY_2)),
    Player::create(new UserName(), DiceFactory::create(DICE_STRATEGY_3)),
];

$diceGame = DiceGame::create($players)->play(ROUNDS_TO_PLAY)->getResults();

foreach ($diceGame as $result) {
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
