<?php

namespace Rusdianto\Gevac\Service;

use DateTime;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Peserta;
use Rusdianto\Gevac\DTO\PesertaAddRequest;
use Rusdianto\Gevac\DTO\PesertaAddResponse;
use Rusdianto\Gevac\DTO\PesertaDeleteResponse;
use Rusdianto\Gevac\DTO\PesertaShowResponse;
use Rusdianto\Gevac\DTO\PesertaUpdateRequest;
use Rusdianto\Gevac\DTO\PesertaUpdateResponse;
use Rusdianto\Gevac\Repository\PesertaRepository;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Validators\PesertaRequestValidator;

class PesertaService
{
    private PesertaRepository $pesertaRepository;
    private DusunRepository $dusunRepository;

    public function __construct(PesertaRepository $pesertaRepository, DusunRepository $dusunRepository)
    {
        $this->pesertaRepository = $pesertaRepository;
        $this->dusunRepository = $dusunRepository;
    }

    public function show(): PesertaShowResponse
    {
        $response = new PesertaShowResponse();
        try {
            $peserta = $this->pesertaRepository->show();
            $response->peserta = $peserta;
            $response->success = true;
        } catch (Exception $exception) {
            $response->success = false;
            $response->message[] = $exception->getMessage();
        }
        return $response;
    }

    public function add(PesertaAddRequest $request): PesertaAddResponse
    {
        $response = new PesertaAddResponse();

        try {
            Database::beginTransaction();
            PesertaRequestValidator::validate($request, $this->pesertaRepository, $this->dusunRepository);
            $peserta = new Peserta();
            $peserta->setId($request->id);
            $peserta->setNik($request->nik);
            $peserta->setNama($request->nama);
            $peserta->setTglLahir($request->tglLahir);
            $peserta->setJenisKelamin($request->jenisKelamin);
            $peserta->setKontak($request->kontak);
            $peserta->setIdDusun($request->idDusun);
            $peserta->setRt($request->rt);
            $peserta->setRw($request->rw);
            $peserta->setDosis($request->dosis);

            $this->pesertaRepository->insert($peserta);
            Database::commitTransaction();

            $response->success = true;
            $response->peserta = $peserta;
            $response->message = "Peserta berhasil ditambahkan";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        }

        return $response;
    }

    public function getPesertaData(string $id): ?Peserta
    {
        return $this->pesertaRepository->findById($id);
    }

    public function getPaginatedPeserta(int $limit, int $offset): PesertaShowResponse
    {
        $response = new PesertaShowResponse();
        try {
            $peserta = $this->pesertaRepository->getPaginatedPeserta($limit, $offset);
            $response->peserta = $peserta;
            $response->success = true;
        } catch (Exception $exception) {
            $response->success = false;
            $response->message = $exception->getMessage();
        }
        return $response;
    }

    public function getTotalPesertaCount(): int
    {
        return $this->pesertaRepository->getTotalPesertaCount();
    }

    public function updatePeserta(PesertaUpdateRequest $request): PesertaUpdateResponse
    {
        $response = new PesertaUpdateResponse();
        try {
            Database::beginTransaction();
            // Validate
            PesertaRequestValidator::validate($request, $this->pesertaRepository, $this->dusunRepository);
            $peserta = $this->pesertaRepository->findById($request->id);
            if (!$peserta) {
                throw new Exception("Peserta tidak ditemukan");
            }

            // Update
            $peserta->setNik($request->nik);
            $peserta->setNama($request->nama);
            $peserta->setTglLahir($request->tglLahir);
            $peserta->setJenisKelamin($request->jenisKelamin);
            $peserta->setKontak($request->kontak);
            $peserta->setIdDusun($request->idDusun);
            $peserta->setRt($request->rt);
            $peserta->setRw($request->rw);
            $peserta->setDosis($request->dosis);
            $this->pesertaRepository->update($peserta);
            Database::commitTransaction();

            $response->peserta = $peserta;
            $response->success = true;
            $response->message = "Data berhasil diubah";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        }
        return $response;
    }

    public function deletePesertaById(string $id): PesertaDeleteResponse
    {
        $response = new PesertaDeleteResponse();
        try {
            Database::beginTransaction();
            $peserta = $this->pesertaRepository->findById($id);
            if (!$peserta) {
                throw new Exception("Peserta tidak ditemukan");
            }
            $this->pesertaRepository->delete($id);
            Database::commitTransaction();

            $response->success = true;
            $response->message = "Peserta berhasil dihapus";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        }
        return $response;
    }

    public function getOverviewStatistics(): array
    {
        return $this->pesertaRepository->getStatistic();
    }

    public function printPesertaData(): void
    {
        $headers = [
            "No",
            "NIK",
            "NAMA",
            "TANGGAL LAHIR",
            "DUSUN",
            "RT",
            "RW",
            "JK",
            "DOSIS",
            "KONTAK"
        ];

        $data = $this->show()->peserta;
        foreach ($data as &$p) {
            $p["nama_dusun"] = $this->dusunRepository->findById($p["id_dusun"])->getNama();
            $date = new DateTime($p["tgl_lahir"]);
            $p["tgl_lahir"] = $date->format("d-m-Y");
        }

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setCellValue([1, 1], "DATA REKAPITULASI VAKSINISASI DI DESA GEREBA");
        $activeWorksheet->mergeCells("A1:J1");
        $activeWorksheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle("A1")->getFont()->setSize(14);

        foreach ($headers as $index => $header) {
            $activeWorksheet->setCellValue([$index + 1, 2], $header);
        }

        $activeWorksheet->getStyle("A1:J2")->getFont()->setBold(true);

        $activeWorksheet->getColumnDimension("A")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("B")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("C")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("D")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("E")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("F")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("G")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("H")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("I")->setAutoSize(true);
        $activeWorksheet->getColumnDimension("J")->setAutoSize(true);

        $i = 0;
        foreach ($data as $peserta) {
            $activeWorksheet->setCellValue([1, $i + 3], $i + 1);
            $activeWorksheet->setCellValueExplicit([2, $i + 3], $peserta["nik"], DataType::TYPE_STRING);
            $activeWorksheet->setCellValue([3, $i + 3], $peserta["nama"]);
            $activeWorksheet->setCellValue([4, $i + 3], $peserta["tgl_lahir"]);
            $activeWorksheet->setCellValue([5, $i + 3], $peserta["nama_dusun"]);
            $activeWorksheet->setCellValue([6, $i + 3], $peserta["rt"]);
            $activeWorksheet->setCellValue([7, $i + 3], $peserta["rw"]);
            $activeWorksheet->setCellValue([8, $i + 3], $peserta["jenis_kelamin"]);
            $activeWorksheet->setCellValue([9, $i + 3], $peserta["dosis"]);
            $activeWorksheet->setCellValue([10, $i + 3], $peserta["kontak"]);
            $i++;
        }

        $range = "A2:J" . sizeof($data) + 2;
        $activeWorksheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color("#000000"));

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Peserta.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }
}
