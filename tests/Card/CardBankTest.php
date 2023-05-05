<?php

namespace App\Card;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;

/**
 * Test cases for class Card.
 */

class CardBankTest extends TestCase
{
    public function testInitiateCardBank()
    {
        $deck = new CardBank(new DeckOfCards());
        $this->assertInstanceOf("App\Card\CardBank", $deck);
    }
} 