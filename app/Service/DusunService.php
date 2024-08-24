<?php

namespace Rusdianto\Gevac\Service;

use Exception;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\Dusun;
use Rusdianto\Gevac\DTO\DusunAddRequest;
use Rusdianto\Gevac\DTO\DusunAddResponse;
use Rusdianto\Gevac\DTO\DusunShowResponse;
use Rusdianto\Gevac\DTO\DusunDeleteResponse;
use Rusdianto\Gevac\DTO\DusunUpdateRequest;
use Rusdianto\Gevac\DTO\DusunUpdateResponse;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Validators\DusunAddValidator;
use Rusdianto\Gevac\Exception\ValidationException;

class DusunService
{
    private DusunRepository $dusunRepository;

    public function __construct(DusunRepository $dusunRepository)
    {
        $this->dusunRepository = $dusunRepository;
    }

    public function show(): DusunShowResponse
    {
        $response = new DusunShowResponse();
        try {
            $dusun = $this->dusunRepository->show();
            $response->dusun = $dusun;
            $response->success = true;
        } catch (Exception $exception) {
            $response->success = false;
            $response->message = $exception->getMessage();
        }
        return $response;
    }

    public function add(DusunAddRequest $request): DusunAddResponse
    {
        $response = new DusunAddResponse();

        try {
            // Validate request
            DusunAddValidator::validate($request);
            $dusun = new Dusun();
            $dusun->setId($request->id);
            $dusun->setNama($request->nama);

            $this->dusunRepository->insert($dusun);

            $response->success = true;
            $response->dusun = $dusun;
            $response->message = "Dusun berhasil ditambahkan";
        } catch (ValidationException $exception) {
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            $response->errors[] = $exception->getMessage();
        }

        return $response;
    }

    public function deleteDusunById(string $id): DusunDeleteResponse
    {
        $response = new DusunDeleteResponse();
        try {
            Database::beginTransaction();
            $dusun = $this->dusunRepository->findById($id);
            if (!$dusun) {
                throw new Exception("Dusun tidak ditemukan");
            }
            $this->dusunRepository->delete($id);
            Database::commitTransaction();

            $response->success = true;
            $response->message = "Dusun berhasil dihapus";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        }
        return $response;
    }

    public function updateDusun(DusunUpdateRequest $request): DusunUpdateResponse
    {
        $response = new DusunUpdateResponse();
        try {
            Database::beginTransaction();
            // Validate request
            DusunAddValidator::validate($request);
            $dusun = $this->dusunRepository->findById($request->id);
            if (!$dusun) {
                throw new Exception("Dusun tidak ditemukan");
            }
            $dusun->setNama($request->nama);
            $this->dusunRepository->update($dusun);
            Database::commitTransaction();

            $response->success = true;
            $response->message = "Dusun berhasil dihapus";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
        }
        return $response;
    }
}
