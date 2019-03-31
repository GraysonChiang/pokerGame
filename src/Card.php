<?php

namespace App;

class Card
{

    /**
     * @var string
     */
    private $color;

    /**
     * @var int
     */
    private $number;

    /**
     * Card constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $string = strtoupper($string);
        $this->color = $this->parserColor($string);
        $this->number = $this->parserNumber($string);
    }

    private function parserNumber(string $string)
    {
        $map = [
            'A' => '14',
            'K' => '13',
            'Q' => '12',
            'J' => '11',
        ];

        $text = strtoupper(trim($string));

        return $map[$text[1]] ?? intval(substr($text, 1));
    }

    private function parserColor(string $string)
    {
        $colors = [
            'S' => '1',
            'H' => '2',
            'D' => '3',
            'C' => '4',
        ];

        return $colors[$string[0]] ?? '';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

}