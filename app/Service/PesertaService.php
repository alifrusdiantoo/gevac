<?php

namespace Rusdianto\Gevac\Service;

use Exception;
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
}
