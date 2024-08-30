<?php

namespace Rusdianto\Gevac\Domain;

enum JenisKelamin: string
{
    case LAKI = "L";
    case PEREMPUAN = "P";
}

class Peserta
{
    private string $id;
    private string $nik;
    private string $nama;
    private string $tglLahir;
    private JenisKelamin $jenisKelamin;
    private string $kontak;
    private string $idDusun;
    private string $rt;
    private string $rw;
    private string $dosis;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getNik()
    {
        return $this->nik;
    }

    public function setNik($nik)
    {
        $this->nik = $nik;

        return $this;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    public function getTglLahir()
    {
        return $this->tglLahir;
    }

    public function setTglLahir($tglLahir)
    {
        $this->tglLahir = $tglLahir;

        return $this;
    }

    public function getJenisKelamin()
    {
        return $this->jenisKelamin->value;
    }

    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = JenisKelamin::from($jenisKelamin);

        return $this;
    }

    public function getKontak()
    {
        return $this->kontak;
    }

    public function setKontak($kontak)
    {
        $this->kontak = $kontak;

        return $this;
    }

    public function getIdDusun()
    {
        return $this->idDusun;
    }

    public function setIdDusun($idDusun)
    {
        $this->idDusun = $idDusun;

        return $this;
    }

    public function getRt()
    {
        return $this->rt;
    }

    public function setRt($rt)
    {
        $this->rt = $rt;

        return $this;
    }

    public function getRw()
    {
        return $this->rw;
    }

    public function setRw($rw)
    {
        $this->rw = $rw;

        return $this;
    }

    public function getDosis()
    {
        return $this->dosis;
    }

    public function setDosis($dosis)
    {
        $this->dosis = $dosis;

        return $this;
    }
}
