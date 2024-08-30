<?php

namespace Rusdianto\Gevac\Repository;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\Domain\Peserta;
use Rusdianto\Gevac\Repository\PesertaRepository;

class PesertaRepositoryTest extends TestCase
{
    private PesertaRepository $pesertaRepository;
    private DusunRepository $dusunRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->pesertaRepository = new PesertaRepository($connection);
        $this->pesertaRepository->deleteAll();

        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Lorem");

        $this->dusunRepository = new DusunRepository($connection);
        $this->dusunRepository->deleteAll();
        $this->dusunRepository->insert($dusun);
    }

    public function tearDown(): void
    {
        $this->pesertaRepository->deleteAll();
        $this->dusunRepository->deleteAll();
    }

    public function testInsertSuccess(): void
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
        $result = $this->pesertaRepository->findById($peserta->getId());

        self::assertNotNull($result);
    }

    public function testUpdate(): void
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

        $peserta->setNama("John Dowe");
        $peserta->setJenisKelamin("P");
        $this->pesertaRepository->update($peserta);

        $result = $this->pesertaRepository->findById("1");
        self::assertEquals($peserta->getNama(), $result->getNama());
        self::assertEquals($peserta->getJenisKelamin(), $result->getJenisKelamin());
    }

    public function testShow(): void
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
        $result = $this->pesertaRepository->show();

        self::assertNotNull($result);
        self::assertEquals("3207116504630001", $result[0]["nik"]);
    }

    public function testGetPaginatedPeserta(): void
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

        $result = $this->pesertaRepository->getPaginatedPeserta(10, 0);
        self::assertNotNull($result);
    }

    public function testDelete(): void
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

        $this->pesertaRepository->delete($peserta->getId());
        $result = $this->pesertaRepository->findById($peserta->getId());

        self::assertNull($result);
    }

    public function testGetStatistic(): void
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

        $result = $this->pesertaRepository->getStatistic();

        self::assertEquals(1, $result["total_peserta"]);
        self::assertEquals(1, $result["total_laki_laki"]);
        self::assertEquals(0, $result["total_perempuan"]);
    }
}
