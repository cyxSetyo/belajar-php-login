<?php

use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\User;
use Project\PHP\Login\Exception\ValidationException;
use Project\PHP\Login\Model\UserLoginRequest;
use Project\PHP\Login\Model\UserRegisterRequest;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\UserService;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

       
        $this->userRepository->deleteAll();
    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();

        $request->id = "eko";
        $request->password = "eko";

        $this->userService->login($request);
    }

    public function testLoginWrongPassword()
    {
        
    }

    public function testLoginSuccess()
    {

    }
}