<?php

use App\Judge;
use App\Player;
use PHPUnit\Framework\TestCase;
use test\Mockery\ArgumentObjectTypeHint;

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
        $this->player2 = new Player('Grayson');
    }


    public function test_GetStraightFlushKey()
    {
        $this->player1->setCards('CA,C2,C3,C4,C5');
        $this->player2->setCards('CA,C2,C3,C4,C5');

        $judge = new Judge($this->player1, $this->player2);

        $judge->getStraightFlushKey($this->player2);

        $this->assertTrue(true);
    }


//    public function test_Judge()
//    {
//        $this->player1->setCards('CA,C2,C3,C4,C5');
//
//        $this->player2->setCards('CA,C2,C3,C4,C5');
//
//        $judge = new Judge($this->player1, $this->player2);
//
//        $this->assertEquals('true', $judge->judge());
//
//        $this->assertTrue(true);
//    }

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
