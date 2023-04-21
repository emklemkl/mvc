<?php

namespace App\Card;

use App\Card\DeckOfCards;

// use App\Card\Card;

class CardHand
{
    protected $deckInHand = null;
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
            throw new \Exception("Min 0, Max 52");
        }
        $key[] = array_rand($this->getDeckInHandValues(), $amount);
        $keys = [];
        foreach ($key as $i) {
            $keys[] = $i;
        }
        return $keys;
    }

    // Get deck object containing all the cards the player holds
    public function getDeckInHand()
    {
        return $this->deckInHand;
    }

    // Update/replace deck in hand
    public function setDeckInHand($deck)
    {
        $this->deckInHand->setDeck($deck);
    }

    // Shuffle
    public function shuffleHandDeck()
    {
        $deck = $this->deckInHand;
        $shuffleThis = $deck->getDeck();
        shuffle($shuffleThis);
        $deck->setDeck($shuffleThis);
        return $shuffleThis;
    }

     // Get/return deck Array containing all the cards/values the player holds
    public function getDeckInHandValues()
    {
        return $this->deckInHand->getDeck();
    }

    // Gets and returns all the cards in the deck with Graphics
    public function getDeckInHandValuesGraph()
    {
        return  $this->deckInHand->getDeckWithGraphic();
    }

    // Gets and returns all the cards in the deck with Graphics
    // This is not a sorted deck, it just prints them in order
    // based on the order in the associative array $deckGraphics from CardGraphics
    public function getDeckInHandValuesGraphInOrder()
    {
        return  $this->deckInHand->getDeckWithGraphicsInOrder();
    }

    //Calls on functions to  Draw and remove  X random cards. Defualt argument is 1
    public function drawCards($quantity = 1)
    {
        $cards = $this->deckInHand->returnRandomCards($quantity);
        $this->deckInHand->removeCardsFromDeck($cards);

        return $cards;
    }
}
