<?php

namespace App\Game;

use App\Card\CardBank;
use App\Card\CardHand;
// use App\Card\DeckOfCards;

class Game
{
    protected $playerHands;

    public function __construct(CardHand $hand, CardBank $bank, int $totalPlayers = 2)
    {
         // Last player will always be the bank
        for ($i=0; $i < $totalPlayers; $i++) { 
            $this->playerHands[] = $i === $totalPlayers - 1 ? $bank : $hand;
        } 
    }

    public function getHands() : array {
        return $this->playerHands;
    }

    /**
     * Is current player above 21? 
     * if so game is sover and other player won
     */


    public function gameplayCycle() {
        $this->playerHands;
    }

    public function whosTurnIsIt() {
        
    }
}

        // Handle gameplay cycle
        /**
         * Gameplay cycle
         * -> if player draw cards add it to sums
         * -> and check if isOver21() returns false/true
         * -> If true -> end game and current player lose
         * -> If false -> let player draw another card or settle 
         * 
         * -> Game need 2 keep track of whos turn it is
         */