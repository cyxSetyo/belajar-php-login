<?php

namespace Project\PHP\Login\Controller;

use Exception;
use Project\PHP\Login\App\View;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Exception\ValidationException;
use Project\PHP\Login\Model\UserLoginRequest;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\UserService;

class UserLoginController
{
    private UserService $userService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
    }

    public function login()
    {
        View::render('User/Login', [
            'title' => "Login"
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try{
            $this->userService->login($request);
            //redirect to dashboard
        }catch(ValidationException $exception){
            View::render('User/Login', [
                'title' => "Login",
                'error' => $exception->getMessage()
            ]);
        }
    }

}