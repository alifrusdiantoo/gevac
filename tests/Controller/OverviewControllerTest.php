<?php

namespace Rusdianto\Gevac\Controller;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;

class OverviewControllerTest extends TestCase
{
    private OverviewController $overviewController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;

    protected function setUp(): void
    {
        $this->overviewController = new OverviewController();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId("99");
        $user->setUsername("john.doe");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setNama("John Doe");
        $user->setRoles("admin");

        $this->userRepository->insert($user);
        $session = $this->sessionService->create($user->getId());

        $_COOKIE[$this->sessionService::$COOKIE_NAME] = $session->getId();

        putenv("mode=test");
    }

    public function testIndex(): void
    {
        $this->overviewController->index();

        $this->expectOutputRegex("/John Doe/");
        $this->expectOutputRegex("/Overview/");
        $this->expectOutputRegex("/Jumlah Peserta/");
        $this->expectOutputRegex("/Jumlah Laki-Laki/");
        $this->expectOutputRegex("/Jumlah Perempuan/");
        $this->expectOutputRegex("/Rata-Rata Umur/");
    }
}
