<?php

namespace App\Controller;

use App\Dice\Card;
use App\Dice\CardGraphic;
use App\Dice\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CardController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        // ChatGpt is the shit for generating stuff like this

        return $this->render('card/card.html.twig');
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = [
            "s1" => "♠️A", "s2" => "♠️2", "s3" => "♠️3", "s4" => "♠️4", "s5" => "♠️5", "s6" => "♠️6", "s7" => "♠️7", "s8" => "♠️8", "s9" => "♠️9", "s10" => "♠️10", "s11" => "♠️J", "s12" => "♠️Q", "s13" => "♠️K",
            "h1" => "♥️A", "h2" => "♥️2", "h3" => "♥️3", "h4" => "♥️4", "h5" => "♥️5", "h6" => "♥️6", "h7" => "♥️7", "h8" => "♥️8", "h9" => "♥️9", "h10" => "♥️10", "h11" => "♥️J", "h12" => "♥️Q", "h13" => "♥️K",
            "c1" => "♣️A", "c2" => "♣️2", "c3" => "♣️3", "c4" => "♣️4", "c5" => "♣️5", "c6" => "♣️6", "c7" => "♣️7", "c8" => "♣️8", "c9" => "♣️9", "c10" => "♣️10", "c11" => "♣️J", "c12" => "♣️Q", "c13" => "♣️K",
            "d1" => "♦️A", "d2" => "♦️2", "d3" => "♦️3", "d4" => "♦️4", "d5" => "♦️5", "d6" => "♦️6", "d7" => "♦️7", "d8" => "♦️8", "d9" => "♦️9", "d10" => "♦️10", "d11" => "♦️J", "d12" => "♦️Q", "d13" => "♦️K",
        ];
        $data = [
            "cards" =>$deck
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