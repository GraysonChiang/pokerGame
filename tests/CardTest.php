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
            ['SA', '1', '14'],
            ['D10', '3', '10'],
            ['H2', '2', '2'],
            ['HJ', '2', '11'],
            ['DQ', '3', '12'],
            ['S6', '1', '6'],
            ['D5', '3', '5']
        ];
    }
}