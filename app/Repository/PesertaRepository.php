<?php

namespace Rusdianto\Gevac\Repository;

use Exception;
use PDO;
use Rusdianto\Gevac\Domain\Peserta;

class PesertaRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function show(): ?array
    {
        $statement = $this->connection->prepare("SELECT id, nik, nama, tgl_lahir, jenis_kelamin, kontak, id_dusun, rt, rw, dosis FROM participants ORDER BY added_at");
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }

    public function insert(Peserta $peserta): Peserta
    {
        $query = "INSERT INTO participants(id, nik, nama, tgl_lahir, jenis_kelamin, kontak, id_dusun, rt, rw, dosis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            $peserta->getId(),
            $peserta->getNik(),
            $peserta->getNama(),
            $peserta->getTglLahir(),
            $peserta->getJenisKelamin(),
            $peserta->getKontak(),
            $peserta->getIdDusun(),
            $peserta->getRt(),
            $peserta->getRw(),
            $peserta->getDosis()
        ]);

        return $peserta;
    }

    public function update(Peserta $peserta): Peserta
    {
        $query = "UPDATE participants SET nik = ?, nama = ?, tgl_lahir = ?, jenis_kelamin = ?, kontak = ?, id_dusun = ?, rt = ?, rw = ?, dosis = ? WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            $peserta->getNik(),
            $peserta->getNama(),
            $peserta->getTglLahir(),
            $peserta->getJenisKelamin(),
            $peserta->getKontak(),
            $peserta->getIdDusun(),
            $peserta->getRt(),
            $peserta->getRw(),
            $peserta->getDosis(),
            $peserta->getId()
        ]);
        return $peserta;
    }

    public function findById(string $id): ?Peserta
    {
        $statement = $this->connection->prepare("SELECT id, nik, nama, tgl_lahir, jenis_kelamin, kontak, id_dusun, rt, rw, dosis FROM participants WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $peserta = new Peserta();
                $peserta->setId($row["id"]);
                $peserta->setNik($row["nik"]);
                $peserta->setNama($row["nama"]);
                $peserta->setTglLahir($row["tgl_lahir"]);
                $peserta->setJenisKelamin($row["jenis_kelamin"]);
                $peserta->setKontak($row["kontak"]);
                $peserta->setIdDusun($row["id_dusun"]);
                $peserta->setRt($row["rt"]);
                $peserta->setRw($row["rw"]);
                $peserta->setDosis($row["dosis"]);

                return $peserta;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByNik(string $nik): ?Peserta
    {
        $statement = $this->connection->prepare("SELECT id, nik, nama, tgl_lahir, jenis_kelamin, kontak, id_dusun, rt, rw, dosis FROM participants WHERE nik = ?");
        $statement->execute([$nik]);

        try {
            if ($row = $statement->fetch()) {
                $peserta = new Peserta();
                $peserta->setId($row["id"]);
                $peserta->setNik($row["nik"]);
                $peserta->setNama($row["nama"]);
                $peserta->setTglLahir($row["tgl_lahir"]);
                $peserta->setJenisKelamin($row["jenis_kelamin"]);
                $peserta->setKontak($row["kontak"]);
                $peserta->setIdDusun($row["id_dusun"]);
                $peserta->setRt($row["rt"]);
                $peserta->setRw($row["rw"]);
                $peserta->setDosis($row["dosis"]);

                return $peserta;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function delete(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM participants WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM participants");
    }
}
