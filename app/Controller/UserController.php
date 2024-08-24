<?php

namespace Rusdianto\Gevac\Controller;

use Exception;
use Rusdianto\Gevac\App\View;
use Ramsey\Uuid\Nonstandard\Uuid;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\DTO\UserLoginRequest;
use Rusdianto\Gevac\DTO\UserPasswordUpdateRequest;
use Rusdianto\Gevac\DTO\UserProfileUpdateRequest;
use Rusdianto\Gevac\Service\UserService;
use Rusdianto\Gevac\DTO\UserRegisterRequest;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Helper\Helper;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Service\SessionService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(string $message = "", string $error = ""): void
    {
        $user = $this->userService->show();
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Data User",
            "users" => $user->users,
            "message" => $message,
            "error" => $error
        ]);
        View::render("User/index", $data);
    }

    public function register(string $error = ""): void
    {
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Tambah User",
            "error" => $error
        ]);
        View::render("User/register", $data);
    }

    public function postRegister(): void
    {
        $request = new UserRegisterRequest();
        $request->id = Uuid::uuid4()->toString();
        $request->nama = $_POST["nama"];
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];
        $request->roles = $_POST["roles"];

        try {
            $response = $this->userService->register($request);
            $this->index(message: implode("", $response->message));
            echo "<script>history.replaceState({}, '', '/users');</script>";
        } catch (Exception $exception) {
            $this->register(error: $exception->getMessage());
        }
    }

    public function login(): void
    {
        View::render("User/login", [
            "title" => "Gevac | Login"
        ]);
    }

    public function postLogin(): void
    {
        $request = new UserLoginRequest();
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->getId());
            View::redirect("/overview");
        } catch (ValidationException $exception) {
            View::render("User/login", [
                "title" => "Gevac | Login",
                "message" => $exception->getMessage()
            ]);
        }
    }

    public function logout(): void
    {
        $this->sessionService->destroy();
        View::redirect("/");
    }

    public function delete(string $id): void
    {
        try {
            $response = $this->userService->deleteUserById($id);
            if (!$response) {
                throw new Exception($response->errors);
            }
            $this->index(message: implode("", $response->message));
            echo "<script>history.replaceState({}, '', '/users');</script>";
        } catch (Exception $exception) {
            $this->index(error: $exception->getMessage());
            echo "<script>history.replaceState({}, '', '/users');</script>";
        }
    }

    public function updateProfile(string $id, string $message = ""): void
    {
        $user = $this->userService->getProfile($id);
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Tambah User",
            "user" => [
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "nama" => $user->getNama(),
                "roles" => $user->getRoles()
            ],
            "message" => $message
        ]);
        View::render("User/edit", $data);
    }

    public function postUpdateProfile(): void
    {
        $request = new UserProfileUpdateRequest();
        $request->id = $_POST["id"];
        $request->nama = $_POST["nama"];
        $request->username = $_POST["username"];
        $request->roles = $_POST["roles"];

        try {
            $response = $this->userService->updateProfile($request);
            $this->index(message: implode("", $response->message));
            echo "<script>history.replaceState({}, '', '/users');</script>";
        } catch (ValidationException $exception) {
            $this->updateProfile($request->id, $exception->getMessage());
        }
    }

    public function updatePassword(string $id, string $message = ""): void
    {
        $user = $this->userService->getProfile($id);
        View::render("User/password", [
            "title" => "Gevac | Tambah User",
            "user" => [
                "id" => $user->getId()
            ],
            "message" => $message
        ]);
    }

    public function postUpdatePassword(): void
    {
        $request = new UserPasswordUpdateRequest();
        $request->id = $_POST["id"];
        $request->oldPassword = $_POST["oldPassword"];
        $request->newPassword = $_POST["newPassword"];

        try {
            $response = $this->userService->updatePassword($request);
            $this->index(message: implode("", $response->message));
            echo "<script>history.replaceState({}, '', '/users');</script>";
        } catch (ValidationException $exception) {
            $this->updatePassword($request->id, $exception->getMessage());
        }
    }
}
