<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];
        // Prettyprint
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        $dateToday = date("y-m-d");
        $timestamp = time();
        $time = new DateTime();
        $time->setTimezone(new DateTimeZone('Europe/Stockholm'));
        $time->setTimestamp($timestamp);
        $responseGenerated = $time->format("H:i:s");
        $number = random_int(1, 3);
        $quotes = [
            '1' => "Life is what happens when you`re busy making other plans. -John Lennon",
            '2' => "If life were predictable it would cease to be life, and be without flavor. -Eleanor Roosevelt",
            '3' => "The way to get started is to quit talking and begin doing. -Walt Disney"
        ];
        $aQuote =  [
            $number => $quotes[$number],
            "date" => $dateToday,
            "timestamp"=> $responseGenerated,
        ];

        $response = $this->prettyPrintJsonResponse($aQuote);

        return $response;
    }

    public function prettyPrintJsonResponse($data) : mixed 
    {
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
