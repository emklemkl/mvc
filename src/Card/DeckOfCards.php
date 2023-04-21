<?php

namespace App\Card;

class DeckOfCards extends CardGraphic
{
    protected $deck;

    public function __construct(array $deckVals = [])
    {
        if ($deckVals) {
            $this->deck = $deckVals;
        } else {
            $this->deck = [
                'h1','h2','h3','h4','h5','h6','h7','h8','h9','h10','h11','h12','h13',
                's1','s2','s3','s4','s5','s6','s7','s8','s9','s10','s11','s12','s13',
                'd1','d2','d3','d4','d5','d6','d7','d8','d9','d10','d11','d12','d13',
                'c1','c2','c3','c4','c5','c6','c7','c8','c9','c10','c11','c12','c13'
            ];
        }
    }

    public function getDeck()
    {
        return $this->deck;
    }
    public function setDeck($newDeck)
    {
        $this->deck = $newDeck;
    }

    public function getDeckWithGraphic()
    {
        $deck = $this->getDeck();
        $graphics = $this->getCardGraphics();
        $graphicDeck = [];
        foreach ($deck as $key) {
            if (in_array($key, $deck)) {
                $graphicDeck[$key] = $graphics[$key];
            }
        }
        return $graphicDeck;
    }

    // This does not sort the actual deck, it just returns them in order
    // based on the order in the associative array $deckGraphics inherited from CardGraphics
    public function getDeckWithGraphicsInOrder()
    {
        $deck = $this->getDeck();
        $graphics = $this->getCardGraphics();
        $graphicDeck = [];
        foreach ($graphics as $key => $value) {
            if (in_array($key, $deck)) {
                $graphicDeck[$key] = $value;
            }
        }
        return $graphicDeck;
    }

    // Counts and return the totalt amount of remaining cards in the hand deck
    public function countCardsInHandDeck(): int
    {
        return count($this->deck);
    }

    public function removeCardsFromDeck(array $removeValue)
    {
        foreach ($removeValue as $remove) {
            if(($key = array_search($remove, $this->deck)) !== false) {
                unset($this->deck[$key]);
            }
        }
    }

    public function returnRandomCards($quantity = 1): array
    {
        $randCards = [];
        if (!$this->deck) {
            throw new \Exception("No Cards left!");
        }
        if (count($this->deck) < $quantity) {
            throw new \Exception("Can't remove $quantity cards. Only ".count($this->deck)." cards left!");
        }
        if ($quantity === 1) {
            $randKeys[] = array_rand($this->deck, $quantity);
        } else {
            $randKeys = array_rand($this->deck, $quantity);
        }
        foreach ($randKeys as $keys) {
            $randCards[] = $this->deck[$keys];
        }
        return $randCards;
    }
}
