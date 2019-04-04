<?php

use App\Card;
use PHPUnit\Framework\TestCase;

/**
 * Class CardTest
 */
class CardTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param string $string
     * @param string $assertColors
     * @param string $assertNumber
     */
    public function test_getNumber(string $string, string $assertColors, string $assertNumber)
    {
        $card = new Card($string);

        $this->assertEquals($card->getColor(), $assertColors);

        $this->assertEquals($card->getNumber(), $assertNumber);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            ['SA', '4', '14'],
            ['D10', '2', '10'],
            ['H2', '3', '2'],
            ['HJ', '3', '11'],
            ['DQ', '2', '12'],
            ['S6', '4', '6'],
            ['D5', '2', '5']
        ];
    }
}