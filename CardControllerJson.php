<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function jsonNumber(): Response
    {

        return $this->render("card/json_home.html.twig");
    }
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {


        return $this->render('card/card.html.twig');
    }
}
