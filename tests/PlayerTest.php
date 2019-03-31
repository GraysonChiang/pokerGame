<?php

use App\CardSet;
use App\Player;
use PHPUnit\Framework\TestCase;

class  PlayerTest extends TestCase
{
    public function test_Player()
    {
        $playerName = 'peter';
        $player = new Player($playerName);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function test_PlayerCards()
    {
        $playerName = 'peter';
        $player = new Player($playerName);

        $cards = 'CA,C2,C3,C4,C5';
        $player->setCards($cards);

        $this->assertInstanceOf(CardSet::class,$player->getCardSet());
    }
}
