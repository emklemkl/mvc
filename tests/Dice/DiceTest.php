<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    public function testRollDice()
    {
        $expectedLow = 1;
        $expectedHigh = 6;
        $die = new Dice();
        $die->roll();
        $this->assertGreaterThanOrEqual($expectedLow, $die->getValue());
        $this->assertLessThanOrEqual($expectedHigh, $die->getValue());
    }
}