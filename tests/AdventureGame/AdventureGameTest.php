<?php

namespace App\AdventureGame;

use App\Dice\DiceGraphic;
use App\AdventureGame\AdventureGame;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class AdventureGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateAdventureGame()
    {
        $game = new AdventureGame(new DiceGraphic);
        $this->assertInstanceOf("\App\AdventureGame\AdventureGame", $game);
    }
    public function testKillEnemyWithWeaponSuccess() {
        $game = new AdventureGame(new DiceGraphic);
        $game->attackEnemy(true, 4);
        $this->assertTrue($game->attackEnemy(true, 4));
    }  
    public function testKillEnemyWithWeaponFail() {
        $game = new AdventureGame(new DiceGraphic);
        $this->assertFalse($game->attackEnemy(true, 1));
    }  
    public function testKillEnemyNoWeaponSuccess() {
        $game = new AdventureGame(new DiceGraphic);
        $this->assertTrue($game->attackEnemy(false, 6));
    }  
    public function testKillEnemyNoWeaponFail() {
        $game = new AdventureGame(new DiceGraphic);
        $this->assertFalse($game->attackEnemy(false, 5));
    }  
}