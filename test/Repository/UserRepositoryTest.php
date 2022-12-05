<?php

namespace Project\PHP\Login\Repository;

use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\User;

class UserRepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "eko";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound()
    {
        $user = $this->userRepository->findById("notfound");
        self::assertNull($user);
    }

    public function testUpdate()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "eko";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $user->name = "eko";
        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);

    }




}