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
    //This test checks a series of [3,3,3]
    public function testDice1RulesGetPoints(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules([3]));
        $this->assertEquals(3, $roundResult->getThrowsCount());
        $this->assertEquals(9, $roundResult->getPoints());
    }

    //This test checks a series of [6,6]
    public function testDice1RulesGetZeroPoints(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules([6]));
        $this->assertEquals(2, $roundResult->getThrowsCount());
        $this->assertEquals(0, $roundResult->getPoints());
    }

    //This test checks a series of [1,1,1]
    public function testDice1RulesGets3Points(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice1Rules([1]));
        $this->assertEquals(3, $roundResult->getThrowsCount());
        $this->assertEquals(3, $roundResult->getPoints());
    }

    //when total round is above 5 the last throw is accepted and computed
    //for logic related to calculate round point. Currently if
    //total round > 10 ten points = 0. This test checks a series of [6]
    public function testDice2RulesStopWhenTotalRoundAbove5(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([6]));
        $this->assertInstanceOf(GameResult::class, $roundResult);
        $this->assertEquals(1, $roundResult->getThrowsCount());
        $this->assertEquals(6, $roundResult->getPoints());
    }

    //the rules will execute this throws (5,5,5) that should result in zero points
    //due the value is above 10
    //This test checks a series of [5,5]
    public function testDice2RulesWhenFixedValue(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([5]));
        $this->assertEquals(2, $roundResult->getThrowsCount());
        $this->assertEquals(10, $roundResult->getPoints());
    }

    //when the only value available is 1, there must be 6 throws and 6 points
    //This test checks a series of [1,1,1,1,1,1]
    public function testDice2RulesCheckPointsValue(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([1]));
        $this->assertEquals(6, $roundResult->getThrowsCount());
        $this->assertEquals(6, $roundResult->getPoints());
    }

    //This test checks a series of [4,4]
    public function testDice2RulesGetZeroPoints(): void
    {
        $roundResult = $this->buildPlayResultFor(new Dice2Rules([4]));
        $this->assertEquals(2, $roundResult->getThrowsCount());
        $this->assertEquals(8, $roundResult->getPoints());
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
