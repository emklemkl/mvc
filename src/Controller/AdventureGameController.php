<?php

namespace App\Controller;

use App\Dice\Dice;
use App\Dice\DiceGraphic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AdventureType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class AdventureGameController extends AbstractController
{
    private $rooms = [
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
            ]];

    public const MIN_ROLL_WITH_WEAPON = 2;
    public const MIN_ROLL_NO_WEAPON = 6;
    #[Route('/proj', name: 'proj')]
    public function startScreen(
    ): Response {
        if (!$session->has('rooms')) {
            $session->set('rooms', $this->rooms);
            print_r($session->get('rooms'));
        }
        return $this->render('adventure_game/adventure_game_landing.html.twig');
    }

    #[Route('/proj/adventure', name: 'adventure')]
    
    public function adventureGamePlay(
        SessionInterface $session
    ): Response {
        print_r($session->get('rooms'));
        $curRoom = $this->rooms[$session->get("current_room")] ?? $this->rooms["start"];
        if (null !== $session->get("backpack") && 
        in_array($curRoom["item"], $session->get("backpack")))
        {
            $curRoom["item"] = "hide";
        }
        return $this->render(
        'adventure_game/adventure_gameplay.html.twig', [
            'room' => $curRoom,
            "backpack" => $session->get("backpack")
        ]); 
    }
    #[Route('/proj/adventure/interact_handler', name: 'adventure_interact_handler', methods: ["POST"])]
    
    public function adventureInteractHandler(
        SessionInterface $session,
        Request $request
        ): Response {
        $formData = $request->request->get("sword");
        
        $session->set("backpack", [$formData]);
        return $this->redirectToRoute("adventure");
    }
    #[Route('/proj/adventure/next_room_handler', name: 'adventure_next_room_handler', methods: ["POST"])]
    
    public function adventureNextRoomHandler(
        SessionInterface $session,
        Request $request
        ): Response {
        $formData = $request->request->all();
        foreach ($formData as $_ => $value) {
            $session->set("current_room", $value);
        }


        // return new Response(json_encode($formData));
        return $this->redirectToRoute("adventure");
    }

    #[Route('/proj/adventure/attack_handler', name: 'adventure_attack_handler', methods: ["POST"])]
    
    public function adventureAttackHandler(
        SessionInterface $session,
        Request $request
        ): Response {
        $formData = $request->request->get("attack");
        if ($formData == "attack") {

            $dice = new DiceGraphic();
            $playerRoll = $dice->roll();
            if (in_array("sword", $session->get("backpack")) && $playerRoll >= self::MIN_ROLL_WITH_WEAPON) {
                return new Response(json_encode("success $playerRoll"));
            } 
            if ($playerRoll >= self::MIN_ROLL_NO_WEAPON) {
                return new Response(json_encode("success no weapon $playerRoll"));
            } 
            return new Response(json_encode("fail $playerRoll"));
            
            // foreach ($formData as $_ => $value) {
            //     $session->set("current_room", $value);
            // }
        }


        return new Response(json_encode($formData));
        // return $this->redirectToRoute("adventure");
    }
    #[Route('/proj/adventure/next_room_handler_test', name: 'adventure_next_room_handler_test', methods: ["POST"])]
    
    public function adventureNextRoomHandlerTest(
        SessionInterface $session,
        Request $request
        ): Response {
        $formData = $request->request->all();
        foreach ($formData as $_ => $value) {
            $session->set("current_room", $value);
        }


        return new Response(json_encode($formData));
        // return $this->redirectToRoute("adventure");
    }
    
}
