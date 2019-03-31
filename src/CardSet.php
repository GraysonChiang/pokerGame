<?php

namespace App;

class CardSet
{
    private $keyCard;

    /**
     * @var array
     */
    private $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    /* 順子 */
    public function isStraight()
    {
        $numbers = array_map(function (card $card) {
            return $card->getNumber();
        }, $this->cards);

        if (count(array_unique($numbers)) != 5) {
            return false;
        }

        $diff = 4;

        /* 因為 A 用 14 取代 */
        if (max($numbers) == 14) {
            sort($numbers);
            array_pop($numbers);
            $diff = 3;
        }

        return max($numbers) - min($numbers) == $diff;
    }

    /* 同花順 */
    public function isStraightFlush()
    {
    }

    /* 鐵支 */
    public function isFourOfAKind()
    {
    }

    /* 葫蘆 */
    public function isFullHouse()
    {
    }

    /* 同花 */
    public function isFlush()
    {
    }

    /* 三條 */
    public function isThreeOfKind()
    {
    }

    /* 兩對 */
    public function isTwoPair()
    {
    }

    /* 一對 */
    public function isOnePair()
    {
    }

}