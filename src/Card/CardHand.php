<?php
namespace App\Card;

use App\Card\DeckOfCards;
use Exception;

use function PHPUnit\Framework\throwException;

// use App\Card\Card;

class CardHand
{
    private $deckInHand = null;
    function __construct(DeckOfCards $deck) {
        $this->deckInHand = $deck;
    }

    function getRandKeyFromHandDeck($amount = 1) {

        if ($amount > 52 || $amount < 0) {
            throw new \Exception("Min 0, Max 52");
        }
        $key[] = array_rand($this->getDeckInHand(), $amount);
        $keys = [];
        foreach ($key as $i) {
            $keys[] = $i;
        }
        return $keys;
    }

    function getDeckInHand() {
        
        return $this->deckInHand->getDeck();
    }
}

// Deck finns i hand (composition)
// CardGraphic borde också finnas som ett object (composition?) för att prettyprinta cardsen i handen.