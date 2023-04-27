<?php

namespace App\Game;

use App\Card\CardBank;
use App\Card\CardHand;
// use App\Card\DeckOfCards;

class Game
{
    protected $playerHands;
    protected $playerTurn = 0;
    protected $totalPlayers = 0;

    public function __construct(CardHand $hand, CardBank $bank, int $totalPlayers = 2)
    {
         // Last player will always be the bank
        $this->$totalPlayers = $totalPlayers;
        for ($i=0; $i < $totalPlayers; $i++) { 
            $this->playerHands[] = $i === $totalPlayers - 1 ? $bank : $hand;
        } 
    }

    public function getHands() : array {
        return $this->playerHands;
    }

    /**
     * Is current player above 21? 
     * if so game is over and other player won
     */


    public function gameplayCycle() {
        $this->playerHands[$this->whosTurnIsIt()]->drawCards();
    }
    
    function getDrawnCardsGame() {
        return $this->playerHands[$this->whosTurnIsIt()]->printAllDrawnCards();
    }

    public function whosTurnIsIt() {
        return $this->playerTurn;
    }

    /**
     * Returns true if the bank is the current player (bank plays last)
     */
    public function isBanksTurn() {
        return $this->totalPlayers === $this->playerTurn ? false : true;
    }

    public function nextPlayerTurn() {
        $this->playerTurn += 1;
    }

    public function isOver21() {
        return $this->playerHands[$this->whosTurnIsIt()]->isOver21();
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