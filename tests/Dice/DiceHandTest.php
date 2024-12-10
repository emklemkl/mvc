<?php


namespace App\DiceHand;
namespace App\Dice;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testDiceHandInstance()
    {
        $dieHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $dieHand);
    }

    public function testDiceHandAddDice()
    {
        $dieHand = new DiceHand();
        $dieHand->add(new Dice);
        $this->expectNotToPerformAssertions();
    }
    
    public function testDiceHandRollDice()
    {
        $dieHand = new DiceHand();
        $dieHand->add(new Dice);
        $dieHand->roll();
        $this->assertIsArray($dieHand->getValues());
        $this->assertGreaterThanOrEqual(1, $dieHand->getValues()[0]);
        $this->assertLessThanOrEqual(6, $dieHand->getValues()[0]);
    }

    public function testDiceHandGetNumberDices()
    {
        $dieHand = new DiceHand();
        $dieHand->add(new Dice);
        $dieHand->add(new Dice);
        $dieHand->roll();
        $this->assertGreaterThanOrEqual(2, $dieHand->getNumberDices());
        $this->assertLessThanOrEqual(12, $dieHand->getNumberDices());
    }
    public function testDiceHandGetAsStringOk()
    {
        $dieHand = new DiceHand();
        $dieHand->add(new Dice);
        $dieHand->roll();
        $this->assertIsString($dieHand->getString()[0]);
    }
}