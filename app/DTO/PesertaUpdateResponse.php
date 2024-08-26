<?php

namespace Rusdianto\Gevac\DTO;

use Rusdianto\Gevac\Domain\Peserta;

class PesertaUpdateResponse
{
    public Peserta $peserta;
    public bool $success = false;
    public string $message = "";
    public array $errors = [];
}
