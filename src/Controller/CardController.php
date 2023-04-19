<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Dice\Card;
use App\Dice\CardGraphic;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CardController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        $hand = new CardHand(new DeckOfCards());
        // var_dump($hand->getDeckInHand());
        var_dump($hand->getH1());
        return $this->render('card/card.html.twig');
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new DeckOfCards(); 
        $data = [
            "deck" => $deck->getDeck()
        ];

        // Skapa en sida card/deck som visar samtliga kort i kortleken sorterade per färg och värde.
        return $this->render('card/deck.html.twig', $data);
    }
    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function shuffleDeck(): Response
    {
        // Skapa en sida card/deck/shuffle som visar 
        // samtliga kort i kortleken när den har blandats.
        return $this->render('card/card.html.twig');
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function drawCard(): Response
    {
        // Skapa en sida card/deck/draw som drar ett kort från kortleken
        // och visar upp det. Visa även antalet kort som är kvar i kortleken.
        return $this->render('card/card.html.twig');
    }

    #[Route("card/deck/draw/{num<\d+>}", name: "card_draws")]
    public function drawCards(Int $num): Response
    {
        if ($num > 52) {
            throw new \Exception("Can not draw more than 52 cards!");
        }
        // Skapa en sida card/deck/draw som drar ett kort från kortleken
        // och visar upp det. Visa även antalet kort som är kvar i kortleken.
        return $this->render('card/card.html.twig');
    }

    //Landing page for json-api
    #[Route("/api", name: "api")]
    public function jsonNumber(): Response
    {
        return $this->render("card/json_home.html.twig");
    }
}