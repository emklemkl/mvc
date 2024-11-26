<?php

namespace App\Library;

/**
 * @variable $totalPlayers Keeps track on how many players there are(Max 2 atm)
 * @variable $playerTurn Keeps track on whose turn it is
 * @variable $playerHands Holds all the players, including the bank.
 *
 * Handles the main gameplay flow, from start to finish.
 */
class LibraryUtil
{
    public function __construct()
    {
    }

    /**
     *  Return all players
     */
    public static function bookExists($book)
    {
        if (empty($book)) {
            throw new \Exception("No book found on this id/isbn");
        }
    }

}
