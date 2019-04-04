<?php

namespace App;

class CardSet
{

    /* @var array */
    private $cards;

    private $maximumCard;

    /**
     * CardSet constructor.
     * @param Card[] $cards
     */
    public function __construct(array $cards)
    {
        $this->cards = $this->sortCards($cards);
        $this->maximumCard = $this->extractMaximumCard($cards);
    }

    /* 順子 */
    public function isStraight()
    {
        $numbers = $this->getAllNumber();

        if (count(array_unique($numbers)) != 5) {
            return false;
        }

        if (max($numbers) < 14) {
            return max($numbers) - min($numbers) == 4;
        }

        sort($numbers);

        if (in_array('15', $numbers)) {
            array_pop($numbers);
        }

        if (in_array('14', $numbers)) {
            array_pop($numbers);
        }

        /*
         * J Q K : 扣除掉 A 2 後，剩下加總為 36
         * 10 J Q K  : 扣除掉 A 後，剩下加總為 46
         * 3 4 5 : 扣除掉 A 後，剩下加總為 12
         *
         * */
        if (in_array(array_sum($numbers), [12, 36, 46])) {
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

    private function getGroupByValueResult($array)
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
        $numbers = $this->getAllNumber();

        $numbers = $this->getGroupByValueResult($numbers);

        return (($numbers[2] ?? 0) == 1);
    }

    /**
     * @return array
     */
    public function getAllNumber(): array
    {
        return array_map(function (card $card) {
            return $card->getNumber();
        }, $this->cards);
    }

    /**
     * @return array
     */
    public function getAllColor(): array
    {
        return array_map(function (card $card) {
            return $card->getColor();
        }, $this->cards);
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function getResult(): string
    {
        if ($this->isFlush() && $this->isStraight()) {
            return 'straight_flush';
        }

        if ($this->isFourOfAKind()) {
            return 'four_of_a_kind';
        }

        if ($this->isFullHouse()) {
            return 'full_house';
        }

        if ($this->isFlush()) {
            return "flush";
        }

        if ($this->isStraight()) {
            return 'straight';
        }

        if ($this->isThreeOfKind()) {
            return 'three_of_Kind';
        }

        if ($this->isTwoPair()) {
            return 'two_pair';
        }

        if ($this->isOnePair()) {
            return 'one_pair';
        }

        return 'high_card';
    }

    /**
     * ================================
     * 提取最大的卡牌
     * ================================
     *
     * @param Card[] $cards
     * @return mixed
     */
    public function extractMaximumCard(array $cards)
    {
        $num = $type = 0;
        $string = '';

        foreach ($cards as $card) {
            $cardNum = $card->getNumber();

            if ($num > $cardNum) {
                continue;
            }
            if ($type > $card->getColor()) {
                continue;
            }
            $num = $cardNum;
            $type = $card->getColor();
            $string = $card->getOrigin();
        }

        return $string;
    }

    /**
     * @return mixed
     */
    public function getMaximumCard()
    {
        return $this->maximumCard;
    }

    /**
     * ================================
     * 將牌組排序，由大到小
     * ================================
     *
     * @param Card[] $cards
     * @return array
     */
    public function sortCards(array $cards)
    {
        usort($cards, function (Card $card, Card $card2) {
            if ($card->getNumber() == $card2->getNumber()) {
                return $card->getColor() < $card2->getColor() ? 1 : -1;
            }

            return $card->getNumber() < $card2->getNumber() ? 1 : -1;
        });

        return $cards;
    }
}