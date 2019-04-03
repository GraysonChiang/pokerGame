<?php

use App\Card;
use App\CardSet;
use App\CardParser;
use PHPUnit\Framework\TestCase;

class CardSetTest extends TestCase
{

    /**
     * @dataProvider sortProvider
     * @param string $cardSet
     */
    public function testSortCards(string $cardSet)
    {
        $cardArray = explode(',', $cardSet);

        $rand = explode(',', $cardSet);

        shuffle($rand);

        $cardSet = $this->getCardSet(implode(',', $rand));

        /* @var $card Card */
        foreach ($cardSet->sortCards($cardSet->getCards()) as $key => $card) {
            $this->assertEquals($cardArray[$key], $card->getOrigin());
        }

        $this->assertIsArray($cardSet->getCards());
    }

    public function sortProvider(): array
    {
        return [
            ['HA,DA,CA,H6,S5'],
            ['C2,CA,C5,C4,H3'],
            ['HA,CA,H6,H3,C3'],
            ['HA,CA,H6,C4,H3'],
            ['SA,HA,DA,CA,H6'],
            ['HA,DA,CA,H6,S5'],
            ['H6,C6,S5,H5,D5'],
            ['S2,SA,H5,C4,D3'],
            ['SA,HA,H5,C4,D3'],
            ['SA,H6,H5,C4,D3'],
            ['DA,CK,HQ,HJ,S10'],
            ['D2,S6,H5,H4,C3'],
            ['DK,SQ,HJ,H10,C9'],
        ];
    }

    /**
     * @dataProvider maximumCardProvider
     * @param string $cardSet
     * @param string $expectResult
     */
    public function testGetMaximumCard(string $cardSet, string $expectResult)
    {
        $cardSet = $this->getCardSet($cardSet);

        $this->assertEquals($expectResult, $cardSet->getMaximumCard());
    }

    /**
     * @return array
     */
    public function maximumCardProvider(): array
    {
        return [
            ['C10,CJ,CQ,CK,CA', 'CA'],
            ['C1,C2,C3,C4,H5', 'C2'],
            ['CA,HA,C3,H3,H6', 'HA'],
            ['CA,HA,C4,H3,H6', 'HA'],
            ['SA,HA,DA,CA,H6', 'SA'],
            ['S5,HA,DA,CA,H6', 'S5'],
            ['S5,H5,D5,C6,H6', 'S5'],
            ['S1,S2,D3,C4,H5', 'S2'],
            ['S1,H1,D3,C4,H5', 'S1'],
            ['S1,H6,D3,C4,H5', 'S1'],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param string $cardSet
     * @param string $expectResult
     */
    public function testGetResult(string $cardSet, string $expectResult)
    {
        $cardSet = $this->getCardSet($cardSet);

        $this->assertEquals($expectResult, $cardSet->getResult());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            ['C10,CJ,CQ,CK,CA', 'straight_flush'],
            ['C1,C2,C3,C4,H5', 'straight'],
            ['CA,HA,C3,H3,H6', 'two_pair'],
            ['CA,HA,C4,H3,H6', 'one_pair'],
            ['SA,HA,DA,CA,H6', 'four_of_a_kind'],
            ['S5,HA,DA,CA,H6', 'three_of_Kind'],
            ['S5,H5,D5,C6,H6', 'full_house'],
            ['S1,S2,D3,C4,H5', 'straight'],
            ['S1,H1,D3,C4,H5', 'one_pair'],
            ['S1,H6,D3,C4,H5', 'high_card'],
        ];
    }

    public function testIsStraight()
    {
        $cards = 'C10,CJ,CQ,CK,CA';

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
