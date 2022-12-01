<?php
namespace Project\PHP\Login\Controller;

use Project\PHP\Login\App\View;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Exception\ValidationException;
use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Service\UserService;
use Project\PHP\Login\Repository\UserRepository;

class UserController
{

    private UserService $userService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
    }

    public function register()
    {
        View::render('User/register', [
            "title" => "Form New Register",
        ]);
    }

    public function postRegister()
    {
        $request = new UserRegisterRequest; 
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];
        
        try{
            $this->userService->register($request);
            View::redirect('login');
        }catch(ValidationException $exception){
            View::render('User/register',[
                "title" => "Form New Register",
                'error' => $exception->getMessage()
            ]);
        }
    }


}