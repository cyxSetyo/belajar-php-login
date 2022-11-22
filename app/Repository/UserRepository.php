<?php

namespace Project\PHP\Login\Repository;

use PHPUnit\TextUI\XmlConfiguration\Variable;
use Project\PHP\Login\Domain\User;

class UserRepository
{

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user) : User
    {
        $statement =  $this->connection-> prepare("INSERT INTO users(id, name, password) VALUES (?, ?, ?)");
        $statement->execute([
            $user->id, $user->user, $user->password
        ]);
        return $user;
    }
}