<?php

namespace App;


class PokerMain
{
    protected $firstPlayer;

    protected $secondPlayer;

    public function battle()
    {
        $fistPlayer = $this->getFirstPlayer();

        $secondPlayer = $this->getSecondPlayer();

        $judge = new Judge($fistPlayer, $secondPlayer);

        return '';
    }

    public function setFirstPlayer($name, $cards)
    {
        $this->firstPlayer = new Player($name);

        $this->firstPlayer->setCards($cards);
    }

    public function setSecondPlayer($name, $cards)
    {
        $this->secondPlayer = new Player($name);

        $this->secondPlayer->setCards($cards);
    }

    public function getFirstPlayer(): Player
    {
        return $this->firstPlayer;
    }

    public function getSecondPlayer(): Player
    {
        return $this->secondPlayer;
    }

}