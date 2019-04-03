<?php

namespace App;

class Player
{
    protected $name;

    protected $cardsSet;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setCards(string $cards)
    {
        $cardParser = new CardParser($cards);

        $this->cardsSet = new CardSet($cardParser->getResult());
    }

    public function getCardSet(): CardSet
    {
        return $this->cardsSet;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}