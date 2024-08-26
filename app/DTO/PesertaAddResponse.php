<?php

namespace Rusdianto\Gevac\DTO;

use Rusdianto\Gevac\Domain\Peserta;

class PesertaAddResponse
{
    public Peserta $peserta;
    public bool $success = false;
    public string $message = "";
    public array $errors = [];
}
