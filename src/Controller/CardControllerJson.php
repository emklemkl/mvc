<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class CardControllerJson// extends AbstractController
{
    //Landing page for json-api
    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function jsonDeck(): Response
    {
        $deck = new DeckOfCards();
        $data = [
            "deck" => $deck->getDeck()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return $response;
    }
    
    #[Route("api/deck/shuffle", name: "api_deck_shuffle", methods: ['POST'])]
    public function jsonDeckShuffle(): Response
    {
        $data = [
            "hej" => "jsonDeckShuffle!"
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }

    #[Route("api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
    public function jsonDeckDraw(): Response
    {
        $data = [
            "hej" => "jsonDeckDraw!"
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("api/deck/draw/{num<\d+>}", name: "api_deck_draws", methods: ['POST'])]
    public function jsonDeckDraws(int $num): Response
    {   
        if ($num > 52) { throw new \Exception("Can not draw more than 52 cards!"); }

        $data = [
            "hej" => "jsonDeckDraw num: ". $num."!"
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
