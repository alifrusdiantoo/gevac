<?php

namespace Rusdianto\Gevac\Domain;

class Dusun
{
    private string $id;
    private string $nama;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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
}
