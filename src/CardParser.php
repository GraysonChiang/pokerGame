<?php

namespace App;

/**
 * Class CardParser
 * @package App
 */
class CardParser
{
    /**
     * @var string
     */
    private $cards;

    private $result;

    public function __construct(string $cards)
    {
        $this->cards = $cards;
        $this->parser();
    }

    public function parser()
    {
        $cards = explode(',', $this->cards);

        $this->result = array_map(function ($card) {
            return new Card($card);
        }, $cards);
    }

    public function getResult()
    {
        return $this->result;
    }
}