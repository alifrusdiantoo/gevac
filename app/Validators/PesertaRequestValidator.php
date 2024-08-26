<?php

namespace Rusdianto\Gevac\Validators;

use DateTime;
use Rusdianto\Gevac\DTO\PesertaAddRequest;
use Rusdianto\Gevac\DTO\PesertaUpdateRequest;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Repository\PesertaRepository;

class PesertaRequestValidator
{
    public static function validate(PesertaAddRequest|PesertaUpdateRequest $request, PesertaRepository $pesertaRepository, DusunRepository $dusunRepository): void
    {
        // Validate ID
        if (empty($request->id) || trim($request->id) === "") {
            throw new ValidationException("Id tidak boleh kosong");
        }

        $pesertaWithSameId = $pesertaRepository->findById($request->id);
        if ($pesertaWithSameId && $request instanceof PesertaAddRequest) {
            throw new ValidationException("Id sudah digunakan");
        }

        // Validate NIK
        if (empty($request->nik) || trim($request->nik) === "") {
            throw new ValidationException("NIK tidak boleh kosong");
        }

        if (strlen($request->nik) > 16) {
            throw new ValidationException("Panjang NIK tidak sesuai format");
        }

        if (!ctype_digit($request->nik)) {
            throw new ValidationException("Format NIK tidak sesuai. Terdapat karakter bukan angka");
        }

        // Validate tanggal lahir
        if (empty($request->tglLahir) || trim($request->tglLahir) === "") {
            throw new ValidationException("Tanggal lahir tidak boleh kosong");
        }

        $tglLahir = new DateTime(date("Y-m-d", strtotime($request->tglLahir)));
        $current = new DateTime();
        $age = $current->diff($tglLahir)->y;

        if ($age < 6) {
            throw new ValidationException("Umur tidak mencukupi");
        }

        // Validate nama
        if (empty($request->nama) || trim($request->nama) === "") {
            throw new ValidationException("Nama tidak boleh kosong");
        }

        // Validate jenis kelamin
        if (empty($request->jenisKelamin) || trim($request->jenisKelamin) === "") {
            throw new ValidationException("Jenis kelamin tidak boleh kosong");
        }

        if ($request->jenisKelamin != "L" && $request->jenisKelamin != "P") {
            throw new ValidationException("Jenis kelamin tidak sesuai");
        }

        // Validate dusun
        if (empty($request->idDusun) || trim($request->idDusun) === "") {
            throw new ValidationException("Dusun tidak boleh kosong");
        }

        $dusun = $dusunRepository->findById($request->idDusun);
        if (!$dusun) {
            throw new ValidationException("Dusun tidak terdaftar");
        }

        // Validate RT
        if (empty($request->rt) || trim($request->rt) === "") {
            throw new ValidationException("RT tidak boleh kosong");
        }

        if (strlen($request->rt) < 3 || strlen($request->rt) > 3) {
            throw new ValidationException("Format RT tidak sesuai");
        }

        // Validate RW
        if (empty($request->rw) || trim($request->rw) === "") {
            throw new ValidationException("RW tidak boleh kosong");
        }

        if (strlen($request->rw) < 3 || strlen($request->rw) > 3) {
            throw new ValidationException("Format RW tidak sesuai");
        }

        // Validate Kontak
        if (empty($request->kontak) || trim($request->kontak) === "") {
            throw new ValidationException("Kontak tidak boleh kosong");
        }

        if (strlen($request->kontak) > 13) {
            throw new ValidationException("Kontak tidak boleh melebihi 13 digit");
        }

        // Validate dosis vaksin
        if (empty($request->dosis) || trim($request->dosis) === "") {
            throw new ValidationException("Dosis tidak boleh kosong");
        }

        if ($request->dosis > 3 || $request->dosis < 1) {
            throw new ValidationException("Dosis tidak/belum tersedia");
        }

        $pesertaWithSameNik = $pesertaRepository->findByNik($request->nik);
        if ($pesertaWithSameNik && $request instanceof PesertaAddRequest) {
            if ($pesertaWithSameNik->getDosis() == $request->dosis) {
                throw new ValidationException("Peserta telah terdaftar dengan dosis yang sama");
            }
        }
    }
}
