<?php

namespace Rusdianto\Gevac\Service;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\DTO\DusunAddRequest;
use Rusdianto\Gevac\DTO\DusunUpdateRequest;
use Rusdianto\Gevac\Service\DusunService;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Exception\ValidationException;

class DusunServiceTest extends TestCase
{
    private DusunRepository $dusunRepository;
    private DusunService $dusunService;

    protected function setUp(): void
    {
        $this->dusunRepository = new DusunRepository(Database::getConnection());
        $this->dusunService = new DusunService($this->dusunRepository);

        $this->dusunRepository->deleteAll();
    }

    public function testAddSuccess(): void
    {
        $request = new DusunAddRequest();
        $request->id = "1";
        $request->nama = "Ciawitali";
        $response = $this->dusunService->add($request);

        self::assertEquals($request->id, $response->dusun->getId());
        self::assertEquals($request->nama, $response->dusun->getNama());
    }

    public function testAddFailed(): void
    {
        $request = new DusunAddRequest();
        $request->id = "";
        $request->nama = "";
        $response = $this->dusunService->add($request);

        self::assertEquals("Id tidak boleh kosong", $response->message);
    }

    public function testShowSuccess(): void
    {
        $request = new DusunAddRequest();
        $request->id = "1";
        $request->nama = "Ciawitali";
        $this->dusunService->add($request);

        $response = $this->dusunService->show();

        self::assertNotNull($response);
        self::assertEquals(1, count($response->dusun));
    }

    public function testShowNone(): void
    {
        $response = $this->dusunService->show();

        self::assertEmpty($response->dusun);
        self::assertEquals(0, count($response->dusun));
    }

    public function testDeleteSuccess(): void
    {
        $request = new DusunAddRequest();
        $request->id = "1";
        $request->nama = "Ciawitali";
        $this->dusunService->add($request);

        $response = $this->dusunService->deleteDusunById($request->id);
        $result = $this->dusunRepository->findById($request->id);

        self::assertTrue($response->success);
        self::assertEquals("Dusun berhasil dihapus", $response->message);
        self::assertNull($result);
    }

    public function testDeleteFailed(): void
    {
        $response = $this->dusunService->deleteDusunById("");

        self::assertFalse($response->success);
        self::assertEquals("Dusun tidak ditemukan", $response->errors[0]);
    }

    public function testUpdateSuccess(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");
        $this->dusunRepository->insert($dusun);

        $request = new DusunUpdateRequest();
        $request->id = $dusun->getId();
        $request->nama = "Nanggerang";
        $this->dusunService->updateDusun($request);

        $result = $this->dusunRepository->findById($dusun->getId());
        self::assertEquals($request->nama, $result->getNama());
    }

    public function testUpdateNotFound(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");
        $this->dusunRepository->insert($dusun);

        $request = new DusunUpdateRequest();
        $request->id = "2";
        $request->nama = "Nanggerang";
        $result = $this->dusunService->updateDusun($request);

        self::assertEquals("Dusun tidak ditemukan", $result->errors[0]);
    }

    public function testUpdateInputInvalid(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");
        $this->dusunRepository->insert($dusun);

        $request = new DusunUpdateRequest();
        $request->id = $dusun->getId();
        $request->nama = "       ";
        $result = $this->dusunService->updateDusun($request);

        self::assertEquals("Nama tidak boleh kosong", $result->errors[0]);
    }
}
