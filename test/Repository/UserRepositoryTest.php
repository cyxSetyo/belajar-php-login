<?php

use PHPUnit\Framework\TestCase;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Domain\User;
use Project\PHP\Login\Repository\UserRepository;

class UserRepositoryTest extends TestCase
{   
    private UserRepository $userRepository;
    
    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }
    
    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "cyx";
        $user->name = "cahyo";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);
        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }

    public function testFindIdNotFound()
    {
        $user = $this->userRepository->findById("notfound");
        self::assertNotNull($user);
    }
}