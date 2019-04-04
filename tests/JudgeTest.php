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
                $judge->getFistPlayer()->getCardSet()->getCards(),
                $judge->getSecondPlayer()->getCardSet()->getCards()
            ));
    }

    public function compareProvider()
    {
        return [
            ['C2,CA,C6,C4,C5', 'C2,CA,C6,C4,C3', 'C5'],
            ['C2,CA,CJ,C4,C5', 'C2,CA,C10,C4,C3', 'CJ']
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

        $this->assertEquals('7', $judge->getWeight($judge->getFistPlayer()->getCardSet()->getResult()));
    }

    public function test_GetPlayer2Weight()
    {
        $this->player2->setCards('CA,C2,C3,C4,C5');

        $judge = new Judge($this->player1, $this->player2);

        $this->assertEquals('7', $judge->getWeight($judge->getSecondPlayer()->getCardSet()->getResult()));
    }
}
