<?php

use App\Card;
use App\CardParser;
use PHPUnit\Framework\TestCase;

class CardParserTest extends TestCase
{

    public function test_getResult()
    {
        $cardParser = new CardParser('HA,H2,H3,H4,H5');

        $cards = $cardParser->getResult();

        $this->assertCount(5, $cards);

        array_walk($cards, function (Card $card) {
            $this->assertInstanceOf(Card::class, $card);
        });
    }
}
