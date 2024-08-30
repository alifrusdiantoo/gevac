<?php

namespace Rusdianto\Gevac\Middleware;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Domain\Session;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Middleware\SupAdminOnlyMiddleware;

require_once __DIR__ . "/../Helper/helper.php";

class SupAdminOnlyMiddlewareTest extends TestCase
{
    private SupAdminOnlyMiddleware $middleware;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->middleware = new SupAdminOnlyMiddleware();
        putenv("mode=test");

        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->sessionRepository = new SessionRepository($connection);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testBeforeNonSupAdmin(): void
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
        View::redirect("/users");
        $this->middleware->before();
        $this->expectOutputRegex('/Location: \/overview/');
    }

    public function testBeforeSupAdmin(): void
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
        View::redirect("/users");
        $this->middleware->before();
        $this->expectOutputRegex('/Location: \/users/');
    }
}
