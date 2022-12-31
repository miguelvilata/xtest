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

DiceGame::create($players)->play(ROUNDS_TO_PLAY)->print(true);

