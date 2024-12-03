<?php

namespace App\AdventureGame;


// use App\Card\DeckOfCards;

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
        'start' => [
            'title' => 'cave',
            'description' => "You wake up in a dim cave, the air damp and still. Trails of a struggle—scuffed dirt, scattered pebbles, and a faint smear of blood—lead into the shadows. Nearby, your trusted sword lies half-buried, its blade catching the faint light from above. Ahead, daylight glimmers on the jagged walls, beckoning you forward.",
            'image_class' => 'start_room',
            'item' => 'sword',
            'action' => "",
            'forward' => "second_cave_room",
            'left' => "",
            "back" => ""
        ],
        'start_revisit' => [
            'title' => 'cave',
            'description' => "You are suddenly back to the first cave room you woke up in, strange..",
            'image_class' => 'start_room',
            'item' => 'sword',
            'action' => "",
            'forward' => "second_cave_room",
            'left' => "",
            "back" => ""
        ],
        'second_cave_room' => [
            'title' => 'cave',
            'description' => "Weirdly enough you did not exit the cave, instead you ended up in a similar looking cave who also have a bright light exit. To the left you see som kind of dark cave, maybe the creature who dragged you here lives there? Didn't you have a sword?",
            'image_class' => 'second_cave',
            'item' => '',
            'action' => "",
            'forward' => "start_revisit",
            'left' => "third_cave_room",
            "back" => "start_revisit"
        ],
        'third_cave_room' => [
            'title' => 'cave',
            'description' => "You entered the third cave room",
            'image_class' => 'third_cave',
            'item' => '',
            'action' => "attack",
            'forward' => "start_revisit",
            'left' => "",
            "back" => "second_cave_room"
        ],
        'some_room' => [
            'title' => 'outside_cave',
            'description' => 'You emerge from the cave',
            'image_class' => 'outside_cave',
            'item' => '',
            'action' => "attack",
            'forward' => "some_room",
            'left' => "some_room",
            "back" => ""
        ]
    ];
}