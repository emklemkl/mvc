<?php

namespace App\Card;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;


/**
 * Test cases for class Card.
 */

class CardHand2Test extends TestCase
{
    /**
     * Test that a string rep containing the current deckInHand is returned
     */
    public function testGetDeckAsStringRep()
    {
        $hand = new CardHand(new DeckOfCards());
        $res = $hand->getDeckAsString();
        $exp = "c13";
        $this->assertIsString($res);
        $this->assertStringContainsString($exp, $res);
    }

    /**
     * Tests drawing the total sum of a full deck (52) 
     * and an empty deck
     */
    public function testGetSumOfAllCardsInCurrentDeckState()
    {
        $hand = new CardHand(new DeckOfCards());
        $deckSum = $hand->getDeckSum();
        $expL = 364;
        $expH = 416;
        $this->assertEquals($expL, $deckSum[0]);
        $this->assertEquals($expH, $deckSum[1]);
        
        $hand->drawCards(52);
        $deckSum = $hand->getDeckSum();
        $this->assertEquals(0, $deckSum[0]);
        $this->assertEquals(0, $deckSum[1]);
    }
    
        /**
     * Tests drawing the total sum of a full drawndeck (52) 
     * and an empty deck
     */
    public function testGetSumOfAllDrawnCards()
    {
        $hand = new CardHand(new DeckOfCards());
        $expL = 0;
        $expH = 0;
        $drawnCardsSum = $hand->getDrawnSum();
        $this->assertEquals($expL, $drawnCardsSum[0]);
        $this->assertEquals($expH, $drawnCardsSum[1]);
        
        $expL = 364;
        $expH = 416;
        $hand->drawCards(52);
        $drawnCardsSum = $hand->getDrawnSum();
        $this->assertEquals($expL, $drawnCardsSum[0]);
        $this->assertEquals($expH, $drawnCardsSum[1]);
    }

    /**
     * Test isOver21
     */
    public function testCardHandOver21OrNot()
    {
        $hand = new CardHand(new DeckOfCards());
        //Test with zero draws
        $this->assertFalse($hand->isOver21());
        
        //Test after one draw
        $hand->drawCards(1);
        $this->assertFalse($hand->isOver21(), "should be false (max 14 p)");
        
        //Test after many draws (will be over 21)
        $hand->drawCards(12);
        $this->assertTrue($hand->isOver21(), "should be true (min 24 p)");
        
        //Test over 21 when all cards are drawn from deck
        $hand->drawCards(39);
        $this->assertTrue($hand->isOver21(), "should be true (max value)");
    }
} 