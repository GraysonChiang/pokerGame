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
//        $cards = 'CA,C2,H2,H5,C5';
        $cards = 'C10,CJ,CQ,CK,CA';
//        $cards = 'CJ,CQ,CK,CA,C2';
//        $cards = 'C9,C10,CJ,CQ,CA';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isStraight());
    }

    public function testIsFlush()
    {
        $cards = 'H9,HK,HQ,HJ,H10';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isFlush());

    }

    public function testIsFullHouse()
    {
        $cards = 'H1,A1,S2,S2,H2';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isFullHouse());
    }

    public function testIsThreeOfKind()
    {
        $cards = 'H1,C5,S2,S2,H2';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isThreeOfKind());

    }

    public function testIsStraightFlush()
    {
        $cards = 'C9,C10,CJ,CQ,CK';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isStraightFlush());
    }

    public function testIsTwoPair()
    {
        $cards = 'C9,H9,C3,H3,S4';

        $cardParser = new CardParser($cards);

        $cardSet = new CardSet($cardParser->getResult());

        $this->assertTrue($cardSet->isTwoPair());
    }

    public function testIsFourOfAKind()
    {

    }
}
