<?php

namespace Rusdianto\Gevac\Controller;

use Exception;
use Ramsey\Uuid\Nonstandard\Uuid;
use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Helper\Helper;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\DTO\DusunAddRequest;
use Rusdianto\Gevac\DTO\DusunUpdateRequest;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Service\DusunService;

class DusunController
{
    private SessionService $sessionService;
    private DusunService $dusunService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        $dusunRepository = new DusunRepository($connection);

        $this->sessionService = new SessionService($sessionRepository, $userRepository);
        $this->dusunService = new DusunService($dusunRepository);
    }

    public function index(string $message = "", string $error = ""): void
    {
        $dusun = $this->dusunService->show()->dusun;
        $dusun = array_map(function ($value) {
            return [
                "id" => trim(strip_tags($value["id"])),
                "nama" => trim(strip_tags($value["nama"]))
            ];
        }, $dusun);

        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Dusun",
            "dusun" => $dusun,
            "message" => $message,
            "error" => $error
        ]);
        View::render("Dusun/index", $data);
    }

    public function add(): void
    {
        $request = new DusunAddRequest();
        $request->id = Uuid::uuid4()->toString();
        $request->nama = htmlspecialchars(trim($_POST["nama"]), ENT_QUOTES, "UTF-8");

        try {
            $response = $this->dusunService->add($request);
            if (!empty($response->errors)) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        } catch (Exception $exception) {
            $this->index(error: $exception->getMessage());
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        }
    }

    public function delete(string $id): void
    {
        try {
            $response = $this->dusunService->deleteDusunById($id);
            if (!empty($response->errors)) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        } catch (Exception $exception) {
            $this->index(error: $exception->getMessage());
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        }
    }

    public function update(): void
    {
        $request = new DusunUpdateRequest();
        $request->id = htmlspecialchars(trim($_POST["id"]), ENT_QUOTES, "UTF-8");
        $request->nama = htmlspecialchars(trim($_POST["nama"]), ENT_QUOTES, "UTF-8");

        try {
            $response = $this->dusunService->updateDusun($request);
            if (!empty($response->errors)) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        } catch (Exception $exception) {
            $this->index(error: $exception->getMessage());
            echo "<script>history.replaceState({}, '', '/dusun');</script>";
        }
    }
}
