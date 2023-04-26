<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use Symfony\Component\Config\Definition\Exception\Exception;

class CardBank extends CardHand
{
    protected $deckInHand = null;
    public function __construct(DeckOfCards $deck)
    {
        $this->deckInHand = $deck;
    }
}
