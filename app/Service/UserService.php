<?php

namespace Rusdianto\Gevac\Service;

use Exception;
use Ramsey\Uuid\Nonstandard\Uuid;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Domain\User;
use Rusdianto\Gevac\DTO\UserDeleteResponse;
use Rusdianto\Gevac\DTO\UserPasswordUpdateRequest;
use Rusdianto\Gevac\DTO\UserPasswordUpdateResponse;
use Rusdianto\Gevac\DTO\UserProfileUpdateRequest;
use Rusdianto\Gevac\DTO\UserProfileUpdateResponse;
use Rusdianto\Gevac\DTO\UserRegisterRequest;
use Rusdianto\Gevac\DTO\UserRegisterResponse;
use Rusdianto\Gevac\DTO\UserShowResponse;
use Rusdianto\Gevac\Exception\ValidationException;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Validators\UserRegisterValidator;
use Rusdianto\Gevac\Validators\UserUpdatePasswordValidator;
use Rusdianto\Gevac\Validators\UserUpdateProfileValidator;

class UserService
{
    public function __construct(public UserRepository $userRepository)
    {
        //...
    }

    public function show(): UserShowResponse
    {
        $response = new UserShowResponse();
        try {
            $users = $this->userRepository->findAll();

            $response->users = $users;
            $response->success = true;
        } catch (Exception $exception) {
            $response->success = false;
            $response->errors[] = $exception->getMessage();
        }

        return $response;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $response = new UserRegisterResponse();

        $errors = UserRegisterValidator::validate($request, $this->userRepository);
        if (!empty($errors)) {
            // Return response with errors
            $response = new UserRegisterResponse();
            $response->success = false;
            $response->errors = $errors;
            $errorMessage = implode("; ", $response->errors);

            throw new ValidationException($errorMessage);
        }

        try {
            Database::beginTransaction();

            $user = new User();
            $user->setId($request->id);
            $user->setUsername($request->username);
            $user->setPassword(password_hash($request->password, PASSWORD_BCRYPT));
            $user->setNama($request->nama);
            $user->setRoles($request->roles);

            $this->userRepository->insert($user);

            $response->success = true;
            $response->user = $user;
            $response->message[] = "User berhasil ditambahkan";

            Database::commitTransaction();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
            $response->message[] = "Terjadi kesalahan selama proses hapus data";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
            $response->message[] = "Validasi error";
        }

        return $response;
    }

    public function deleteUserById(string $id): UserDeleteResponse
    {
        $response = new UserDeleteResponse();
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                throw new Exception("User tidak ditemukan");
            }

            $this->userRepository->delete($id);
            $response->success = true;
            $response->message[] = "User berhasil dihapus";
        } catch (ValidationException $exception) {
            $response->errors[] = $exception->getMessage();
            $response->message[] = "Validasi error";
        } catch (Exception $exception) {
            $response->message[] = $exception->getMessage();
        }

        return $response;
    }

    public function getProfile(string $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse
    {
        $response = new UserProfileUpdateResponse();

        $errors = UserUpdateProfileValidator::validate($request, $this->userRepository);
        if (!empty($errors)) {
            // Return response with errors
            $response->success = false;
            $response->errors = $errors;
            $errorMessage = implode("; ", $response->errors);

            throw new ValidationException($errorMessage);
        }

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user == null) {
                throw new ValidationException("User tidak ditemukan");
            }

            $user->setUsername($request->username);
            $user->setNama($request->nama);
            $user->setRoles($request->roles);
            $this->userRepository->update($user);
            Database::commitTransaction();

            $response->user = $user;
            $response->message[] = "Data Berhasil diubah";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            $response->message[] = $exception->getMessage();
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
            $response->message[] = "Terjadi kesalahan selama proses ubah data";
        }

        return $response;
    }

    public function updatePassword(UserPasswordUpdateRequest $request): UserPasswordUpdateResponse
    {
        $response = new UserPasswordUpdateResponse();
        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user === null) {
                throw new ValidationException("User tidak ditemukan");
            }

            if (!password_verify($request->oldPassword, $user->getPassword())) {
                throw new ValidationException("Password lama tidak sesuai");
            }

            $user->setPassword(password_hash($request->newPassword, PASSWORD_BCRYPT));
            $this->userRepository->update($user);
            Database::commitTransaction();

            $response->user = $user;
            $response->message[] = "Password Berhasil diubah";
        } catch (ValidationException $exception) {
            Database::rollbackTransaction();
            throw $exception;
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            $response->errors[] = $exception->getMessage();
            $response->message[] = "Terjadi kesalahan selama proses ubah data";
        }

        return $response;
    }
}
