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
const ROUNDS_TO_PLAY = 100;

$players = [
    Player::create(new UserName('John'), DiceFactory::create(DICE_STRATEGY_1)),
    Player::create(new UserName('Hal'), DiceFactory::create(DICE_STRATEGY_2)),
];

$diceGame = DiceGame::create($players)->play(ROUNDS_TO_PLAY)->getResults();

foreach ($diceGame as $result) {
    $playerResult = sprintf('%s: %s points %s', $result->playerName, $result->getPoints(), PHP_EOL);
    print $playerResult;
}
