<?php

namespace Rusdianto\Gevac\Controller;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Service\UserService;

class UserControllerTest extends TestCase
{
    private UserController $userController;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userController = new UserController();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();

        putenv("mode=test");
    }

    public function testIndex(): void
    {
        $this->userController->index();

        $this->expectOutputRegex("[Data User]");
        $this->expectOutputRegex("[table]");
        $this->expectOutputRegex("[modal]");
    }

    public function testIndexShowMessage(): void
    {
        $this->userController->index(message: "Hallo, ini message");

        $this->expectOutputRegex("[alert]");
        $this->expectOutputRegex("[alert-success]");
        $this->expectOutputRegex("[Hallo, ini message]");
    }

    public function testIndexShowError(): void
    {
        $this->userController->index(error: "Hallo, ini error");

        $this->expectOutputRegex("[alert]");
        $this->expectOutputRegex("[alert-danger]");
        $this->expectOutputRegex("[Hallo, ini error]");
    }

    public function testRegister(): void
    {
        $this->userController->register();

        $this->expectOutputRegex("[form]");
        $this->expectOutputRegex("[/users/register]");
        $this->expectOutputRegex("[post]");
        $this->expectOutputRegex("[nama]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[admin]");
    }

    public function testPostRegisterSuccess(): void
    {
        $_POST["id"] = "1";
        $_POST["nama"] = "Alif Rusdianto";
        $_POST["username"] = "alifrusdi";
        $_POST["password"] = "password";
        $_POST["roles"] = "admin";

        $this->userController->postRegister();

        $this->expectOutputRegex("[User berhasil ditambahkan]");
    }

    public function testPostRegisterValidationError(): void
    {
        $_POST["username"] = "alifrusdi";
        $_POST["password"] = "password";
        $_POST["roles"] = "admin";

        $this->userController->postRegister();

        $this->expectOutputRegex("[Nama tidak boleh kosong]");
    }

    public function testPostRegisterWhiteSpaceInput(): void
    {
        $_POST["nama"] = "        ";
        $_POST["username"] = "alifrusdi";
        $_POST["password"] = "";
        $_POST["roles"] = "admin";

        $this->userController->postRegister();

        $this->expectOutputRegex("[Nama tidak boleh kosong]");
    }

    public function testPostRegisterDuplicateUsername(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $_POST["nama"] = "Alif Rusdianto";
        $_POST["username"] = "alif.rusdianto";
        $_POST["password"] = "passwordlagi";
        $_POST["roles"] = "admin";

        $this->userController->postRegister();

        $this->expectOutputRegex("[Username sudah digunakan]");
    }

    public function testDeleteSuccess(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $this->userController->delete($user->getId());

        $this->expectOutputRegex("[User berhasil dihapus]");
    }

    public function testDeleteUserNotFound(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $this->userController->delete("2");

        $this->expectOutputRegex("[User tidak ditemukan]");
    }

    public function testUpdateProfile(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $_POST["id"] = "1";
        $_POST["nama"] = "Muhammad Alif Putranto";
        $_POST["username"] = "alif.rusdianto";
        $_POST["roles"] = "admin";

        $this->userController->postUpdateProfile();

        $result = $this->userRepository->findById("1");
        self::assertEquals($_POST["nama"], $result->getNama());
    }

    public function testUpdateProfileValidationError(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $_POST["id"] = "1";
        $_POST["username"] = "alif.rusdianto";
        $_POST["roles"] = "admin";

        $this->userController->postUpdateProfile();

        $this->expectOutputRegex("[Nama tidak boleh kosong]");
    }

    public function testUpdateProfileWhiteSpaceInput(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setNama("Alif Rusdianto");
        $user->setUsername("alif.rusdianto");
        $user->setPassword("password");
        $user->setRoles("admin");

        $this->userRepository->insert($user);

        $_POST["id"] = "1";
        $_POST["nama"] = "          ";
        $_POST["username"] = "alif.rusdianto";
        $_POST["roles"] = "admin";

        $this->userController->postUpdateProfile();

        $this->expectOutputRegex("[Nama tidak boleh kosong]");
    }

    public function testUpdateProfileDuplicateUsername(): void
    {
        $user1 = new User();
        $user1->setId("1");
        $user1->setNama("Alif Rusdianto Sr.");
        $user1->setUsername("alif.rusdianto");
        $user1->setPassword("password");
        $user1->setRoles("admin");

        $user2 = new User();
        $user2->setId("2");
        $user2->setNama("Alif Rusdianto Jr");
        $user2->setUsername("alif.rusdiantooo");
        $user2->setPassword("passwordlagi");
        $user2->setRoles("admin");

        $this->userRepository->insert($user1);
        $this->userRepository->insert($user2);

        $_POST["id"] = "1";
        $_POST["nama"] = "Alif Rusdianto Sr.";
        $_POST["username"] = "alif.rusdiantooo";
        $_POST["roles"] = "admin";

        $this->userController->postUpdateProfile();

        $this->expectOutputRegex("[Username sudah digunakan]");
    }
}
