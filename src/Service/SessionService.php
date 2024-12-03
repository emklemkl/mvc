<?php

namespace App\Service;

use App\AdventureGame\AdventureGame;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionService
{
    private $session;
    private AdventureGame $adventureGame;
    private const CURRENT_ROOM = "current_room";
    private const BACKPACK = "backpack";
    private const ROOMS = "rooms";
    public function __construct(RequestStack $requestStack, AdventureGame $adventureGame)
    {
        $this->session = $requestStack->getSession();
        $this->adventureGame = $adventureGame;
    }
    public function initSession() {
        // print_r($this->adventureGame->rooms);

        if (!$this->session->has(self::ROOMS)) {
            $this->session->set(self::ROOMS, $this->adventureGame->rooms);
            // print_r($this->session->get('rooms'));
        }
        if (!$this->session->has(self::BACKPACK)) {
            $this->session->set(self::BACKPACK, []);
            // print_r($this->session->get('rooms'));
        }
        if (!$this->session->has(self::CURRENT_ROOM)) {
            $this->session->set(self::CURRENT_ROOM, $this->adventureGame->rooms["start"]);
            // print_r($this->session->get('rooms'));
        }
    }

    public function setCurrentRoom($newRoom) {
        $this->session->set(self::CURRENT_ROOM, $this->adventureGame->rooms[$newRoom]);
    }

    public function isNotSessionVariableSet($var) {
        return null !== $this->session->get($var);
    }

    public function isItemInBackpack($item) {
        return in_array($item, $this->session->get("backpack"));
    }

    public function getSessionValueWithKey($key) {
        return $this->session->get($key);
    }
}