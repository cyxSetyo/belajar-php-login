<?php
namespace Project\PHP\Login\Controller;

use Project\PHP\Login\App\View;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Exception\ValidationException;
use Project\PHP\Login\Model\UserLoginRequest;
use Project\PHP\Login\Model\UserPasswordUpdateRequest;
use Project\PHP\Login\Model\UserProfileUpdateRequest;
use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Repository\SessionRepository;
use Project\PHP\Login\Service\UserService;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\SessionService;

class UserController
{

    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        
        $this->sessionService = new SessionService($sessionRepository , $userRepository);
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

    public function login()
    {
        View::render('User/Login', [
            'title' => "Login",
                       
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try{
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        }catch(ValidationException $exception){
            View::render('User/Login', [
                'title' => "Login",
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function postLogout()
    {
        $this->sessionService->destroy();
        View::redirect('/');
    }

    public function updateProfile()
    {
        $user = $this->sessionService->current();

        View::render('User/profile', [
            "title" => "Update user profile",
            "user" => [
                "id" => $user->id,
                "name" => $user->name
            ]
        ]);
    }

    public function postUpdateProfile()
    {
        $user = $this->sessionService->current();

        $request = new UserProfileUpdateRequest();
        $request->id = $user->id;
        $request->name = $_POST['name'];

        try {
            $this->userService->updateProfile($request);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render('User/profile', [
                "title" => "Update user profile",
                "error" => $exception->getMessage(),
                "user" => [
                    "id" => $user->id,
                    "name" => $_POST['name']
                ]
            ]);
        }
    }

    public function updatePassword()
    {
        $user = $this->sessionService->current();
        
        View::render('User/password', [
            "title" => "Update Pasword",
            "user" => [
                "id" => $user->id,
            ]
        ]);
    }

    public function postPassword()
    {

        $user = $this->sessionService->current();

        $request = new UserPasswordUpdateRequest;
        $request->id = $user->id;
        $request->oldPassword = $_POST['oldPassword'];
        $request->newPassword = $_POST['newPassword'];
        
        try{
            $this->userService->updatePassword($request);
            View::redirect('/');
        }catch(ValidationException $exception){
            View::render('User/password', [
                "title" => "Update Pasword",
                "error" => $exception->getMessage()
            ]);
        }
    }

}