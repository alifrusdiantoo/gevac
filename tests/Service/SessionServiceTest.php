<?php

namespace Rusdianto\Gevac\Service;

require_once __DIR__ . "/../Helper/helper.php";

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Session;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Repository\UserRepository;

class SessionServiceTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId("1");
        $user->setUsername("john.doe");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setNama("John Doe");
        $user->setRoles("admin");

        $this->userRepository->insert($user);
    }

    public function testCreate(): void
    {
        $session = $this->sessionService->create("1");
        $this->expectOutputRegex("[GEVAC-SESSION: {$session->getId()}]");

        $result = $this->sessionRepository->findById($session->getId());
        self::assertEquals("1", $result->getUserId());
    }

    public function testDestroy(): void
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("1");

        $this->sessionRepository->insert($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();
        $this->sessionService->destroy();
        $this->expectOutputRegex("[GEVAC-SESSION: ]");

        $result = $this->sessionRepository->findById($session->getId());
        self::assertNull($result);
    }

    public function testCurrent(): void
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("1");

        $this->sessionRepository->insert($session);
        $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();

        $user = $this->sessionService->current();
        self::assertEquals($session->getUserId(), $user->getId());
    }
}
