<?php

namespace Rusdianto\Gevac\Middleware;

use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Service\SessionService;

class MustLoginMiddleware implements Middleware
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
        if ($user == null) {
            View::redirect("/");
        }
    }
}
