<?php

namespace App\Card;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
class DeckOfCards extends CardGraphic
{
    protected $deck;

    public function __construct(array $deckVals = [])
    {
        $this->deck = [
            'h1','h2','h3','h4','h5','h6','h7','h8','h9','h10','h11','h12','h13',
            's1','s2','s3','s4','s5','s6','s7','s8','s9','s10','s11','s12','s13',
            'd1','d2','d3','d4','d5','d6','d7','d8','d9','d10','d11','d12','d13',
            'c1','c2','c3','c4','c5','c6','c7','c8','c9','c10','c11','c12','c13'
        ];
        if ($deckVals) {
            $this->deck = $deckVals;
        }
    }

    /**
     * Return the deck in its current state
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Update the state of deck by replacing the deck with a new modified one
     */
    public function setDeck(array $newDeck)
    {
        $this->deck = $newDeck;
    }

    /**
     * Returns an associative array with
     * all the cards in deck with their matched graphic.
     */
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

    /**
     * Almost the same as getDeckWithGraphic()
     * This does not sort the actual deck, it just returns them in order
     * based on the order in the associative array $deckGraphics inherited from CardGraphics
     */

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

    /**
     * Counts and return the totalt amount of remaining cards in the hand deck
     */
    public function countCardsInDeck(): int
    {
        return count($this->deck);
    }

    /**
     * Remove cards/values from deck if exists
     */
    public function removeCardsFromDeck(array $removeValue)
    {
        foreach ($removeValue as $remove) {
            $key = array_search($remove, $this->deck);
            if($key !== false) {
                array_splice($this->deck, $key, 1);
            }
        }
    }

    /**
     * Gets and returns a number of random card/values.
     * Default return 1 card
     */
    public function returnRandomCards(int $quantity = 1): array
    {
        $randCards = [];
        if (!$this->deck) {
            throw new Exception("No Cards left!");
        }
        if (count($this->deck) < $quantity) {
            throw new Exception("Can't remove $quantity cards. Only ".count($this->deck)." cards left!");
        }
        // Must return an array so statement below is just error handling
        $quantity === 1 ? $randKeys[] = array_rand($this->deck, $quantity) : $randKeys = array_rand($this->deck, $quantity);

        foreach ($randKeys as $keys) {
            $randCards[] = $this->deck[$keys];
        }
        return $randCards;
    }
}
