<?php

namespace App\Card;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */

class DeckOfCardsTest extends TestCase
{
    public function testInitiateDeckOfCardsWithAndNoArg()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("App\Card\DeckOfCards", $deck);
        $deck = new DeckOfCards(['h1']);
        $this->assertInstanceOf("App\Card\DeckOfCards", $deck);
    }

    /**
     * Checks if DeckOfCards returns an array when 
     * initiated with and witout argument
     */
    public function testGetDeckReturnArray()
    {
        $deck = new DeckOfCards();
        $res = $deck->getDeck();
        $this->assertIsArray($res);

        $deck = new DeckOfCards(['h1']);
        $this->assertIsArray($res);
        $res = $deck->getDeck();
    }

    /**
     * Test if the deck gets updated and that the new deck value array 
     * has the correct value
     */
    public function testReplaceDeckWithNewModifiedDeck() 
    {
        $deck = new DeckOfCards();
        $firstDeck = $deck->getDeck();
        $deck->setDeck(["h1"]);
        $res = $deck->getDeck();
        $this->assertNotEquals($firstDeck, $res);

        $exp = ["h1"];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test so that getDeckWithGraphic() actually returns an 
     * array with symbols/graphic that matches the current deck.
     */
    public function testReturnDeckWithGraphicSymbols() 
    {
        $deck = new DeckOfCards();
        $res = $deck->getDeckWithGraphic();
        $exp = "♥️A";
        $this->assertIsArray($res);
        $this->assertContains($exp, $res, "Should contain $exp");
        
        $exp = ["♥️2","♣️3"];
        $deck->setDeck(["h2","c3"]);
        $res = $deck->getDeckWithGraphic();
        $this->assertEquals($exp[1], $res["c3"], "Should be equal");
    }

    /**
     * Test that the deck is printed with graphic in order 
     * The predetermined order is Heart, Spade, Diamond, Clubs
     */
    public function testReturnDeckWithGraphicSymbolsInOrder() 
    {
        // Unsorted deck of 4 cards
        $deck = new DeckOfCards(["s1", "h2", "c4", "c3"]);
        $res = array_keys($deck->getDeckWithGraphicsInOrder());

        // Presorted deck of the same cards in $deck
        $preSortedDeck = new DeckOfCards(["h2", "s1","c3", "c4"]);
        $exp = array_keys($preSortedDeck->getDeckWithGraphic());
        $this->assertEquals($exp, $res);
    }

    /**
     * Test so that the total remaining cards are being counted properly.
     */
    public function testCurrentDeckIsBeingCounted() 
    {
        $deck = new DeckOfCards();
        $res = $deck->countCardsInDeck();
        $exp = 52;
        $this->assertEquals($exp, $res, "should be equal 52)");
        
        $deck->setDeck(["h1", "c3"]);
        $res = $deck->countCardsInDeck();
        $exp = 2;
        $this->assertEquals($exp, $res, "should be equal (2)");
        
        $deck->removeCardsFromDeck(["h1"]);
        $res = $deck->countCardsInDeck();
        $exp = 1;
        $this->assertEquals($exp, $res, "should be equal (1)");
    }

    /**
     * Test so that the total remaining cards are being counted properly.
     */
    public function testRemovingCardsFromDeck() 
    {
        // Remove 1 card
        $deck = new DeckOfCards();
        $deck->removeCardsFromDeck(["h1"]);
        $res = $deck->getDeck();
        $exp = "h1";
        $this->assertNotContains($exp, $res, "should not contain 'h1'");
        
        // Remove 2 cards
        $deck = new DeckOfCards();
        $deck->removeCardsFromDeck(["h1", "c1", "c3"]);
        $res = $deck->getDeck();
        $exp = ["h1", "c1", "c3"];
        for ($i=0; $i < count($exp); $i++) { 
            $this->assertNotContains($exp[$i], $res);
        }
    }

    
    /**
     * Draw more random cards than is left in deck, test exception
     */
    public function testDeckReturnMoreRandCardsThanInDeck()
    {
        $deck = new DeckOfCards(["h1"]);
        $this->expectException(Exception::class);
        $deck->returnRandomCards(2);
    }

    /**
     * Draw random from empty deck, test exception
     */
    public function testReturnRandCardsFromEmptyDeck()
    {
        $deck = new DeckOfCards(["h1"]);
        $deck->removeCardsFromDeck(["h1"]);
        $this->expectException(Exception::class);
        $deck->returnRandomCards(1);
    }

    /**
     * Return 1 and more cards and test that they are returned as an array
     */
    public function testReturnRandomCardsArray() {
        $deck = new DeckOfCards();
        $res = $deck->returnRandomCards(1);
        $this->assertIsArray($res);

        $deck = new DeckOfCards();
        $res = $deck->returnRandomCards(5);
        $this->assertIsArray($res);
    }
} 