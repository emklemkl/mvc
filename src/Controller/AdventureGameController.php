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
use App\Service\SessionService;


class AdventureGameController extends AbstractController
{
    private SessionService $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public const MIN_ROLL_WITH_WEAPON = 2;
    public const MIN_ROLL_NO_WEAPON = 6;
    #[Route('/proj', name: 'proj')]
    public function startScreen(
    ): Response {
        $this->sessionService->initSession();
        return $this->render('adventure_game/adventure_game_landing.html.twig');
    }

    #[Route('/proj/adventure', name: 'adventure')]
    
    public function adventureGamePlay(
    ): Response {
        $curRoom = $this->sessionService->getSessionValueWithKey('current_room');
        if ($this->sessionService->isNotSessionVariableSet("backpack") && 
        $this->sessionService->isItemInBackpack($curRoom["item"])) {
                $curRoom["item"] = "hide";
        }
        return $this->render(
        'adventure_game/adventure_gameplay.html.twig', [
            'room' => $curRoom,
            "backpack" => $this->sessionService->getSessionValueWithKey("backpack")
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
        Request $request
        ): Response {
        $formData = $request->request->all();
        foreach ($formData as $_ => $value) {
            $this->sessionService->setCurrentRoom($value);
        }
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
