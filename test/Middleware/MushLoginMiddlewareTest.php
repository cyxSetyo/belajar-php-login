<?php

namespace Project\PHP\Login\App{
    function header(string $value){
        echo $value;
    }
}

namespace Project\PHP\Login\Middleware{

use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\Session;
use Project\PHP\Login\Domain\User;
use Project\PHP\Login\Middleware\MushLoginMiddleware;
use Project\PHP\Login\Repository\SessionRepository;
use Project\PHP\Login\Repository\UserRepository;
use Project\PHP\Login\Service\SessionService;

class MushLoginMiddlewareTest extends TestCase
{
    private MushLoginMiddleware $middleware;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->middleware = new MushLoginMiddleware();
        putenv("mode=test");

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testBeforeGuest()
    {
        $this->middleware->before();
        $this->expectOutputRegex("[Location: login]");
    }

    public function testBeforeLoginUser()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->middleware->before();
        $this->expectOutputString("");
    }

}
}