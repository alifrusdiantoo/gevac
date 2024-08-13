<?php

namespace Rusdianto\Gevac\Repository;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Role;
use Rusdianto\Gevac\Domain\User;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testInsertSuccess()
    {
        $user = new User();
        $user->setId("1");
        $user->setUsername("johndoe");
        $user->setPassword("password");
        $user->setNama("John Doe");
        $user->setRoles("sup-admin");

        $this->userRepository->insert($user);

        $result = $this->userRepository->findById($user->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getUsername(), $result->getUsername());
        self::assertEquals($user->getPassword(), $result->getPassword());
        self::assertEquals($user->getNama(), $result->getNama());
        self::assertEquals($user->getRoles(), $result->getRoles());
    }

    public function testShowAll()
    {
        $user1 = new User();
        $user1->setId("1");
        $user1->setUsername("johndoe");
        $user1->setPassword("password");
        $user1->setNama("John Doe");
        $user1->setRoles("sup-admin");

        $user2 = new User();
        $user2->setId("2");
        $user2->setUsername("johndoew");
        $user2->setPassword("password");
        $user2->setNama("John Doew");
        $user2->setRoles("admin");

        $this->userRepository->insert($user1);
        $this->userRepository->insert($user2);

        $result = $this->userRepository->findAll();

        self::assertNotNull($result);
    }

    public function testFindIdNotFound()
    {
        $user = $this->userRepository->findById("001");
        self::assertNull($user);
    }

    public function testDelete()
    {
        $user = new User();
        $user->setId("1");
        $user->setUsername("johndoe");
        $user->setPassword("password");
        $user->setNama("John Doe");
        $user->setRoles("sup-admin");

        $this->userRepository->insert($user);
        $check = $this->userRepository->findById($user->getId());
        self::assertNotNull($check);

        $this->userRepository->delete("1");
        $result = $this->userRepository->findById($user->getId());
        self::assertNull($result);
    }
}
