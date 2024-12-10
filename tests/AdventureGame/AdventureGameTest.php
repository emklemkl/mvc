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

    public $rooms = [
        'test' => [ // key and title must have same name
            'title' => 'test', 
            'description' => "test",
            'image_class' => 'test',
            'item' => 'test',
            'action' => "test_attack",
            'forward' => "test",
            'left' => "test",
            "back" => "test"
        ],];
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
    public function testRollInjectedDie() {
        $game = new AdventureGame(new DiceGraphic);
        $roll = $game->roll();
        $this->assertIsInt($roll);
        $this->assertGreaterThanOrEqual(1, $roll);
        $this->assertLessThanOrEqual(6, $roll);
    }  
    public function testRollInjectedGraphicDie() {
        $game = new AdventureGame(new DiceGraphic);
        $game->roll();
        $roll = $game->rollGraphic();
        $this->assertIsString($roll);
    }  
    public function testSetRoom() {
        $game = new AdventureGame(new DiceGraphic);
        $game->setRooms($this->rooms);
        $this->assertEquals($game->rooms, $this->rooms);
    }  
}