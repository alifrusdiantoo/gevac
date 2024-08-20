<?php

namespace Rusdianto\Gevac\Middleware;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Session;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Service\SessionService;

require_once __DIR__ . "/../Helper/helper.php";

class MustLoginMiddlewareTest extends TestCase
{
    private MustLoginMiddleware $middleware;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->middleware = new MustLoginMiddleware();
        putenv("mode=test");

        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);
        $this->userRepository = new UserRepository($connection);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testBeforeGuest()
    {
        $this->middleware->before();
        $this->expectOutputRegex("[Location: /]");
    }

    public function testBeforeLoginUser()
    {
        $user = new User();
        $user->setId("1");
        $user->setUsername("john.doe");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setNama("John Doe");
        $user->setRoles("admin");
        $this->userRepository->insert($user);

        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId($user->getId());
        $this->sessionRepository->insert($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();
        $this->middleware->before();
        $this->expectOutputString("");
    }
}
