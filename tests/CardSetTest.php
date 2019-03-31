<?php

use App\CardParser;
use App\CardSet;
use PHPUnit\Framework\TestCase;

class CardSetTest extends TestCase
{

    public function test_IsOnePair()
    {
        $this->assertTrue(true);
    }

    public function testIsStraight()
    {
        $cards = 'H9,HK,HQ,HJ,S10';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isStraight());
    }

    public function testIsFlush()
    {

    }

    public function testIsFullHouse()
    {

    }

    public function testIsThreeOfKind()
    {

    }

    public function testIsStraightFlush()
    {

    }

    public function testIsTwoPair()
    {

    }

    public function testIsFourOfAKind()
    {

    }
}
