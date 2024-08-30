<?php

namespace Rusdianto\Gevac\Validators;

use Rusdianto\Gevac\DTO\DusunAddRequest;
use Rusdianto\Gevac\DTO\DusunUpdateRequest;
use Rusdianto\Gevac\Exception\ValidationException;

class DusunAddValidator
{
    public static function validate(DusunAddRequest|DusunUpdateRequest $request): void
    {
        if (empty($request->id) || trim($request->id) === "") {
            throw new ValidationException("Id tidak boleh kosong");
        }

        if (empty($request->nama) || trim($request->nama) === "") {
            throw new ValidationException("Nama tidak boleh kosong");
        }
    }
}
