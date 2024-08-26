<?php

namespace Rusdianto\Gevac\Controller;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Controller\PesertaController;
use Rusdianto\Gevac\Repository\PesertaRepository;

class PesertaControllerTest extends TestCase
{
    private PesertaRepository $pesertaRepository;
    private PesertaController $pesertaController;

    protected function setUp(): void
    {
        $this->pesertaRepository = new PesertaRepository(Database::getConnection());
        $this->pesertaController = new PesertaController();

        require __DIR__ . "/../Helper/dummySession.php";
        putenv("mode=test");

        $this->pesertaRepository->deleteAll();
    }

    public function testIndex(): void
    {
        $this->pesertaController->index();
        $this->expectOutputRegex("[Data Peserta]");
    }

    public function testAdd(): void
    {
        $this->pesertaController->add();
        $this->expectOutputRegex("[Tambah Peserta]");
        $this->expectOutputRegex("[form]");
    }

    public function testAddSuccess(): void
    {
        $_POST["nik"] = "3301161905040003";
        $_POST["tglLahir"] = "1999-10-10";
        $_POST["nama"] = "John Doe";
        $_POST["jenisKelamin"] = "L";
        $_POST["dusun"] = "1";
        $_POST["rt"] = "001";
        $_POST["rw"] = "001";
        $_POST["kontak"] = "080123456789";
        $_POST["dosis"] = "1";

        $this->pesertaController->postAdd();
        $this->expectOutputRegex("[Peserta berhasil ditambahkan]");
    }

    public function testAddFailed(): void
    {
        $_POST["nik"] = "";
        $_POST["tglLahir"] = "1999-10-10";
        $_POST["nama"] = "John Doe";
        $_POST["jenisKelamin"] = "L";
        $_POST["dusun"] = "1";
        $_POST["rt"] = "001";
        $_POST["rw"] = "001";
        $_POST["kontak"] = "080123456789";
        $_POST["dosis"] = "1";

        $this->pesertaController->postAdd();
        $this->expectOutputRegex("[NIK tidak boleh kosong]");
    }
}
