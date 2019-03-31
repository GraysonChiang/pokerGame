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

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isStraight());
    }

    public function testIsFlush()
    {
        $cards = 'H9,HK,HQ,HJ,H10';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isFlush());

    }

    public function testIsFullHouse()
    {
        $cards = 'H1,A1,S2,S2,H2';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isFullHouse());
    }

    public function testIsThreeOfKind()
    {
        $cards = 'H1,C5,S2,S2,H2';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isThreeOfKind());

    }

    public function testIsStraightFlush()
    {
        $cards = 'C9,C10,CJ,CQ,CK';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isStraightFlush());
    }

    public function testIsTwoPair()
    {
        $cards = 'C9,H9,C3,H3,S4';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isTwoPair());
    }

    public function testIsFourOfAKind()
    {
        $cards = 'C1,H1,S1,D1,S4';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isFourOfAKind());
    }

    public function testIsOnePair()
    {
        $cards = 'C9,H10,C3,H3,S6';

        $cardSet = $this->getCardSet($cards);

        $this->assertTrue($cardSet->isOnePair());
    }

    /**
     * @param string $cards
     * @return CardSet
     */
    protected function getCardSet(string $cards): CardSet
    {
        $cardParser = new CardParser($cards);

        return new CardSet($cardParser->getResult());
    }
}
