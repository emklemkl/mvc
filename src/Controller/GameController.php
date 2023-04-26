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
        $deck = new DeckOfCards();
        $hand = new CardHand($deck);
        $bank = new CardBank($deck);
        $hand->drawCards(1);
        $bank->drawCards(5);
        // var_dump($hand->getAllDrawnCards());
        // var_dump($bank->getAllDrawnCards());
        // var_dump($hand->getDeckInHandValues());

        if ($hand->isOver21()) {
            echo "Over";
        }
        if (!$hand->isOver21()) {
            echo "Under";
        }
        $data = [    
            "deck"=>$bank->printAllDrawnCards(),
        ];
        return $this->render('game/game_landing.html.twig', $data);
    }

    #[Route("/game/play", name: "game_play")]
    public function play(
        SessionInterface $session,
    ): Response {
        if (!$session->has("game-hands")) {
            $deck = new DeckOfCards();
            $game = new Game(new CardHand($deck), new CardBank($deck));
            $session->set("game-hands", $game);
        }

        $data = [    
            "asStr"=> "asdasd",
        ];

        return $this->render('game/game_play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function game_hit(
    ): Response {
        return $this->redirectToRoute('game_play');
    }
    
    #[Route("/game/stand", name: "game_stand")]
    public function stand(
    ): Response {
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
