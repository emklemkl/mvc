<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\CardHand;

class CardBank extends CardHand
{
    protected $deckInHand = null;
    public function __construct(DeckOfCards $deck)
    {
        $this->deckInHand = $deck;
    }


}
