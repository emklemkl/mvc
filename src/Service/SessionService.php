<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionService
{
    public function initSession(SessionInterface $session) {
        if (!$session->has('rooms')) {
            $session->set('rooms', $this->rooms);
            print_r($session->get('rooms'));
        }
    }
// Leave it empty or add a basic placeholder function if needed
}