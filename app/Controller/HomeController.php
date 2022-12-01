<?php

namespace Project\PHP\Login\Controller;

use Project\PHP\Login\App\View;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\User;
use Project\PHP\Login\Repository\SessionRepository;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $serviceRespository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($serviceRespository, $userRepository); 
    }

    function index()
    {
        $user = $this->sessionService->current();
        if($user == null){
            View::render('Home/index', [
                "title" => "PHP Login Management"
            ]);
        }else{
            View::render('Home/dashboard', [
                'title' => "Dashboard",
                'user' => [
                    "name" => $user->name
                    ]
            ]);
        }

    }

}