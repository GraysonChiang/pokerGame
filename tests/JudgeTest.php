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
            ['S8,C8,H8', 'S7,C7,H7', 'S8'],
            ['S8,H8,D8', 'S8,H8,C8', 'D8'],
            ['S5,H5,D5,C3,S3', 'S5,H5,C5,C3,S3', 'D5']
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

    /**
     * 比較鐵支
     *
     * @dataProvider  fourOfAKindProvider
     * @param string $firstPlayerSet
     * @param string $secondPlayerSet
     * @param string $expected
     */
    public function testCompareFourOfAKind(string $firstPlayerSet, string $secondPlayerSet, string $expected)
    {
        $firstPlayer = $this->player1->setCards($firstPlayerSet);

        $secondPlayer = $this->player2->setCards($secondPlayerSet);

        $judge = new Judge($firstPlayer, $secondPlayer);

        $this->assertEquals($expected, $judge->compareFourOfAKind(
            $judge->getFirstPlayer()->getCardSet()->getCards(),
            $judge->getSecondPlayer()->getCardSet()->getCards()
        ));
    }

    public function fourOfAKindProvider()
    {
        return [
            ['S4,H4,D4,C4,S8', 'S4,H4,D4,C4,S8', ''],
            ['S4,H4,D4,C4,S5', 'S4,H4,D4,C4,S8', 'S8'],
            ['S2,H2,D2,C2,S5', 'S4,H4,D4,C4,S8', 'S2'],
            ['SA,HA,DA,CA,S5', 'S4,H4,D4,C4,S8', 'SA'],
            ['S4,H4,D4,C4,S5', 'SA,HA,DA,CA,S8', 'SA'],
        ];
    }

    /**
     * 比較葫蘆
     *
     * @dataProvider  fullHouseProvider
     * @param string $cardSet1
     * @param string $cardSet2
     * @param string $expected
     */
    public function testCompareFullHouse(string $cardSet1, string $cardSet2, string $expected)
    {
        $player1 = $this->player1->setCards($cardSet1);

        $player2 = $this->player2->setCards($cardSet2);

        $judge = new Judge($player1, $player2);

        $this->assertEquals($expected, $judge->compareFullHouse(
            $judge->getFirstPlayer()->getCardSet()->getCards(),
            $judge->getSecondPlayer()->getCardSet()->getCards()
        ));
    }

    public function fullHouseProvider()
    {
        return [
//            ['S10,H10,D10,C8,S8', 'S4,H4,D4,C8,S8', 'S10'], //平手
//            ['S5,H5,D5,CA,SA', 'S2,H2,D2,CK,SK', 'S2'],
//            ['S5,H5,C5,CA,SA', 'S5,H5,D5,CK,SK', 'D5'],
//            ['S2,H2,D2,C2,S5', 'S4,H4,D4,C4,S8', 'S2'],
//            ['SA,HA,DA,CA,S5', 'S4,H4,D4,C4,S8', 'SA'],
//            ['S4,H4,D4,C4,S5', 'SA,HA,DA,CA,S8', 'SA'],
        ];
    }

    /* 同花 */
    public function testCompareFlush()
    {
        $this->assertTrue(true);
    }

    /**
     * 三條
     * @dataProvider  threeOfKindProvider
     * @param string $cardSet1
     * @param string $cardSet2
     * @param string $expected
     */
    public function testCompareThreeOfKind(string $cardSet1, string $cardSet2, string $expected)
    {
        $player1 = $this->player1->setCards($cardSet1);

        $player2 = $this->player2->setCards($cardSet2);

        $judge = new Judge($player1, $player2);

        $this->assertEquals($expected, $judge->compareThreeOfKind(
            $judge->getFirstPlayer()->getCardSet()->getCards(),
            $judge->getSecondPlayer()->getCardSet()->getCards()
        ));
    }

    public function threeOfKindProvider()
    {
        return [
//            ['S10,H10,D10,C3,S8', 'S4,H4,D4,C3,S8', 'S10'], //平手
//            ['S5,H5,D5,CA,S3', 'S2,H2,D2,CK,S8', 'S2'],
            ['S5,H5,D5,CK,SJ', 'S5,H5,C5,CK,SJ', 'D5'],
//            ['S2,H2,D2,C2,S5', 'S4,H4,D4,C4,S8', 'S2'],
//            ['SA,HA,DA,CA,S5', 'S4,H4,D4,C4,S8', 'SA'],
//            ['S4,H4,D4,C4,S5', 'SA,HA,DA,CA,S8', 'SA'],
        ];
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


    public function testGetSpecificCards()
    {
        $player1 = $this->player1->setCards('SA,HA,DA,S4,S5');

        $player2 = $this->player2->setCards('S10,H10,D10,C10,S5');

        $judge = new Judge($player1, $player2);

        $this->assertCount(
            3,
            $judge->getSpecificCards($judge->getFirstPlayer()->getCardSet()->getCards(), 14)
        );

        $this->assertCount(
            4,
            $judge->getSpecificCards($judge->getSecondPlayer()->getCardSet()->getCards(), 10)
        );
    }
}
