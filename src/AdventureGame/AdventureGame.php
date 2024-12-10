<?php

namespace App\AdventureGame;

use App\Dice\DiceGraphic;

/**
 * @variable $totalPlayers Keeps track on how many players there are(Max 2 atm)
 * @variable $playerTurn Keeps track on whose turn it is
 * @variable $playerHands Holds all the players, including the bank.
 *
 * Handles the main gameplay flow, from start to finish.
 */
class AdventureGame
{
    public $rooms = [
        'start' => [ // IMPORTANT! key and title must have same name
            'title' => 'start',
            'description' => "You wake up in a dim cave, the air damp and still. Trails of a struggle—scuffed dirt, scattered pebbles, and a faint smear of blood—lead into the shadows. Nearby, your trusted sword lies half-buried, its blade catching the faint light from above. Ahead, daylight glimmers on the jagged walls, beckoning you forward.",
            'image_class' => 'start_room',
            'item' => 'sword',
            'action' => "",
            'forward' => "second_cave_room",
            'left' => "",
            "back" => ""
        ],
        'start_revisit' => [
            'title' => 'start_revisit',
            'description' => "You are suddenly back in the first cave room you woke up in, strange..",
            'image_class' => 'start_room',
            'item' => 'sword',
            'action' => "",
            'forward' => "second_cave_room",
            'left' => "",
            "back" => ""
        ],
        'second_cave_room' => [
            'title' => 'second_cave_room',
            'description' => "Weirdly enough you did not exit the cave, instead you ended up in a similar looking cave room who also have a bright light exit. To the left you see som kind of dark entrance, maybe the creature who dragged you here lives there? Didn't you have a sword?",
            'image_class' => 'second_cave',
            'item' => '',
            'action' => "",
            'forward' => "start_revisit",
            'left' => "third_cave_room",
            "back" => "start_revisit"
        ],
        'third_cave_room' => [
            'title' => 'third_cave_room',
            'description' => "You crawled through the dark entrance and as you emerge you come eye to eye with a horned and heavily armed creature that is blocking your path. Better remember your martial arts training if you want to leave alive...",
            'image_class' => 'third_cave',
            'item' => '',
            'action' => "attack",
            'forward' => "winner",
            'left' => "",
            "back" => "second_cave_room"
        ],
        'winner' => [
            'title' => 'winner',
            'description' => 'You emerged from the cave alive! (Reset game in footer to play again)',
            'image_class' => 'winner',
            'item' => '',
            'action' => "",
            'forward' => "",
            'left' => "",
            "back" => ""
        ],
        'some_room' => [
            'title' => 'some_room',
            'description' => 'You emerge from the cave',
            'image_class' => 'outside_cave',
            'item' => '',
            'action' => "attack",
            'forward' => "some_room",
            'left' => "some_room",
            "back" => ""
        ]
    ];
    private $dice;
    public const MIN_ROLL_WITH_WEAPON = 2;
    public const MIN_ROLL_NO_WEAPON = 6;
    public function __construct(DiceGraphic $dice, array $rooms = [])
    {
        if ($rooms) {
            $this->rooms = $rooms;
        }
        $this->dice = $dice;
    }

    public function attackEnemy($hasItemInBackPack, $roll)
    {
        $killingBlow = false;
        if ($hasItemInBackPack && $roll >= self::MIN_ROLL_WITH_WEAPON) {
            $killingBlow = true;
        } elseif ($roll >= self::MIN_ROLL_NO_WEAPON) {
            $killingBlow = true;
        }
        return $killingBlow;
    }

    public function roll()
    {
        return $this->dice->roll();
    }
    public function rollGraphic()
    {
        return $this->dice->getAsString();
    }

    public function setRooms(array $rooms)
    {
        $this->rooms = $rooms;
    }
}
