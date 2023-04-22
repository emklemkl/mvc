<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Exception as Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(
        SessionInterface $session,
    ): Response {
        if (!$session->has("hand")) {
            $session->set("hand", new CardHand(new DeckOfCards()));
        }
        return $this->render('card/card.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand");
        $data = [
            "deck" => $hand->getDeckInHandValuesGraphInOrder()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand");
        // $hand->setDeckInHand($hand->shuffleHandDeck());
        $hand->shuffleHandDeck();
        $session->set("hand", $hand);
        $data = [
            "deck" => $hand->getDeckInHandValuesGraph()
        ];
        return $this->render('card/shuffled.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw", methods: ['GET'])]
    public function drawCard(
        Request $request,
        SessionInterface $session
    ): Response {
        $cardsToDraw = $request->get('cardsToDraw');
        $hand = $session->get("hand");
        if ($cardsToDraw) {
            $drawnCards = $hand->drawCards($cardsToDraw);
        } else {
            $drawnCards = $hand->drawCards();
        }
        $drawnCardsGraphics = new DeckOfCards($drawnCards);
        $data = [
            "deck" => $hand->getDeckInHandValuesGraph(),
            "cardsleft" =>  $hand->getDeckInHand()->countCardsInDeck(),
            "drawncards" => $drawnCardsGraphics->getDeckWithGraphic()
        ];
        $session->set("hand", $hand);
        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("card/deck/draw/{num<\d+>}", name: "card_draws")]
    public function drawCards(
        Int $num,
        SessionInterface $session
    ): Response {
        // $request->get('drawnCards');
        if ($num > 52) {
            throw new Exception("Can not draw more than 52 cards!");
        }
        $hand = $session->get("hand");
        $drawnCards = $hand->drawCards($num);
        $drawnCardsGraphics = new DeckOfCards($drawnCards);
        $data = [
            "deck" => $hand->getDeckInHandValuesGraph(),
            "cardsleft" =>  $hand->getDeckInHand()->countCardsInDeck(),
            "drawncards" => $drawnCardsGraphics->getDeckWithGraphic()
        ];
        $session->set("hand", $hand);
        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("card/clearsession", name: "clear_session")]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('card_start');
    }

    //Landing page for json-api
    #[Route("/api", name: "api")]
    public function jsonNumber(SessionInterface $session): Response
    {
        if (!$session->has("hand")) {
            $session->set("hand", new CardHand(new DeckOfCards()));
        }
        return $this->render("card/json_home.html.twig");
    }
}
