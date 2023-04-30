<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameControllerJson extends AbstractController
{
    //Landing page for json-api
    #[Route("/api/game", name: "api_game")]
    public function jsonDeck(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");
        $data = [
            "playerscore" => $game->getHands()[0]->getDrawnSum(),
            "playercards" => $game->getHands()[0]->printDrawnCards(),
            "bankscore" => $game->getHands()[1]->getDrawnSum(),
            "bankcards" => $game->getHands()[1]->printDrawnCards(),
            "winner" => $game->getWinner()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return $response;
    }
}
