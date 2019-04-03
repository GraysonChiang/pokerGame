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
     * @var string
     */
    private $origin;

    /**
     * Card constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $string = strtoupper($string);
        $this->origin = $string;
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
            'S' => '4',
            'H' => '3',
            'D' => '2',
            'C' => '1',
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

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }
}