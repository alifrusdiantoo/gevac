<?php

namespace Rusdianto\Gevac\Domain;

enum Role: string
{
    case ADMIN = "admin";
    case SUPADMIN = "sup-admin";
}

class User
{
    private string $id;
    private string $username;
    private string $password;
    private string $nama;
    private Role $roles;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setNama($nama): void
    {
        $this->nama = $nama;
    }

    public function getRoles(): Role
    {
        return $this->roles;
    }

    public function setRoles($roles): void
    {
        $this->roles = Role::from($roles);
    }
}
