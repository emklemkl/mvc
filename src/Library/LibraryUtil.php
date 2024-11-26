<?php

namespace App\Library;

use Exception;

/**
 * Lib util
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
            throw new Exception("No book found on this id/isbn");
        }
    }
}
