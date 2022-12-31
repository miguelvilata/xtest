<?php
declare(strict_types=1);

use App\Dice\Factory\DiceFactory;
use App\Game\DiceGame;
use App\Interfaces\DiceRulesInterface;
use App\Player\Player;
use App\ValueObjects\UserName;
use PHPUnit\Framework\TestCase;
use App\Dice\Rules\Strategies\Dice1Rules;
use App\Dice\Rules\Strategies\Dice2Rules;
use App\Game\GameResult;

final class DiceRulesTest extends TestCase
{
    public function testDice1Rules3TimesMax(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules());

        $this->assertInstanceOf(GameResult::class, $roundResult);
        $this->assertEquals(3, $roundResult->getThrowsCount());
    }

    public function testDice1RulesGetPoints(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules([3]));
        $this->assertEquals(9, $roundResult->getPoints());
    }

    public function testDice1RulesGetZeroPoints(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules([6]));
        $this->assertEquals(0, $roundResult->getPoints());
    }

    public function testDice2RulesStopWhenTotalAbove5(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([6]));
        $this->assertInstanceOf(GameResult::class, $roundResult);
        $this->assertEquals(0, $roundResult->getThrowsCount());
        $this->assertEquals(0, $roundResult->getPoints());
    }

    public function testDice2RulesStopWhenTotalUnder6(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([5]));
        $this->assertEquals(1, $roundResult->getThrowsCount());
        $this->assertEquals(5, $roundResult->getPoints());
    }

    public function testUnExistentRuleException()
    {
        $this->expectException(\App\Exceptions\InvalidDiceStrategyException::class);
        DiceFactory::create(-1);
    }

    private function buildPlayResultFor(DiceRulesInterface $diceRules): GameResult
    {
        $diceGame = $this->buildGameResultsForDiceRules($diceRules);
        $this->assertIsArray($diceGame);
        $this->assertTrue(1 === count($diceGame));

        return $diceGame[0];
    }

    private function buildGameResultsForDiceRules(DiceRulesInterface $diceRules): array
    {
        $players = [
            Player::create(new UserName('John'), $diceRules),
        ];

        return DiceGame::create($players)->play(1)->getResults();
    }
}
