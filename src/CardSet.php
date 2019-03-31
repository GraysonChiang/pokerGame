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

        if (max($numbers) != 14) {
            return max($numbers) - min($numbers) == 4;
        }

        /* 因為 A 用 14 取代 */
        sort($numbers);
        array_pop($numbers);

        if (max($numbers) + 1 != 14 && min($numbers) - 1 != 14) {
            return false;
        }

        /*
         * J Q K A 2 : 扣除掉 A 後，剩下加總為 38
         * 10 J Q K A : 扣除掉 A 後，剩下加總為 46
         * A 2 3 4 5 : 扣除掉 A 後，剩下加總為 14
         *
         * */
        if (in_array(array_sum($numbers), [38, 46, 14])) {
            return true;
        }

        return false;
    }

    /* 同花順 */
    public function isStraightFlush()
    {
        return $this->isFlush() && $this->isStraight();
    }

    /* 鐵支 */
    public function isFourOfAKind()
    {
        $numbers = $this->getAllNumber();

        $numbers = $this->getGroupByValueResult($numbers);

        return (($numbers[4] ?? 0) == 1);

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
        $numbers = $this->getAllNumber();

        $numbers = $this->getGroupByValueResult($numbers);

        return (($numbers[2] ?? 0) == 2);
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