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
    ): Response {
        // welcomecards are not used, they only used to display some cards at the welcome screen
        $welcomeCards = new CardHand(new DeckOfCards());
        $welcomeCards->drawCards(4);
        $data = [
            "deck"=>$welcomeCards->printDrawnCards(),
        ];
        return $this->render('game/game_landing.html.twig', $data);
    }

    #[Route("/game/play", name: "game_play")]
    public function play(
        SessionInterface $session,
    ): Response {
        // Initiate session vars
        if (!$session->has("game")) {
            $deck = new DeckOfCards();
            $game = new Game(new CardHand($deck), new CardBank($deck));
            $session->set("game", $game);
        }
        $game = $session->get("game");
        $data = [
            "deck"=> $game->getDrawnCardsGame(),
            "total"=> $game->getHands()[$game->whosTurnIsIt()]->getDrawnSum()
        ];
        return $this->render('game/game_play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function gameHit(
        SessionInterface $session,
    ): Response {
        $game = $session->get("game");
        $isBankFinished = $game->gameplayCycle();
        if ($game->isOver21()) {
            $game = $session->set("game", $game);
            return $this->redirectToRoute('game_finished');
        }
        if ($isBankFinished) {
            $game = $session->set("game", $game);
            return $this->redirectToRoute('game_finished');
        }
        $game = $session->set("game", $game);
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/stand", name: "game_stand")]
    public function stand(
        SessionInterface $session,
    ): Response {
        $game = $session->get("game");
        $game->nextPlayerTurn();
        $isBanksTurn = $game->isBanksTurn();
        $game = $session->set("game", $game);
        if ($isBanksTurn) {
            return $this->redirectToRoute('game_hit');
        }
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/finished", name: "game_finished")]
    public function finished(
        SessionInterface $session,
    ): Response {
        $game = $session->get("game");
        $this->addFlash("notice", "".$game->getWinner(). " won!");
        $game->getAllDrawnCards();
        $data = [
            "player"=> $game->getAllDrawnCards()[0],
            "playertotal"=> $game->getHands()[0]->getDrawnSum(),
            "bank"=> $game->getAllDrawnCards()[1],
            "banktotal"=> $game->getHands()[1]->getDrawnSum(),
        ];
        $session->clear();
        return $this->render('game/game_finished.html.twig', $data);
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
