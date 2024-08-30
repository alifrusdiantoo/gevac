<?php

namespace Rusdianto\Gevac\Validators;

use Rusdianto\Gevac\DTO\UserRegisterRequest;
use Rusdianto\Gevac\Repository\UserRepository;

class UserRegisterValidator
{
    public static function validate(UserRegisterRequest $request, UserRepository $userRepository): array
    {
        $errors = [];

        // Validate id
        $userWithDuplicateId = $userRepository->findById($request->id);
        if ($userWithDuplicateId !== null) {
            $errors["username"] = "Id sudah digunakan";
        } elseif (empty($request->id) || trim($request->id) === "") {
            $errors["username"] = "Id tidak boleh kosong";
        }

        // Validate username
        $userWithDuplicateUsername = $userRepository->findDuplicateUsername($request->username, $request->id);
        if (empty($request->username) || trim($request->username) === "") {
            $errors["username"] = "Username tidak boleh kosong";
        } elseif (!preg_match('/^[a-zA-Z0-9_.]{3,20}$/', $request->username)) {
            $errors["username"] = "Username harus terdiri dari 3-20 karakter dari huruf, nomor, dan garis bawah";
        } elseif ($userWithDuplicateUsername !== null) {
            $errors["username"] = "Username sudah digunakan";
        }

        // Validate password
        if (empty($request->password) || trim($request->password) === "") {
            $errors["password"] = "Password tidak boleh kosong";
        } elseif (strlen($request->password) < 8) {
            $errors["passwrod"] = "Password harus terdiri dari minimal 8 karakter";
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
