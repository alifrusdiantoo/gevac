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

    public function index(string $message = "", string $error = ""): void
    {
        $peserta = $this->pesertaService->show()->peserta;
        foreach ($peserta as &$p) {
            $p["nama_dusun"] = $this->dusunRepository->findById($p["id_dusun"])->getNama();
            $p["tgl_lahir"] = date("d-m-Y", strtotime($p["tgl_lahir"]));
        }
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Peserta",
            "peserta" => $peserta,
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
        $request->nik = $_POST["nik"];
        $request->nama = $_POST["nama"];
        $request->tglLahir = $_POST["tglLahir"];
        $request->jenisKelamin = $_POST["jenisKelamin"];
        $request->kontak = $_POST["kontak"];
        $request->idDusun = $_POST["dusun"];
        $request->rt = $_POST["rt"];
        $request->rw = $_POST["rw"];
        $request->dosis = $_POST["dosis"];

        try {
            $response = $this->pesertaService->add($request);
            if ($response->errors) {
                throw new Exception(implode("", $response->errors));
            }
            $this->index(message: $response->message);
            echo "<script>history.replaceState({}, '', '/users');</script>";
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
        $request->id = $_POST["id"];
        $request->nik = $_POST["nik"];
        $request->nama = $_POST["nama"];
        $request->tglLahir = $_POST["tglLahir"];
        $request->jenisKelamin = $_POST["jenisKelamin"];
        $request->kontak = $_POST["kontak"];
        $request->idDusun = $_POST["dusun"];
        $request->rt = $_POST["rt"];
        $request->rw = $_POST["rw"];
        $request->dosis = $_POST["dosis"];

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
}
