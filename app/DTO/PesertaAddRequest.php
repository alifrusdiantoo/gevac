<?php

namespace Rusdianto\Gevac\DTO;

class PesertaAddRequest
{
    public ?string $id = null;
    public ?string $nik = null;
    public ?string $nama = null;
    public ?string $tglLahir = null;
    public ?string $jenisKelamin;
    public ?string $kontak = null;
    public ?string $idDusun = null;
    public ?string $rt = null;
    public ?string $rw = null;
    public ?string $dosis = null;
}
