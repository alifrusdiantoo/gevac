<?php

namespace Rusdianto\Gevac\Middleware;

use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Domain\Role;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;

class SupAdminOnlyMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void
    {
        $user = $this->sessionService->current();
        if ($user->getRoles() !== Role::from("sup-admin")) {
            View::redirect("/overview");
        }
    }
}
