<?php


use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Controller\UserController;
use Project\PHP\Login\Repository\UserRepository;

class UserControllerTest extends TestCase
{
    private UserController $userController;
    
    protected function setUp() : void
    {
        $this->userController = new UserController;
        
        $userRepository = new UserRepository(Database::getConnection());
        $userRepository->deleteAll;
    }
    

    public function testRegister()
    {
        $this->userController->register();

        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[Id]");
        $this->expectOutputRegex("[Name]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Register New User]");    
    }

    public function testPostRegister()
    {

    }

    public function testPostRegisterInvalide()
    {

    }

    public function testDuplicate()
    {
        
    }
}