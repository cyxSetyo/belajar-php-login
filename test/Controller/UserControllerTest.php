<?php

namespace Project\PHP\Login\App{
    function header(string $value){
        echo $value;
    }
}

namespace Project\PHP\Login\Controller{

use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Controller\UserController;
    use Project\PHP\Login\Domain\Session;
    use Project\PHP\Login\Domain\User;
    use Project\PHP\Login\Repository\SessionRepository;
    use Project\PHP\Login\Repository\UserRepository;
    use Project\PHP\Login\Service\SessionService;

class UserControllerTest extends TestCase
{
    private UserController $userController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    
    
    
    protected function setUp() : void
    {
        $this->userController = new UserController;

        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
        
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();

        putenv("mode=test");
    }
    

    public function testRegister()
    {
        $this->userController->register();

        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[Id]");
        $this->expectOutputRegex("[Name]");
        $this->expectOutputRegex("[Password]");    
    }

    public function testPostRegister()
    {
        $_POST['id'] = "cahyo";
        $_POST['name'] = "cahyo";
        $_POST['password'] = "rahasia";

        $this->userController->postRegister();

        $this->expectOutputRegex("[Location: users/login]");
    }

    public function testPostRegisterInvalide()
    {
        $_POST['id'] = "";
        $_POST['name'] = "";
        $_POST['password'] = "rahasia";

        $this->userController->postRegister();
        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[Id]");
        $this->expectOutputRegex("[Name]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Id, User, Password Cant Blank]"); 

    }

    public function testDuplicate()
    {
        $user = new User;
        $user->id= "cahyos";
        $user->name = "cahyo";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $_POST['id'] = "cahyos";
        $_POST['name'] = "cahyo";
        $_POST['password'] = "rahasia";

        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[Id]");
        $this->expectOutputRegex("[Name]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[User Already Exists]");
    }
    
    public function testUpdateProfile()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->userController->updateProfile();

        $this->expectOutputRegex("[Profile]");
        $this->expectOutputRegex("[Id]");
        $this->expectOutputRegex("[eko]");
        $this->expectOutputRegex("[Name]");
        $this->expectOutputRegex("[Eko]");
    }

    public function testPostUpdateProfileSuccess()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $_POST['name'] = 'Budi';
        $this->userController->postUpdateProfile();

        $this->expectOutputRegex("[Location: /]");

        $result = $this->userRepository->findById("eko");
        self::assertEquals("Budi", $result->name);
    }

}
}
