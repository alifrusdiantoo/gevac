<?php

namespace Rusdianto\Gevac\Repository;

use PDO;
use Rusdianto\Gevac\Domain\User;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function insert(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO users(id, username, password, nama, roles) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getNama(),
            $user->getRoles()->value
        ]);

        return $user;
    }

    public function findAll(): ?array
    {
        $statement = $this->connection->prepare("SELECT id, username, password, nama, roles FROM users");
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }

    public function update(User $user): User
    {
        $statement = $this->connection->prepare("UPDATE users SET username = ?, password = ?, nama = ?, roles = ? WHERE id = ?");
        $statement->execute([
            $user->getUsername(),
            $user->getPassword(),
            $user->getNama(),
            $user->getRoles()->value,
            $user->getId()
        ]);
        return $user;
    }

    public function findById(string $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, username, password, nama, roles FROM users WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();

                $user->setId($row["id"]);
                $user->setUsername($row["username"]);
                $user->setPassword($row["password"]);
                $user->setNama($row["nama"]);
                $user->setRoles($row["roles"]);

                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByUsername(string $username): ?User
    {
        $statement = $this->connection->prepare("SELECT id, username, password, nama, roles FROM users WHERE username = ?");
        $statement->execute([$username]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();

                $user->setId($row["id"]);
                $user->setUsername($row["username"]);
                $user->setPassword($row["password"]);
                $user->setNama($row["nama"]);
                $user->setRoles($row["roles"]);

                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findDuplicateUsername(string $username, string $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, username, password, nama, roles FROM users WHERE username = ? AND id != ?");
        $statement->execute([$username, $id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();

                $user->setId($row["id"]);
                $user->setUsername($row["username"]);
                $user->setPassword($row["password"]);
                $user->setNama($row["nama"]);
                $user->setRoles($row["roles"]);

                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function delete(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM users WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM users");
    }
}
