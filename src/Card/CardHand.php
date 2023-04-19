<?php
namespace App\Card;

use App\Card\DeckOfCards;
// use App\Card\Card;

class CardHand
{
    private $deckInHand = null;
    function __construct(DeckOfCards $deck) {
        $this->deckInHand = $deck;
    }

    function getRandKeyFromHandDeck() {
        $arr = $this->getDeckInHand();
        $key = array_rand($this->getDeckInHand());
        // return $key;
        return $this->deckInHand;
    }

    function getDeckInHand() {
        
        return $this->deckInHand->getDeck();
    }
}

// Deck finns i hand (composition)
// CardGraphic borde också finnas som ett object (composition?) för att prettyprinta cardsen i handen.