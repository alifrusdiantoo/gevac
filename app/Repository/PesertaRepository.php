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

    public function getPaginatedPeserta(int $limit, int $offset): ?array
    {
        $query = "SELECT id, nik, nama, tgl_lahir, jenis_kelamin, kontak, id_dusun, rt, rw, dosis FROM participants ORDER BY added_at LIMIT :limit OFFSET :offset";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getTotalPesertaCount(): int
    {
        $query = "SELECT COUNT(*) FROM participants";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchColumn();
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

    public function getStatistic(): array
    {
        $query = "
            SELECT
                COUNT(*) as total_peserta,
                SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) as total_laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) as total_perempuan,
                SUM(CASE WHEN dosis = '1' THEN 1 ELSE 0 END) as total_dosis_1,
                SUM(CASE WHEN dosis = '2' THEN 1 ELSE 0 END) as total_dosis_2,
                SUM(CASE WHEN dosis = '3' THEN 1 ELSE 0 END) as total_dosis_3,
                AVG(YEAR(CURDATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURDATE(), '%m-%d') < DATE_FORMAT(tgl_lahir, '%m-%d'))) as rata_rata_usia
            FROM participants
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
