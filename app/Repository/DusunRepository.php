<?php

namespace Rusdianto\Gevac\Repository;

use Exception;
use PDO;
use Rusdianto\Gevac\Domain\Dusun;

class DusunRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function show(): ?array
    {
        $statement = $this->connection->prepare("SELECT id, nama FROM sub_villages ORDER BY nama");
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }

    public function insert(Dusun $dusun): Dusun
    {
        $statement = $this->connection->prepare("INSERT INTO sub_villages(id, nama) VALUES (?, ?)");
        $statement->execute([$dusun->getId(), $dusun->getNama()]);
        return $dusun;
    }

    public function update(Dusun $dusun): Dusun
    {
        $statement = $this->connection->prepare("UPDATE sub_villages SET nama = ? WHERE id = ?");
        $statement->execute([$dusun->getNama(), $dusun->getId()]);
        return $dusun;
    }

    public function findById(string $id): ?Dusun
    {
        $statement = $this->connection->prepare("SELECT id, nama FROM sub_villages WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $dusun = new Dusun();
                $dusun->setId($row["id"]);
                $dusun->setNama($row["nama"]);

                return $dusun;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function delete(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM sub_villages WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM sub_villages");
    }
}
