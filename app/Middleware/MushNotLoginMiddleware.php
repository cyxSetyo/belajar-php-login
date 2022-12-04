<?php

namespace Project\PHP\Login\Middleware;

use Project\PHP\Login\App\View;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Repository\SessionRepository;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\SessionService;

class MushNotLoginMiddleware implements Middleware
{

    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }
    function before(): void
    {
        $user = $this->sessionService->current();
        if($user != null){
            View::redirect('/');
        }
    }
}