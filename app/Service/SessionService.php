<?php

namespace Rusdianto\Gevac\Service;

use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Domain\Session;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;

class SessionService
{
    public static string $COOKIE_NAME = "GEVAC-SESSION";
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function create(string $userId): Session
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId($userId);
        $this->sessionRepository->insert($session);

        setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60 * 60 * 24), "/");
        return $session;
    }

    public function destroy(): void
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, "", 1, "/");
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->userRepository->findById($session->getUserId());
    }
}
