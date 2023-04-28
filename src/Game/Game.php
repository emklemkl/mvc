<?php

namespace App\Game;

use App\Card\CardBank;
use App\Card\CardHand;

// use App\Card\DeckOfCards;

/**
 * @variable array<object> $playerHands
 */
class Game
{
    protected array $playerHands = [];
    protected int $playerTurn = 0;
    protected int $totalPlayers = 0;

    public function __construct(CardHand $hand, CardBank $bank, int $totalPlayers = 2)
    {
        // Last player will always be the bank
        $this->$totalPlayers = $totalPlayers;
        for ($i=0; $i < $totalPlayers; $i++) {
            $this->playerHands[] = $i === $totalPlayers - 1 ? $bank : $hand;
        }
    }

    public function getHands(): array
    {
        return $this->playerHands;
    }

    /**
     * Is current player above 21?
     * if so game is over and other player won
     */
    public function gameplayCycle() : bool
    {
        $bankDone = false;
        $this->playerHands[$this->whosTurnIsIt()]->drawCards();
        if ($this->isBanksTurn()) {
            while (!$bankDone) {
                $scores = $this->playerHands[$this->whosTurnIsIt()]->getDrawnSum();
                $sc0 = $scores[0] >= 17 && $scores[0] <= 21;
                $sc1 = $scores[1] >= 17 && $scores[1] <= 21;
                if ($sc0 || $sc1 || $this->isOver21()) {
                    $bankDone  = true;
                    continue;
                }
                $this->playerHands[$this->whosTurnIsIt()]->drawCards();
            }
        }
        return $bankDone;
    }

    public function getDrawnCardsGame()
    {
        return $this->playerHands[$this->whosTurnIsIt()]->printDrawnCards();
    }

    public function whosTurnIsIt()
    {
        return $this->playerTurn;
    }

    public function currentPlayerName($other = " ") : string
    {
        if ($other === "other") {
            return $this->playerTurn !== 0 ? "Player" : "Bank";
        }
        return $this->playerTurn === 0 ? "Player" : "Bank";
    }

    /**
     * Returns true if the bank is the current player (bank plays last)
     */
    public function isBanksTurn() : bool
    {
        return $this->totalPlayers === $this->playerTurn ? false : true;
    }

    public function nextPlayerTurn()
    {
        $this->playerTurn += 1;
    }

    public function isOver21() : bool
    {
        return $this->playerHands[$this->whosTurnIsIt()]->isOver21();
    }

    public function getAllDrawnCards() : array
    {
        $allCards = [];
        foreach ($this->playerHands as $ph) {
            $allCards[] = $ph->printDrawnCards();
        }
        return $allCards;
    }

    /**
     * Returns the winner
     */
    public function getWinner() : string
    {
        $playerScores = [];
        for ($i=0; $i < 2 ; $i++) {
            $playerScores[] =  $this->getMaxScores($this->playerHands[$i]);
        }
        if (!$playerScores[0]) {
            return "Bank";
        } elseif (!$playerScores[1]) {
            return "Player";
        }
        return $playerScores[0] <= $playerScores[1] ? "Bank" : "Player";
    }

    public function getMaxScores($player) : array
    {
        $playerScores = [];
        $playerLH = $player->getDrawnSum();
        if ($playerLH[0] === $playerLH[1] && $playerLH[0] <= 21) {
            return $playerLH[0];
        }
        foreach ($playerLH as $score) {
            if ($score <= 21) {
                $playerScores[] = $score;
            }
            return $playerScores;
        }
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
