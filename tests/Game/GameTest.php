<?php

namespace App\Game;
use Symfony\Component\Config\Definition\Exception\Exception;
use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\CardBank;
use App\Card\CardHand;

/**
 * Test cases for class Card.
 */

class GameTest extends TestCase
{
    protected $game;
    protected $deck;
    protected function setUp() : void
    {
        $this->deck = new DeckOfCards();
        $this->game = new Game(new CardHand($this->deck), new CardBank($this->deck));
    }

    protected function tearDown() : void
    {
        $this->game = null;
        $this->deck = null;
    }

    /**
     * Create Game-Object with composition relations(cardhand/cardbank/deckofcards) 
     */
    public function testCreateGameObject()
    {
        $this->assertInstanceOf("App\Game\Game", $this->game);
        $this->assertIsObject($this->game);
    }
    
    /**
     * Tests getting all the players and bank and check their instance type
     */
    public function testGetPlayerAndBankHands()
    {
        $hands = $this->game->getHands();
        $this->assertIsArray($hands);
        $this->assertInstanceOf("App\Card\CardHand", $hands[0]);
        $this->assertInstanceOf("App\Card\CardBank", end($hands));
    }

    /**
     * Test if gameplayCycle return that Bank is done with its round or not
     * Also tests that its the correct players turn. CardBank i always last
     */
    public function testGamePlayCycleIsItsBanksTurn()
    {
        $whosTurn = $this->game->whosTurnIsIt();
        $exp = 0;
        $this->assertEquals($exp, $whosTurn);
        
        $res = $this->game->gameplayCycle();
        $this->assertFalse($res, "should be false");
        
        $this->game->nextPlayerTurn();
        $whosTurn = $this->game->whosTurnIsIt();
        $exp = 1;
        $this->assertEquals($exp, $whosTurn);
        $res = $this->game->gameplayCycle();
        $this->assertTrue($res, "should be true");
    }

    /**
     * Test getting current player drawn cards when none is drawn, when some is drawn then all
     */
    public function testGetArrayOfAllDrawnCards()
    {
        $res = $this->game->getDrawnCardsGame();
        $exp = [];
        $this->assertEquals($exp, $res);
        $this->assertNotContains("♥️Q", $res);
        
        // 4 drawn
        $this->game->getHands()[0]->drawCards(4);
        $res = $this->game->getDrawnCardsGame();
        $exp = 4;
        $this->assertEquals($exp, count($res));
        $this->assertIsArray($res);
        
        // all drawn
        $this->game->getHands()[0]->drawCards(48);
        $res = $this->game->getDrawnCardsGame();
        $exp = 52;
        $this->assertEquals($exp, count($res));
        $this->assertContains("♥️Q", $res);
    }

    /**
     * Tests getting the name of a player. Conditions are reversed when its banks turn
     */
    public function testGetCertainPlayerName()
    {
        // first player
        $res = $this->game->currentPlayerName();
        $exp = "Player";
        $this->assertEquals($exp, $res);
        
        $res = $this->game->currentPlayerName("other");
        $exp = "Bank";
        $this->assertEquals($exp, $res);

        $res = $this->game->currentPlayerName("ILLEGAL ENTRY");
        $exp = "Player";
        $this->assertEquals($exp, $res);
        
        // Next player (Bank) increment playerTurn by 1. Reversed conditions
        $this->game->nextPlayerTurn();
        $res = $this->game->currentPlayerName();
        $exp = "Bank";
        $this->assertEquals($exp, $res);
        
        $res = $this->game->currentPlayerName("other");
        $exp = "Player";
        $this->assertEquals($exp, $res);

        $res = $this->game->currentPlayerName("ILLEGAL ENTRY");
        $exp = "Bank";
        $this->assertEquals($exp, $res);
    }

    /**
     * tests that both players drawn cards are available [0] is player 
     * [1] is bank
     */
    public function testGettingAllDrawnCardsInGame()
    {
        // first player
        $res = $this->game->getAllDrawnCards();
        
        $this->assertEmpty($res[0]);
        
        $this->game->getHands()[0]->drawCards(4);
        $res = $this->game->getAllDrawnCards();
        $this->assertNotEmpty($res[0]);
        $exp = 4;
        $this->assertEquals($exp, count($res[0]));
        
        // Bank
        $this->game->nextPlayerTurn();
        $res = $this->game->getAllDrawnCards();
        $this->assertEmpty($res[1]);
        
        $this->game->getHands()[1]->drawCards(6);
        $res = $this->game->getAllDrawnCards();
        $this->assertNotEmpty($res[1]);
        $exp = 6;
        $this->assertEquals($exp, count($res[1]));
        
        $exp = 10;
        $this->assertEquals($exp, count($res[0]) + count($res[1]));
    }

    public function testGetPlayerWinner()
    {
        // Player Draw first card
        $this->game->gameplayCycle();
        $res = $this->game->getWinner();
        $exp = "Player";
        $this->assertEquals($exp, $res);
    }

    public function testBankWinner()
    {
        // Player Draw to many cards and land over 21 so bank win
        $this->game->nextPlayerTurn();
        for ($i=0; $i < 12; $i++) { 
            $this->game->gameplayCycle();
        }
        $res = $this->game->getWinner();
        $exp = "Bank";
        $this->assertEquals($exp, $res, "should be bank");
    }
} 