<?php

namespace Rusdianto\Gevac\DTO;

class PesertaShowResponse
{
    public array $peserta = [];
    public bool $success = false;
    public string $message = "";
    public array $errors = [];
}
