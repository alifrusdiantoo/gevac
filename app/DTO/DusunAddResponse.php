<?php

namespace Rusdianto\Gevac\DTO;

use Rusdianto\Gevac\Domain\Dusun;

class DusunAddResponse
{
    public Dusun $dusun;
    public bool $success = false;
    public string $message = "";
    public array $errors = [];
}
