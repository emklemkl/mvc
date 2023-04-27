<?php

namespace App\Card;

use App\Card\DeckOfCards;
use Symfony\Component\Config\Definition\Exception\Exception;

// use App\Card\Card;

class CardHand
{
    protected $deckInHand = null;
    protected $drawnCards = [];
    public function __construct(DeckOfCards $deck)
    {
        $this->deckInHand = $deck;
    }

    /**
     * Gets a random key from the $deck and returns it
     */
    public function getRandKeyFromHandDeck($amount = 1)
    {
        if ($amount > 52 || $amount < 0) {
            throw new Exception("Min 0, Max 52");
        }
        $key[] = array_rand($this->getDeckInHandValues(), $amount);
        $keys = [];
        foreach ($key as $i) {
            $keys[] = $i;
        }
        return $keys;
    }

    /**
     * Get deck object containing all the cards the player holds
     */
    public function getDeckInHand()
    {
        return $this->deckInHand;
    }

    /**
     * Update/replace deck in hand
     */

    public function setDeckInHand($deck)
    {
        $this->deckInHand->setDeck($deck);
    }

    /**
     * Shuffle
     */
    public function shuffleHandDeck()
    {
        $deck = $this->deckInHand;
        $shuffleThis = $deck->getDeck();
        shuffle($shuffleThis);
        $deck->setDeck($shuffleThis);
        return $shuffleThis;
    }

    /**
     * Get/return deck Array containing all the cards/values the player holds
     */
    public function getDeckInHandValues()
    {
        return $this->deckInHand->getDeck();
    }

    /**
     * Gets and returns all the cards in the deck with Graphics
     */
    public function getDeckInHandValuesGraph()
    {
        return  $this->deckInHand->getDeckWithGraphic();
    }

    /**
     * Gets and returns all the cards in the deck with Graphics
     * This is not a sorted deck, it just prints them in order
     * based on the order in the associative array $deckGraphics from CardGraphics
     */
    public function getDeckInHandValuesGraphInOrder() : array
    {
        return  $this->deckInHand->getDeckWithGraphicsInOrder();
    }

    /**
     * Calls on functions to  Draw and remove  X random cards. Defualt argument is 1
     * Also saves the drawn cards to $drawnCards[]
     */
    public function drawCards($quantity = 1) : array
    {
        $cards = $this->deckInHand->returnRandomCards($quantity);
        foreach ($cards as $card) {
            $this->drawnCards[] = $card;
        }
        $this->deckInHand->removeCardsFromDeck($cards);
        return $cards;
    }

    /**
     * Returns the CardHand instance's all drawn cards as an array
     */
    public function getDrawnCards() : array
    {
        return $this->drawnCards;
    }

    public function printDrawnCards() {
        $graphicDeck = [];
        $graphics = $this->deckInHand->getCardGraphics();
        foreach ($this->drawnCards as $key) {
                $graphicDeck[$key] = $graphics[$key];
        }
        return $graphicDeck;
    }

    /**
     * Returns a string with comma separeted values representing the current deck state
     */
    public function getDeckAsString() : string
    {
        $cardsAsString = "";
        $deck = $this->getDeckInHandValues();
        foreach ($deck as $card)
            {  
            $cardsAsString .= "$card,";
        }
        $cardsAsString = rtrim($cardsAsString,",");
        return $cardsAsString;
    }

    /**
     * Returns an array with the deck sum. 
     * The first element is with ace of X == 1
     * The second element is with ace of X == 14
     */
    public function getDeckSum()  :array {
        $sumLow = 0;
        $sumHigh = 0;
        foreach ($this->getDeckInHandValues() as $val){
            $intValue = (int)substr($val, 1);
            $sumLow += $intValue;
            $sumHigh += $intValue === 1 ? 14 : $intValue;
        }
        return [$sumLow, $sumHigh];
    }

    public function getDrawnSum()  :array {
        $sumLow = 0;
        $sumHigh = 0;
        foreach ($this->getDrawnCards() as $val){
            $intValue = (int)substr($val, 1);
            $sumLow += $intValue;
            $sumHigh += $intValue === 1 ? 14 : $intValue;
        }
        return [$sumLow, $sumHigh];
    }

    /**
     * Checks if the current deck value is above 21.
     * returns True if above else false
     */
    public function isOver21() {
        $isOver21 = false;
        $deckValues = $this->getDrawnSum();
        if ($deckValues[0] > 21 && $deckValues[1] > 21) {
            $isOver21 = true;
        }
        return $isOver21;
    }
} 
