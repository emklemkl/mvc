<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\CardBank;
use App\Card\DeckOfCards;
use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    #[Route("/game", name: "game_landing")]
    public function home(
        SessionInterface $session,
    ): Response {
        $welcomeCards = new CardHand(new DeckOfCards());
        $welcomeCards->drawCards(4);

        $data = [    
            "deck"=>$welcomeCards->printAllDrawnCards(),
        ];
        return $this->render('game/game_landing.html.twig', $data);

    }

    #[Route("/game/play", name: "game_play")]
    public function play(
        SessionInterface $session,
    ): Response {
        if (!$session->has("game")) {
            $deck = new DeckOfCards();
            $game = new Game(new CardHand($deck), new CardBank($deck));
            $session->set("game", $game);
        }
        $game = $session->get("game");
        $game->getDrawnCardsGame();

        var_dump($game->whosTurnIsIt());
        $data = [    
            "deck"=> $game->getDrawnCardsGame(),
            "total"=> $game->getHands()[$game->whosTurnIsIt()]->getDrawnSum()
        ];

        return $this->render('game/game_play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function game_hit(
        SessionInterface $session,
    ): Response {
        $game = $session->get("game");
        $game->gameplayCycle();
        if ($game->isOver21()) {
            $this->addFlash("warning", "Bust! You crossed the 21 mark :(");
            return $this->redirectToRoute('game_landing');
        }
        $game = $session->set("game", $game);
        return $this->redirectToRoute('game_play');
    }
    
    #[Route("/game/stand", name: "game_stand")]
    public function stand(
        SessionInterface $session,
    ): Response {
        // if (!$session->has("game")) {
        //     $this->addFlash("warning", "You need to initiate a deck first. Press 'Play'");
        //     return $this->redirectToRoute('game_landing');
        // }
        $game = $session->get("game");
        if ($game->isBanksTurn()) {
            $this->addFlash("warning", "Bank finished its round");
            return $this->redirectToRoute('game_landing');
        }
        $game->nextPlayerTurn();
        $game = $session->set("game", $game);
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function doc(
    ): Response {
        return $this->render('game/doc.html.twig');
    }

    #[Route("game/clearsession", name: "clear_session_game")]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('game_landing');
    }
}
