<?php

namespace Rusdianto\Gevac\Service;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\Domain\Peserta;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\DTO\PesertaAddRequest;
use Rusdianto\Gevac\Service\PesertaService;
use Rusdianto\Gevac\DTO\PesertaUpdateRequest;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Repository\PesertaRepository;

class PesertaServiceTest extends TestCase
{
    private PesertaRepository $pesertaRepository;
    private PesertaService $pesertaService;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $dusunRepository = new DusunRepository($connection);
        $this->pesertaRepository = new PesertaRepository($connection);
        $this->pesertaService = new PesertaService($this->pesertaRepository, $dusunRepository);

        $this->pesertaRepository->deleteAll();
        $dusunRepository->deleteAll();

        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Lorem");

        $dusunRepository->insert($dusun);
    }

    public function testAddSuccess(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630001";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals($request->id, $response->peserta->getId());
    }

    public function testAddBlankId(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "    ";
        $request->nik = "3207116504630001";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Id tidak boleh kosong", $response->errors[0]);
    }

    public function testAddSameId(): void
    {
        $peserta = new Peserta();
        $peserta->setId("1");
        $peserta->setNik("3207116504630001");
        $peserta->setNama("John Doe");
        $peserta->setTglLahir("1963-04-25");
        $peserta->setKontak("080123456789");
        $peserta->setIdDusun("1");
        $peserta->setRt("001");
        $peserta->setRw("001");
        $peserta->setJenisKelamin("L");
        $peserta->setDosis("1");

        $this->pesertaRepository->insert($peserta);

        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "Doew John";
        $request->tglLahir = "1973-04-22";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "P";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Id sudah digunakan", $response->errors[0]);
    }

    public function testAddBlankNik(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "    ";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("NIK tidak boleh kosong", $response->errors[0]);
    }

    public function testAddWrongLengthNik(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "32071116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Panjang NIK tidak sesuai format", $response->errors[0]);
    }

    public function testAddWrongFormatNik(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207a16504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Format NIK tidak sesuai. Terdapat karakter bukan angka", $response->errors[0]);
    }

    public function testAddBlankTglLahir(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "   ";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Tanggal lahir tidak boleh kosong", $response->errors[0]);
    }

    public function testAddNotEnoughAge(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "2024-05-21";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Umur tidak mencukupi", $response->errors[0]);
    }

    public function testAddBlankNama(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "    ";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Nama tidak boleh kosong", $response->errors[0]);
    }

    public function testAddBlankJenisKelamin(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Jenis kelamin tidak boleh kosong", $response->errors[0]);
    }

    public function testAddJenisKelaminNotMatch(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "B";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Jenis kelamin tidak sesuai", $response->errors[0]);
    }

    public function testAddBlankDusun(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Dusun tidak boleh kosong", $response->errors[0]);
    }

    public function testAddDusunNotFound(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "2";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Dusun tidak terdaftar", $response->errors[0]);
    }

    public function testAddBlankRt(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("RT tidak boleh kosong", $response->errors[0]);
    }

    public function testAddWrongFormatRt(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "1";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Format RT tidak sesuai", $response->errors[0]);
    }

    public function testAddBlankRw(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("RW tidak boleh kosong", $response->errors[0]);
    }

    public function testAddWrongFormatRw(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "1";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Format RW tidak sesuai", $response->errors[0]);
    }

    public function testAddBlankKontak(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Kontak tidak boleh kosong", $response->errors[0]);
    }

    public function testAddWrongFormatKontak(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "08012345678912";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Kontak tidak boleh melebihi 13 digit", $response->errors[0]);
    }

    public function testAddBlankDosis(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Dosis tidak boleh kosong", $response->errors[0]);
    }

    public function testAddNotAvailableDosis(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630002";
        $request->nama = "John Doe";
        $request->tglLahir = "1998-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "-1";

        $response = $this->pesertaService->add($request);
        self::assertEquals("Dosis tidak/belum tersedia", $response->errors[0]);
    }

    public function testUpdateSuccess(): void
    {
        $peserta = new Peserta();
        $peserta->setId("1");
        $peserta->setNik("3207116504630001");
        $peserta->setNama("John Doe");
        $peserta->setTglLahir("1963-04-25");
        $peserta->setKontak("080123456789");
        $peserta->setIdDusun("1");
        $peserta->setRt("001");
        $peserta->setRw("001");
        $peserta->setJenisKelamin("L");
        $peserta->setDosis("1");
        $this->pesertaRepository->insert($peserta);

        $request = new PesertaUpdateRequest();
        $request->id = "1";
        $request->nik = "3207116504630001";
        $request->nama = "John Doew";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";
        $response = $this->pesertaService->updatePeserta($request);

        self::assertEquals($request->nama, $response->peserta->getNama());
    }

    public function testShow(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630001";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";
        $this->pesertaService->add($request);

        $response = $this->pesertaService->show();
        self::assertNotNull($response);
        self::assertEquals(1, count($response->peserta));
    }

    public function testDelete(): void
    {
        $request = new PesertaAddRequest();
        $request->id = "1";
        $request->nik = "3207116504630001";
        $request->nama = "John Doe";
        $request->tglLahir = "1963-04-25";
        $request->kontak = "080123456789";
        $request->idDusun = "1";
        $request->rt = "001";
        $request->rw = "001";
        $request->jenisKelamin = "L";
        $request->dosis = "1";
        $this->pesertaService->add($request);

        $response = $this->pesertaService->deletePesertaById($request->id);
        $result = $this->pesertaRepository->findById($request->id);

        self::assertTrue($response->success);
        self::assertEquals("Peserta berhasil dihapus", $response->message);
        self::assertNull($result);
    }
}
