<?php

namespace Rusdianto\Gevac\Controller;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Controller\DusunController;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Repository\PesertaRepository;

class DusunControllerTest extends TestCase
{
    private DusunController $dusunController;
    private DusunRepository $dusunRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->dusunRepository = new DusunRepository($connection);
        $this->dusunController = new DusunController();
        $pesertaRepository = new PesertaRepository($connection);

        require __DIR__ . "/../Helper/dummySession.php";
        $pesertaRepository->deleteAll();
        $this->dusunRepository->deleteAll();

        putenv("mode=test");
    }

    public function testAddSuccess(): void
    {
        $_POST["id"] = "1";
        $_POST["nama"] = "Ciawitali";

        $this->dusunController->add();

        $this->expectOutputRegex("[Dusun berhasil ditambahkan]");
    }

    public function testDeleteSuccess(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");

        $this->dusunRepository->insert($dusun);
        $this->dusunController->delete("1");

        $this->expectOutputRegex("[Dusun berhasil dihapus]");
    }

    public function testDeleteFailed(): void
    {
        $this->dusunController->delete("1");
        $this->expectOutputRegex("[Dusun tidak ditemukan]");
    }
}
