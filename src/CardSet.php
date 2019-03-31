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
        $numbers = $this->getAllNumber();

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
        $numbers = $this->getAllNumber();

        $numbers = $this->getGroupByValueResult($numbers);

        return (($numbers[2] ?? 0) == 1) && (($numbers[3] ?? 0) == 1);
    }

    public function getGroupByValueResult($array)
    {
        return array_count_values(array_count_values($array));
    }

    /* 同花 */
    public function isFlush()
    {
        $colors = $this->getAllColor();

        return count(array_unique($colors)) == 1;
    }

    /* 三條 */
    public function isThreeOfKind()
    {
        $numbers = $this->getAllNumber();

        $numbers = $this->getGroupByValueResult($numbers);

        return (($numbers[3] ?? 0) == 1) && (($numbers[2] ?? 0) != 1);
    }

    /* 兩對 */
    public function isTwoPair()
    {
    }

    /* 一對 */
    public function isOnePair()
    {
    }

    /**
     * @return array
     */
    protected function getAllNumber(): array
    {
        return array_map(function (card $card) {
            return $card->getNumber();
        }, $this->cards);
    }

    /**
     * @return array
     */
    protected function getAllColor(): array
    {
        return array_map(function (card $card) {
            return $card->getColor();
        }, $this->cards);
    }

}