<?php

namespace App\Controller;

use App\AdventureGame\AdventureGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\SessionService;


class AdventureGameController extends AbstractController
{
    private SessionService $sessionService;
    private AdventureGame $adventureGame;

    public function __construct(
        SessionService $sessionService,
        AdventureGame $adventureGame
        )
    {
        $this->sessionService = $sessionService;
        $this->adventureGame = $adventureGame;
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
        if ($this->sessionService->isNotSessionVariableSet("backpack") && // Hide current room item if picked up
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
        Request $request
        ): Response {
        $formData = $request->request->get("sword");
        $this->sessionService->setBackPackContent($formData);
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
        Request $request
        ): Response {
        $didEnemyDie = false;
        $formData = $request->request->get("attack");
        if ($formData == "attack") {
            $roll = $this->adventureGame->roll();
            $rollGraph = $this->adventureGame->rollGraphic();
            $didEnemyDie = $this->adventureGame->attackEnemy($this->sessionService->isItemInBackpack("sword"), $roll);
            if ($didEnemyDie) {
                $this->addFlash('enemy_status_defeated', 'Rolled: ' . $rollGraph . '<br>Enemy defeated!');
                $this->sessionService->killEnemyCurrentRoom();
            } else {
                $this->addFlash('enemy_status_alive', 'Rolled: ' . $rollGraph . '<br>Enemy Is still alive!');
            }
        }
        return $this->redirectToRoute("adventure");
    }
}