<?php

namespace App\Game;

use App\Card\CardBank;
use App\Card\CardHand;

// use App\Card\DeckOfCards;

/**
 * @variable $totalPlayers Keeps track on how many players there are(Max 2 atm)
 * @variable $playerTurn Keeps track on whose turn it is
 * @variable $playerHands Holds all the players, including the bank.
 *
 * Handles the main gameplay flow, from start to finish.
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

    /**
     *  Return all players
     */
    public function getHands(): array
    {
        return $this->playerHands;
    }

    /**
     * Main gameplay cycle.
     * Checks whose turn it is and draws a card for that player
     * The Banks turn is automated (bank is last player).
     * If banks turn, the last while loop is run until conditions is met.
     * Then returns a bool if the bank is done.
     * Is current player above 21? if so game is over and other player won
     */
    public function gameplayCycle(): bool
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

    /**
     * Return the current players drawn cards
     */
    public function getDrawnCardsGame(): array
    {
        return $this->playerHands[$this->whosTurnIsIt()]->printDrawnCards();
    }

    /**
     * Returns an int, telling whoe turn it is. Bank i always last
     */
    public function whosTurnIsIt(): int
    {
        return $this->playerTurn;
    }

    /**
     * Return player or bank name
     */
    public function currentPlayerName($other = ""): string
    {
        if ($other === "other") {
            return $this->playerTurn !== 0 ? "Player" : "Bank";
        }
        return $this->playerTurn === 0 ? "Player" : "Bank";
    }

    /**
     * Returns true if the bank is the current player (bank plays last)
     */
    public function isBanksTurn(): bool
    {
        return $this->totalPlayers === $this->playerTurn ? false : true;
    }

    /**
     * Increments playerTurn to allow the next player 2 play
     */
    public function nextPlayerTurn()
    {
        $this->playerTurn += 1;
    }

    /**
     * Check if current player exceeds 21
     */
    public function isOver21(): bool
    {
        return $this->playerHands[$this->whosTurnIsIt()]->isOver21();
    }

    /**
     * Returns an array with ALL drawn cards combined
     */
    public function getAllDrawnCards(): array
    {
        $allCards = [];
        foreach ($this->playerHands as $ph) {
            $allCards[] = $ph->printDrawnCards();
        }
        return $allCards;
    }

    /**
     * Returns the winner [0] is player and [1] is bank
     */
    public function getWinner(): string
    {
        $playerScores = [];
        for ($i=0; $i < 2 ; $i++) {
            $playerScores[] =  $this->getMaxScores($this->playerHands[$i]);
        }
        if ($playerScores[1] === 21) {
            return "Bank";
        }
        if (!$playerScores[0]) {
            return "Bank";
        } elseif (!$playerScores[1]) {
            return "Player";
        }
        return $playerScores[0] <= $playerScores[1] ? "Bank" : "Player";
    }

    /**
     * Return the highest legal score for a player
     */
    public function getMaxScores($player): mixed
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
        }
        if (!$playerScores) {
            $playerScores[] = 0;
        }
        return max($playerScores);
    }
}
