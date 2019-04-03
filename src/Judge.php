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
            return $this->getFistPlayer()->getName() . ' win';
        }

        return '';
    }

    public function getKeyCard(Player $winner, Player $loser)
    {
        $allColor = $winner->getCardSet()->getMaximumCard();

        var_dump($allColor);
    }

    public function getPlayer1Weight()
    {
        return $this->getWeight($this->fistPlayer->getCardSet()->getResult());
    }

    public function getPlayer2Weight()
    {
        return $this->getWeight($this->secondPlayer->getCardSet()->getResult());
    }

    public function getStraightFlushKey(Player $winner)
    {
        $cards = $winner->getCardSet()->getCards();

        return '';
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