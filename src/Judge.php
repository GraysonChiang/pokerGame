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
    public function getFistPlayer(): Player
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
            return $this->getFistPlayer()->getName() . ' win card:' . $this->getKeyCard($this->getFistPlayer(), $this->getSecondPlayer());
        }

        if ($this->getPlayer2Weight() > $this->getPlayer2Weight()) {
            return $this->getSecondPlayer()->getName() . ' win card:' . $this->getKeyCard($this->getSecondPlayer(), $this->getFistPlayer());
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

    /**
     * @param Card[] $cardSet
     * @param Card[] $cardSet2
     * @return string
     */
    public function compareCardSet(array $cardSet, array $cardSet2)
    {
        foreach ([0, 1, 2, 3, 4] as $k) {
            $cardNum = $cardSet[$k]->getNumber() == 2 ? '15' : $cardSet[$k]->getNumber();
            $card2Num = $cardSet2[$k]->getNumber() == 2 ? '15' : $cardSet2[$k]->getNumber();

            if ($cardNum > $card2Num) {
                return $cardSet[$k]->getOrigin();
            }

            if ($cardSet[$k]->getColor() > $cardSet2[$k]->getColor()) {
                return $cardSet[$k]->getOrigin();
            }
        }

        return '';
    }

    public function getPlayer1Weight()
    {
        return $this->getWeight($this->fistPlayer->getCardSet()->getResult());
    }

    public function getPlayer2Weight()
    {
        return $this->getWeight($this->secondPlayer->getCardSet()->getResult());
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