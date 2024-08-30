<?php

namespace Rusdianto\Gevac\Validators;

use Rusdianto\Gevac\DTO\UserProfileUpdateRequest;
use Rusdianto\Gevac\Repository\UserRepository;

class UserUpdateProfileValidator
{
    public static function validate(UserProfileUpdateRequest $request, UserRepository $userRepository): array
    {
        $errors = [];

        // Validate username
        $user = $userRepository->findDuplicateUsername($request->username, $request->id);
        if (empty($request->username) || trim($request->username) === "") {
            $errors["username"] = "Username tidak boleh kosong";
        } elseif (!preg_match('/^[a-zA-Z0-9_.]{3,20}$/', $request->username)) {
            $errors["username"] = "Username harus terdiri dari 3-20 karakter dari huruf, nomor, dan garis bawah";
        } elseif ($user !== null) {
            $errors["username"] = "Username sudah digunakan";
        }

        // Validate nama
        if (empty($request->nama) || trim($request->nama) === "") {
            $errors["nama"] = "Nama tidak boleh kosong";
        }

        // Validate roles
        if (empty($request->roles) || trim($request->roles) === "") {
            $errors["roles"] = "Roles tidak boleh kosong";
        } elseif ($request->roles != "admin" && $request->roles != "sup-admin") {
            $errors["roles"] = "Roles yang dipilih tidak sesuai $request->roles";
        }

        return $errors;
    }
}
