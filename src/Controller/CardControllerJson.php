<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardControllerJson extends AbstractController
{
    //Landing page for json-api
    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function jsonDeck(SessionInterface $session): Response
    {
        $hand = $session->get("hand");
        $data = [
            "deck" => $hand->getDeckInHandValuesGraphInOrder()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return $response;
    }

    #[Route("api/deck/shuffle", name: "api_deck_shuffle_post", methods: ['POST'])]
    public function jsonDeckShufflePost(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand");
        $hand->shuffleHandDeck();
        $session->set("hand", $hand);
        return $this->redirectToRoute("api_deck_shuffle");
    }

    #[Route("api/deck/shuffle", name: "api_deck_shuffle")]
    public function jsonDeckShuffle(SessionInterface $session): Response
    {
        $hand = $session->get("hand");
        $data = [
            "deck" => $hand->getDeckInHandValuesGraph()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
    public function jsonDeckDraw(SessionInterface $session, Request $request): Response
    {
        $cardsToDraw = $request->get("cardsToDraw");

        $hand = $session->get("hand");
        $drawnCards = ((int)$cardsToDraw <= 1) ? $hand->drawCards() : $hand->drawCards($cardsToDraw);
        $cardsLeft = $hand->getDeckInHand()->countCardsInDeck();
        $data = [
            "drawncards" => $drawnCards,
            "cardsleft" => $cardsLeft
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    // #[Route("api/deck/draw/{num<\d+>}", name: "api_deck_draws", methods: ['POST'])]
    // public function jsonDeckDraws(int $num): Response
    // {
    //     if ($num > 52) {
    //         throw new \Exception("Can not draw more than 52 cards!");
    //     }

    //     $data = [
    //         "hej" => "jsonDeckDraw num: ". $num."!"
    //     ];
    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    //     );
    //     return $response;
    // }
}
