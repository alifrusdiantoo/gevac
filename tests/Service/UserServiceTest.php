<?php

namespace Rusdianto\Gevac\Service;

use PDO;
use Exception;
use DI\Container;
use function DI\get;
use DI\ContainerBuilder;
use function DI\autowire;
use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Domain\User;
use Ramsey\Uuid\Nonstandard\Uuid;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\DTO\UserRegisterRequest;

use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\DTO\UserPasswordUpdateRequest;
use Rusdianto\Gevac\Exception\ValidationException;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        // Define userRepository constructor
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            PDO::class => function () {
                return Database::getConnection();
            },
            UserRepository::class => autowire()->constructorParameter('connection', get(PDO::class))
        ]);

        $container = $containerBuilder->build();
        $this->userService = $container->get(UserService::class);

        $this->userService->userRepository->deleteAll();
    }

    public function testRegisterSuccess(): void
    {
        $request = new UserRegisterRequest();
        $request->id = "1";
        $request->username = "alifrusd";
        $request->password = "password";
        $request->nama = "Alif Rusdianto";
        $request->roles = "admin";
        $response = $this->userService->register($request);

        self::assertEquals($request->username, $response->user->getUsername());
        self::assertNotEquals($request->password, $response->user->getPassword());
        self::assertEquals($request->nama, $response->user->getNama());
        self::assertEquals($request->roles, $response->user->getRoles()->value);
    }

    public function testRegisterFailed(): void
    {
        $this->expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->id = "";
        $request->username = "";
        $request->password = "";
        $request->nama = "";
        $request->roles = "";

        $this->userService->register($request);
    }

    public function testRegisterDuplicate(): void
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->setId(Uuid::uuid4()->toString());
        $user->setUsername("alifrusd");
        $user->setPassword("password");
        $user->setNama("Alif Rusdianto");
        $user->setRoles("admin");
        $this->userService->userRepository->insert($user);

        $request = new UserRegisterRequest();
        $request->id = Uuid::uuid4()->toString();
        $request->username = "alifrusd";
        $request->password = "password";
        $request->nama = "Alif Rusdianto";
        $request->roles = "admin";
        $response = $this->userService->register($request);
    }

    public function testShowSuccess(): void
    {
        $user = new User();
        $user->setId(Uuid::uuid4()->toString());
        $user->setUsername("alifrusd");
        $user->setPassword("password");
        $user->setNama("Alif Rusdianto");
        $user->setRoles("admin");
        $this->userService->userRepository->insert($user);

        $result = $this->userService->show();
        self::assertNotNull($result);
    }

    public function testShowNotFound(): void
    {
        $result = $this->userService->show();
        self::assertEmpty($result->users);
    }

    public function testDeleteUserByIdSuccess(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setUsername("alifrusd");
        $user->setPassword("password");
        $user->setNama("Alif Rusdianto");
        $user->setRoles("admin");
        $this->userService->userRepository->insert($user);

        $this->userService->deleteUserById("1");
        $result = $this->userService->userRepository->findById("1");
        self::assertNull($result);
    }

    public function testDeleteUserByIdNotFound(): void
    {
        $result = $this->userService->deleteUserById("1");

        self::assertEquals($result->message, ["User tidak ditemukan"]);
    }

    public function testUpdatePasswordSuccess(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setUsername("alifrusd");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setNama("Alif Rusdianto");
        $user->setRoles("admin");
        $this->userService->userRepository->insert($user);

        $request = new UserPasswordUpdateRequest();
        $request->id = "1";
        $request->oldPassword = "password";
        $request->newPassword = "password baru";

        $this->userService->updatePassword($request);

        $result = $this->userService->userRepository->findById($user->getId());
        self::assertTrue(password_verify($request->newPassword, $result->getPassword()));
    }

    public function testUpdatePasswordNotMatch(): void
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->setId("1");
        $user->setUsername("alifrusd");
        $user->setPassword(password_hash("password", PASSWORD_BCRYPT));
        $user->setNama("Alif Rusdianto");
        $user->setRoles("admin");
        $this->userService->userRepository->insert($user);

        $request = new UserPasswordUpdateRequest();
        $request->id = "1";
        $request->oldPassword = "passwordbenar";
        $request->newPassword = "password baru";

        $response = $this->userService->updatePassword($request);
    }

    public function testUpdateValidationError(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserPasswordUpdateRequest();
        $request->id = "1";
        $request->oldPassword = "";
        $request->newPassword = "     ";

        $response = $this->userService->updatePassword($request);
    }

    public function testUpdatePasswordUserNotFound(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserPasswordUpdateRequest();
        $request->id = "1";
        $request->oldPassword = "passwordbenar";
        $request->newPassword = "password baru";

        $response = $this->userService->updatePassword($request);
    }
}
