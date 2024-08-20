<?php

namespace Rusdianto\Gevac\Repository;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Session;
use Rusdianto\Gevac\Domain\User;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User;
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setRoles("admin");

        $this->userRepository->insert($user);
    }

    public function testInsertSuccess(): void
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("1");

        $this->sessionRepository->insert($session);
        $result = $this->sessionRepository->findById($session->getId());

        self::assertEquals($session->getId(), $result->getId());
        self::assertEquals($session->getUserId(), $result->getUserId());
    }

    public function testDeleteByIdSuccess(): void
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("1");

        $this->sessionRepository->insert($session);
        $this->sessionRepository->deleteById($session->getId());

        $result = $this->sessionRepository->findById($session->getId());
        Self::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById('anon-id');
        Self::assertNull($result);
    }
}
