<?php

namespace Rusdianto\Gevac\Middleware;

use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Middleware\Middleware;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;


class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user != null) {
            View::redirect('/users');
        }
    }
}
