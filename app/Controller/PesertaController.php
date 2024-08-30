<?php

namespace Rusdianto\Gevac\Controller;

use Exception;
use Rusdianto\Gevac\App\View;
use Ramsey\Uuid\Nonstandard\Uuid;
use Rusdianto\Gevac\Helper\Helper;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Service\DusunService;
use Rusdianto\Gevac\DTO\PesertaAddRequest;
use Rusdianto\Gevac\Service\PesertaService;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\DTO\PesertaUpdateRequest;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Repository\PesertaRepository;
use Rusdianto\Gevac\Repository\SessionRepository;

class PesertaController
{
    private SessionService $sessionService;
    private PesertaService $pesertaService;
    private DusunRepository $dusunRepository;
    private DusunService $dusunService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

        $this->dusunRepository = new DusunRepository($connection);
        $this->dusunService = new DusunService($this->dusunRepository);

        $pesertaRepository = new PesertaRepository($connection);
        $this->pesertaService = new PesertaService($pesertaRepository, $this->dusunRepository);
    }

    public function index(int $page = 1, string $message = "", string $error = ""): void
    {
        $page = $_GET["page"] ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $pesertaData = $this->pesertaService->getPaginatedPeserta($perPage, $offset)->peserta;
        $totalPeserta = $this->pesertaService->getTotalPesertaCount();

        $pesertaData = array_map(function ($value) {
            return [
                "id" => trim(strip_tags($value["id"])),
                "nik" => trim(strip_tags($value["nik"])),
                "nama" => trim(strip_tags($value["nama"])),
                "tgl_lahir" => trim(strip_tags(date("d-m-Y", strtotime($value["tgl_lahir"])))),
                "jenis_kelamin" => trim(strip_tags($value["jenis_kelamin"])),
                "kontak" => trim(strip_tags($value["kontak"])),
                "id_dusun" => trim(strip_tags($value["id_dusun"])),
                "nama_dusun" => trim(strip_tags($this->dusunRepository->findById($value["id_dusun"])->getNama())),
                "rt" => trim(strip_tags($value["rt"])),
                "rw" => trim(strip_tags($value["rw"])),
                "dosis" => trim(strip_tags($value["dosis"]))
            ];
        }, $pesertaData);

        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Peserta",
            "peserta" => $pesertaData,
            "currentPage" => $page,
            "totalPages" => ceil($totalPeserta / $perPage),
            "startIndex" => ($page - 1) * $perPage + 1,
            "message" => $message,
            "error" => $error
        ]);
        View::render("Peserta/index", $data);
    }

    public function add(string $error = ""): void
    {
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Tambah Peserta",
            "dusun" => $this->dusunService->show()->dusun,
            "error" => $error
        ]);
        View::render("Peserta/add", $data);
    }

    public function postAdd(): void
    {
        $request = new PesertaAddRequest();
        $request->id = Uuid::uuid4()->toString();
        $request->nik =  htmlspecialchars(trim($_POST["nik"]), ENT_QUOTES, "UTF-8");
        $request->nama =  htmlspecialchars(trim($_POST["nama"]), ENT_QUOTES, "UTF-8");
        $request->tglLahir =  htmlspecialchars(trim($_POST["tglLahir"]), ENT_QUOTES, "UTF-8");
        $request->jenisKelamin =  htmlspecialchars(trim($_POST["jenisKelamin"]), ENT_QUOTES, "UTF-8");
        $request->kontak =  htmlspecialchars(trim($_POST["kontak"]), ENT_QUOTES, "UTF-8");
        $request->idDusun =  htmlspecialchars(trim($_POST["dusun"]), ENT_QUOTES, "UTF-8");
        $request->rt =  htmlspecialchars(trim($_POST["rt"]), ENT_QUOTES, "UTF-8");
        $request->rw =  htmlspecialchars(trim($_POST["rw"]), ENT_QUOTES, "UTF-8");
        $request->dosis =  htmlspecialchars(trim($_POST["dosis"]), ENT_QUOTES, "UTF-8");

        try {
            $response = $this->pesertaService->add($request);
            if ($response->errors) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/peserta');</script>";
        } catch (Exception $exception) {
            $this->add(error: $exception->getMessage());
        }
    }

    public function update(string $id, string $error = ""): void
    {
        $peserta = $this->pesertaService->getPesertaData($id);
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Tambah Peserta",
            "peserta" => [
                "id" => $peserta->getId(),
                "nik" => $peserta->getNik(),
                "nama" => $peserta->getNama(),
                "tglLahir" => date("Y-m-d", strtotime($peserta->getTglLahir())),
                "jenisKelamin" => $peserta->getJenisKelamin(),
                "kontak" => $peserta->getKontak(),
                "idDusun" => $peserta->getIdDusun(),
                "rt" => $peserta->getRt(),
                "rw" => $peserta->getRw(),
                "dosis" => $peserta->getDosis()
            ],
            "dusun" => $this->dusunService->show()->dusun,
            "error" => $error
        ]);
        View::render("Peserta/edit", $data);
    }

    public function postUpdate(): void
    {
        $request = new PesertaUpdateRequest();
        $request->id = htmlspecialchars(trim($_POST["id"]), ENT_QUOTES, "UTF-8");
        $request->nik =  htmlspecialchars(trim($_POST["nik"]), ENT_QUOTES, "UTF-8");
        $request->nama =  htmlspecialchars(trim($_POST["nama"]), ENT_QUOTES, "UTF-8");
        $request->tglLahir =  htmlspecialchars(trim($_POST["tglLahir"]), ENT_QUOTES, "UTF-8");
        $request->jenisKelamin =  htmlspecialchars(trim($_POST["jenisKelamin"]), ENT_QUOTES, "UTF-8");
        $request->kontak =  htmlspecialchars(trim($_POST["kontak"]), ENT_QUOTES, "UTF-8");
        $request->idDusun =  htmlspecialchars(trim($_POST["dusun"]), ENT_QUOTES, "UTF-8");
        $request->rt =  htmlspecialchars(trim($_POST["rt"]), ENT_QUOTES, "UTF-8");
        $request->rw =  htmlspecialchars(trim($_POST["rw"]), ENT_QUOTES, "UTF-8");
        $request->dosis =  htmlspecialchars(trim($_POST["dosis"]), ENT_QUOTES, "UTF-8");

        try {
            $response = $this->pesertaService->updatePeserta($request);
            if ($response->errors) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/peserta');</script>";
        } catch (Exception $exception) {
            $this->update($request->id, error: $exception->getMessage());
        }
    }

    public function delete(string $id): void
    {
        try {
            $response = $this->pesertaService->deletePesertaById($id);
            if (!empty($response->errors)) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/peserta');</script>";
        } catch (Exception $exception) {
            $this->index(error: $exception->getMessage());
            echo "<script>history.replaceState({}, '', '/peserta');</script>";
        }
    }

    public function printData(): void
    {
        $this->pesertaService->printPesertaData();
    }
}
