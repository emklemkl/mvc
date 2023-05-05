<?php

namespace App\Card;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;


/**
 * Test cases for class Card.
 */

class CardHandTest extends TestCase
{
    /**
     * Inits a CardHand with a DeckOfCards.
     */
    public function testInitiateCardHand()
    {
        $hand = new CardHand(new DeckOfCards());
        $this->assertInstanceOf("App\Card\CardHand", $hand);
    }

    /**
     * Test if DeckOfCards is initiated properly
     */
    public function testIfDeckOfCardsInitiates()
    {
        $hand = new CardHand(new DeckOfCards());
        $deck = $hand->getDeckInHand();
        $this->assertInstanceOf("App\Card\DeckOfCards", $deck, "Should be a DeckOfCards");
    }

    
    // Test if getRandKeyFromHandDeck returns a legal array with correct 
    // amount of keys 
    // public function testReturnRandomKeysFromHandDeck()
    // {
    //     $hand = new CardHand(new DeckOfCards());
    //     $key = $hand->getRandKeyFromHandDeck();
    //     $res = count($key);
    //     $exp = 1;
    //     $this->assertEquals($exp, $res, "Should match");

    //     $hand = new CardHand(new DeckOfCards());
    //     $key = $hand->getRandKeyFromHandDeck(52);
    //     $res = count($key[0]);
    //     $exp = 52;
    //     $this->assertEquals($exp, $res, "Should match 52");
    // }

    /**
     * Test updating Current Deck with new cards/keys.
     */
    public function testUpdateDeckInHandNewValuesSameObject()
    {
        $hand = new CardHand(new DeckOfCards());
        $deck = $hand->getDeckInHandValues();
        $hand->setDeckInHand(["h1", "h2"]);
        $this->assertNotEquals($hand->getDeckInHandValues(), $deck);

        $res = $hand->getDeckInHandValues();
        $exp = ["h1", "h2"];
        $this->assertEquals($exp, $res, "should be equal");
    }

    /**
     * Test to shuffle the deck (not replacing) and see to that it 
     * returns an array.
     */
    public function testShuffleDeckInHand()
    {
        $hand = new CardHand(new DeckOfCards());
        $notShuffled = $hand->getDeckInHandValues();
        $res = $hand->shuffleHandDeck();
        $this->assertIsArray($res, "should be array");

        $shuffled = $hand->getDeckInHandValues();
        $this->assertNotEquals($shuffled, $notShuffled);
    }

    /**
     * Test if the current deck is returned as an array.
     * Is used in most of the tests,
     */
    public function testGetDeckInHandAsArray()
    {
        $hand = new CardHand(new DeckOfCards());
        $this->assertIsArray($hand->getDeckInHandValues());
    }

    /**
     * Test if the current deck is returned as an array with graphics.
     * Test first, last and middle values
     */
    public function testGetDeckInHandAsArrayWithGraphic()
    {
        $hand = new CardHand(new DeckOfCards());
        $deckGraphic = $hand->getDeckInHandValuesGraph();
        $this->assertIsArray($deckGraphic);

        $res = $deckGraphic["h1"];
        $exp = "♥️A";
        $this->assertEquals($exp, $res);
        
        $res = $deckGraphic["s8"];
        $exp = "♠️8";
        $this->assertEquals($exp, $res);
        
        $res = $deckGraphic["c13"];
        $exp = "♣️K";
        $this->assertEquals($exp, $res);

        // Test with a smaller deck
        $hand = new CardHand(new DeckOfCards(["h1","h2","c10"]));
        $deckGraphic = $hand->getDeckInHandValuesGraph();
        $res = $deckGraphic["h1"];
        $exp = "♥️A";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test to see if the Graphic arrays is sorted 
     * Preset order is H, S, D, C
     * 
     */
    public function testGetDeckInHandAsArrayWithGraphicInOrder()
    {
        $hand = new CardHand(new DeckOfCards(["d12", "c1", "h2", "h1"]));
        $res = $hand->getDeckInHandValuesGraphInOrder();
        $exp = ["♥️A", "♥️2", "♦️Q", "♣️A"];
        $iii = 0;
        foreach($res as $re) {
            $this->assertEquals($exp[$iii], $re);
            $iii++;
        }
    }

    /**
     * test drawing 1 and 15, and more than 52 total 
     * random cards from deckInHand
     * Should return an array
     */
    public function testDrawCardsFromDeck()
    {
        $hand = new CardHand(new DeckOfCards());
        $card = $hand->drawCards();
        $this->assertIsArray($card, "Should be an array");
        
        $res = count($card);
        $exp = 1;
        $this->assertEquals($exp, $res, "Should be 1 === 1");

        $card = $hand->drawCards(15);
        $exp = 15;
        $res = count($card);
        $this->assertEquals($exp, $res, "Should be 15 === 15");

        //Test draw more cards than exists left
        $this->expectException(Exception::class);
        $hand->drawCards(40);
    }
    /**
     * Show all drawn cards and test that they are removed from the
     * deck.
     */
    public function testGettingAllDrawnCards()
    {
        $hand = new CardHand(new DeckOfCards());
        //Before any is drawn
        $drawnCards = $hand->getDrawnCards();
        $this->assertEquals(count($drawnCards), 0);
        
        // Draw 15 cards
        $hand->drawCards(15);
        $drawnCards = $hand->getDrawnCards();
        $this->assertEquals(count($drawnCards), 15);
        $remainingDeckCards = $hand->getDeckInHandValues();
        $this->assertIsArray($drawnCards, "Should be an array");
        
        //First drawn should not be in remainingDeck
        $this->assertNotContains($drawnCards[0], $remainingDeckCards);
        //last drawn should not be in remainingDeck
        $this->assertNotContains($drawnCards[14], $remainingDeckCards);
    }

    /**
     * Test that printDrawnCards return an array 
     * containing the DRAWN cards and a graphic-symbol
     * All 52 cards get drawn so deckInHand should be empty.
     */
    public function testPrintingAllDrawnCards()
    {
        $hand = new CardHand(new DeckOfCards());
        $hand->drawCards(52);
        $graphic = $hand->printDrawnCards();

        $deck = $hand->getDeckInHandValues();

        $this->assertEmpty($deck, "Should be empty");


        $this->assertIsArray($graphic);

        $this->assertContains("♥️A", $graphic);
        $this->assertContains("♠️10", $graphic);
        $this->assertContains("♦️10", $graphic);
        $this->assertContains("♣️K", $graphic);
    }

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