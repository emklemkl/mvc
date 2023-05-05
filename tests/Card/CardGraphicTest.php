<?php

namespace App\Card;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use ReflectionClass;

/**
 * Test cases for class Card.
 */

class CardGraphicTest extends TestCase
{
    public function testCreateObject()
    {
        $graphic = new CardGraphic();
        $this->assertInstanceOf("App\Card\CardGraphic", $graphic);
    }

    public function testGetGraphicsRepresentationForDecks()
    {
        $graphic = new CardGraphic();
        $res = $graphic->getCardGraphics();
        $this->assertIsArray($res);
    }

} 