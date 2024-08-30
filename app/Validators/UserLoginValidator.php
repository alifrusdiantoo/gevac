<?php

namespace Rusdianto\Gevac\Validators;

use Rusdianto\Gevac\DTO\UserLoginRequest;
use Rusdianto\Gevac\DTO\UserLoginResponse;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Repository\UserRepository;

class UserLoginValidator
{
    public static function validate(UserLoginRequest $request): void
    {
        if (empty($request->username) || trim($request->username) === "") {
            throw new ValidationException("Id tidak boleh kosong");
        }

        if (empty($request->password) || trim($request->password) === "") {
            throw new ValidationException("Id tidak boleh kosong");
        }
    }

    public static function match(UserRepository $userRepository, UserLoginRequest $request): ?UserLoginResponse
    {
        $user = $userRepository->findByUsername($request->username);
        if ($user == null) {
            throw new ValidationException("Username atau password salah");
        }

        if (password_verify($request->password, $user->getPassword())) {
            $response = new UserLoginResponse();
            $response->user = $user;
            $response->success = true;
            $response->message[] = "Berhasil login";
            return $response;
        } else {
            throw new ValidationException("Username atau password salah");
        }
    }
}
