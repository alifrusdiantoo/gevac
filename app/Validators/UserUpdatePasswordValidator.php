<?php

namespace Rusdianto\Gevac\Validators;

use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\DTO\UserPasswordUpdateRequest;
use Rusdianto\Gevac\Exception\ValidationException;

class UserUpdatePasswordValidator
{
    public static function validate(UserPasswordUpdateRequest $request, ?User $user)
    {
        if (empty($request->id) || trim($request->id) === "") {
            throw new ValidationException("Id tidak boleh kosong");
        }

        if (empty($request->oldPassword) || trim($request->oldPassword) === "") {
            throw new ValidationException("Password lama tidak boleh kosong");
        }

        if (empty($request->newPassword) || trim($request->newPassword) === "") {
            throw new ValidationException("Password baru tidak boleh kosong");
        }

        if (!password_verify($request->oldPassword, $user->getPassword())) {
            throw new ValidationException("Password lama tidak sesuai");
        }
    }
}
