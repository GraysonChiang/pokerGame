<?php

use App\Judge;
use App\Player;
use PHPUnit\Framework\TestCase;

class JudgeTest extends TestCase
{
    /**
     * @var Player
     */
    private $player1;

    /**
     * @var Player
     */
    private $player2;

    public function setUp()
    {
        $this->player1 = new Player('peter');
        $this->player2 = new Player('grayson');
    }

    public function testGetStraightFlushKey()
    {
        $firstPlayer = $this->player1->setCards('CA,C2,C3,C4,C5');

        $secondPlayer = $this->player2->setCards('CA,C2,C3,C4,C5');

        $judge = new Judge($firstPlayer, $secondPlayer);

//        $judge->getStraightFlushKey($this->player2);

        $this->assertTrue(true);
    }

    /**
     * @dataProvider  compareProvider
     * @param string $firstPlayerSet
     * @param string $secondPlayerSet
     * @param string $expected
     */
    public function testCompareCardSet(string $firstPlayerSet, string $secondPlayerSet, string $expected)
    {
        $firstPlayer = $this->player1->setCards($firstPlayerSet);

        $secondPlayer = $this->player2->setCards($secondPlayerSet);

        $judge = new Judge($firstPlayer, $secondPlayer);

        $this->assertEquals(
            $expected,
            $judge->compareCardSet(
                $judge->getFirstPlayer()->getCardSet()->getCards(),
                $judge->getSecondPlayer()->getCardSet()->getCards()
            ));
    }

    public function compareProvider()
    {
        return [
            ['C2,CA,C6,C4,C5', 'C2,CA,C6,C4,C3', 'C5'],
            ['C2,CA,CJ,C4,C5', 'C2,CA,C10,C4,C3', 'CJ'],
            ['S2,HA,CA,C9,C5', 'S2,HA,CA,C6,C5', 'C9'],
            ['S8,C7,C5,D4,D3', 'S8,C7,C3,D4,D3', 'C5'],
        ];
    }

    public function test_GetWeight()
    {
        $cardType = 'straight_flush';

        $judge = new Judge($this->player1, $this->player2);

        $this->assertEquals('10', $judge->getWeight($cardType));
    }

    public function test_GetPlayer1Weight()
    {
        $this->player1->setCards('CA,C2,C3,C4,C5');

        $judge = new Judge($this->player1, $this->player2);

        $this->assertEquals('10', $judge->getWeight($judge->getFirstPlayer()->getCardSet()->getResult()));
    }

    public function test_GetPlayer2Weight()
    {
        $this->player2->setCards('CA,C2,C3,C4,C5');

        $judge = new Judge($this->player1, $this->player2);

        $this->assertEquals('10', $judge->getWeight($judge->getSecondPlayer()->getCardSet()->getResult()));
    }

    /**
     * 順子
     * @dataProvider  compareProvider
     * @param string $firstPlayerSet
     * @param string $secondPlayerSet
     * @param string $expected
     */
    public function testCompareStraight(string $firstPlayerSet, string $secondPlayerSet, string $expected)
    {
        $firstPlayer = $this->player1->setCards($firstPlayerSet);

        $secondPlayer = $this->player2->setCards($secondPlayerSet);

        $judge = new Judge($firstPlayer, $secondPlayer);

        $this->assertEquals(
            $expected,
            $judge->compareStraight(
                $judge->getFirstPlayer()->getCardSet()->getCards(),
                $judge->getSecondPlayer()->getCardSet()->getCards()
            ));
    }

    /**
     * 同花順子
     * @dataProvider  compareProvider
     * @param string $firstPlayerSet
     * @param string $secondPlayerSet
     * @param string $expected
     */
    public function testCompareStraightFlush(string $firstPlayerSet, string $secondPlayerSet, string $expected)
    {
        $firstPlayer = $this->player1->setCards($firstPlayerSet);

        $secondPlayer = $this->player2->setCards($secondPlayerSet);

        $judge = new Judge($firstPlayer, $secondPlayer);

        $this->assertEquals(
            $expected,
            $judge->compareStraightFlush(
                $judge->getFirstPlayer()->getCardSet()->getCards(),
                $judge->getSecondPlayer()->getCardSet()->getCards()
            ));
    }

    /* 鐵支 */
    public function testCompareFourOfAKind()
    {
        $firstPlayer = $this->player1->setCards('SA,HA,DA,CA,S6');

        $secondPlayer = $this->player2->setCards('S2,H2,D2,C2,S8');

        $judge = new Judge($firstPlayer, $secondPlayer);

        $this->assertEquals(
            '',
            $judge->compareFourOfAKind(
                $judge->getFirstPlayer()->getCardSet()->getCards(),
                $judge->getSecondPlayer()->getCardSet()->getCards()
            ));
    }

    /* 葫蘆 */
    public function testCompareFullHouse()
    {
        $this->assertTrue(true);
    }

    /* 同花 */
    public function testCompareFlush()
    {
        $this->assertTrue(true);
    }

    /* 三條 */
    public function testCompareThreeOfKind()
    {
        $this->assertTrue(true);
    }

    /* 兩對 */
    public function testCompareTwoPair()
    {
        $this->assertTrue(true);
    }

    /* 一對 */
    public function testCompareOnePair()
    {
        $this->assertTrue(true);
    }
}
