<?php

use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;

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
