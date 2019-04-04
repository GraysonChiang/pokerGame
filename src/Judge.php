<?php

namespace App;

class Judge
{
    /** @var string */
    private $result;

    private $fistPlayer;

    private $secondPlayer;

    public function __construct(Player $fistPlayer, Player $secondPlayer)
    {
        $this->fistPlayer = $fistPlayer;
        $this->secondPlayer = $secondPlayer;
    }

    /**
     * @return Player
     */
    public function getFirstPlayer(): Player
    {
        return $this->fistPlayer;
    }

    /**
     * @return Player
     */
    public function getSecondPlayer(): Player
    {
        return $this->secondPlayer;
    }

    /* todo:: */
    public function judge()
    {
        if ($this->getPlayer1Weight() > $this->getPlayer2Weight()) {
            return $this->getFirstPlayer()->getName() . ' win card:' . $this->getKeyCard($this->getFirstPlayer(), $this->getSecondPlayer());
        }

        if ($this->getPlayer2Weight() > $this->getPlayer2Weight()) {
            return $this->getSecondPlayer()->getName() . ' win card:' . $this->getKeyCard($this->getSecondPlayer(), $this->getFirstPlayer());
        }

        if ($this->getPlayer1Weight() == $this->getPlayer2Weight()) {
            return 'draw';
        }

        return 'no win';
    }

    public function getKeyCard(Player $winner, Player $loser)
    {
//        $winnerCard = $winner->getCardSet()->getCards();
//        $this->compareCardSet($winner->getCardSet()->getCards(), $loser->getCardSet()->getCards());
    }

    public function getPlayer1Weight()
    {
        return $this->getWeight($this->fistPlayer->getCardSet()->getResult());
    }

    public function getPlayer2Weight()
    {
        return $this->getWeight($this->secondPlayer->getCardSet()->getResult());
    }

    /**
     * 比較單張
     *
     * @param Card[] $cardSet
     * @param Card[] $cardSet2
     * @return string
     */
    public function compareCardSet(array $cardSet, array $cardSet2)
    {
        foreach (range(0, count($cardSet) - 1) as $k) {
            $cardNum = $cardSet[$k]->getNumber();
            $card2Num = $cardSet2[$k]->getNumber();

            if ($cardNum > $card2Num) {
                return $cardSet[$k]->getOrigin();
            }

            if ($cardSet[$k]->getColor() > $cardSet2[$k]->getColor()) {
                return $cardSet[$k]->getOrigin();
            }
        }

        return '';
    }

    /* 比較順子 */
    public function compareStraight(array $cardSet, array $cardSet2)
    {
        return $this->compareCardSet($cardSet, $cardSet2);
    }

    /* 比較同花順 */
    public function compareStraightFlush(array $cardSet, array $cardSet2)
    {
        return $this->compareCardSet($cardSet, $cardSet2);
    }

    /**
     * @param Card[] $cardSet
     * @return array
     */
    public function getCardSummary(array $cardSet): array
    {
        return array_count_values(array_map(function (Card $card) {
            return $card->getNumber();
        }, $cardSet));
    }

    /* 比較鐵支 */
    public function compareFourOfAKind(array $cardSet, array $cardSet2)
    {
        $cardSetGroupBy = array_flip($this->getCardSummary($cardSet));

        $cardSet2GroupBy = array_flip($this->getCardSummary($cardSet2));

        $winnerSet = [];

        if ($cardSetGroupBy[4] == $cardSet2GroupBy[4]) {
            array_push($winnerSet, $cardSetGroupBy[4] > $cardSetGroupBy[1] ? end($cardSet) : reset($cardSet));
            array_push($winnerSet, $cardSet2GroupBy[4] > $cardSet2GroupBy[1] ? end($cardSet2) : reset($cardSet2));
            return $winnerSet[0] != $winnerSet[1] ? $this->extractMaximumCard($winnerSet) : '';
        }

        $winnerSet = $cardSetGroupBy[4] > $cardSet2GroupBy[4] ? $cardSet : $cardSet2;

        $cardSetMaxNumber = $cardSetGroupBy[4] > $cardSet2GroupBy[4] ? $cardSetGroupBy[4] : $cardSet2GroupBy[4];

        return $this->extractMaximumCard(array_filter($winnerSet, function (Card $card) use ($cardSetMaxNumber) {
            return $card->getNumber() == $cardSetMaxNumber;
        }));
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

    /* 比較葫蘆 */
    public function compareFullHouse(array $cardSet, array $cardSet2)
    {

        return '';
    }

    /* 比較同花 */
    public function compareFlush(array $cardSet, array $cardSet2)
    {

    }

    /* 比較三條 */
    public function compareThreeOfKind(array $cardSet, array $cardSet2)
    {
        $setGroup = array_flip($this->getCardSummary($cardSet));

        $setGroup2 = array_flip($this->getCardSummary($cardSet2));

        $winnerSet = $setGroup[3] > $setGroup2[3] ? $cardSet : $cardSet2;

        $winnerNum = $setGroup[3] > $setGroup2[3] ? $setGroup[3] : $setGroup2[3];

        $winnerSet = $this->getSpecificCards($winnerSet, $winnerNum);

        if ($setGroup[3] == $setGroup2[3]) {


        }

        return $this->extractMaximumCard($winnerSet);
    }

    /**
     * @param array $cards
     * @param int $specificNum
     * @return array
     */
    public function getSpecificCards(array $cards, int $specificNum): array
    {
        return array_filter($cards, function (Card $card) use ($specificNum) {
            return $card->getNumber() == $specificNum;
        });
    }

    /* 比較兩對 */
    public function compareTwoPair(array $cardSet, array $cardSet2)
    {

    }

    /* 比較一對 */
    public function compareOnePair(array $cardSet, array $cardSet2)
    {

    }

    public function getWeight($weight)
    {
        $result = [
            'straight_flush' => 10,
            'four_of_a_kind' => 9,
            'full_house' => 8,
            'flush' => 7,
            'straight' => 6,
            'three_of_Kind' => 5,
            'two_pair' => 4,
            'one_pair' => 3,
            'high_card' => 2,
        ];

        return $result[$weight] ?? '';
    }
}