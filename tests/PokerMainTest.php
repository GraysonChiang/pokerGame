<?php

use App\Player;
use App\PokerMain;
use PHPUnit\Framework\TestCase;

class PokerMainTest extends TestCase
{

    public function test_BattleDraw()
    {
        $poker = new PokerMain();

        $poker->setFirstPlayer('peter', 'C1,C2,C3,C4,C5');

        $poker->setSecondPlayer('grayson', 'C1,C2,C3,C4,C5');

        $this->assertEquals('draw,', $poker->battle());
    }

    public function test_setFirstPlayer()
    {
        $poker = new PokerMain();

        $poker->setFirstPlayer('peter', 'C1,C2,C3,C4,C5');

        $this->assertInstanceOf(Player::class, $poker->getFirstPlayer());
    }

    public function test_setSecondPlayer()
    {
        $poker = new PokerMain();

        $poker->setSecondPlayer('peter', 'C1,C2,C3,C4,C5');

        $this->assertInstanceOf(Player::class, $poker->getSecondPlayer());
    }
}