<?php

namespace Rusdianto\Gevac\Repository;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\Repository\DusunRepository;

class DusunRepositoryTest extends TestCase
{
    private DusunRepository $dusunRepository;

    protected function setUp(): void
    {
        $this->dusunRepository = new DusunRepository(Database::getConnection());
        $this->dusunRepository->deleteAll();
    }

    public function testInsertSuccess(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");

        $this->dusunRepository->insert($dusun);
        $result = $this->dusunRepository->findById($dusun->getId());

        self::assertNotNull($result);
    }

    public function testUpdateSuccess(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");
        $this->dusunRepository->insert($dusun);

        $dusun->setNama("Nanggerang");
        $this->dusunRepository->update($dusun);

        $result = $this->dusunRepository->findById($dusun->getId());
        self::assertEquals($dusun->getNama(), $result->getNama());
    }

    public function testShowAll(): void
    {
        $dusun1 = new Dusun();
        $dusun1->setId("1");
        $dusun1->setNama("Ciawitali");

        $dusun2 = new Dusun();
        $dusun2->setId("2");
        $dusun2->setNama("Ciroyom");

        $this->dusunRepository->insert($dusun1);
        $this->dusunRepository->insert($dusun2);

        $result = $this->dusunRepository->show();

        self::assertNotNull($result);
        self::assertEquals(2, count($result));
    }

    public function testDelete(): void
    {
        $dusun = new Dusun();
        $dusun->setId("1");
        $dusun->setNama("Ciawitali");
        $this->dusunRepository->insert($dusun);

        $this->dusunRepository->delete("1");

        $result = $this->dusunRepository->findById($dusun->getId());
        self::assertNull($result);
    }
}
