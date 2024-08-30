<?php

namespace Rusdianto\Gevac\DTO;

use Rusdianto\Gevac\Domain\User;

class UserPasswordUpdateResponse
{
    public User $user;
    public bool $success = false;
    public array $message = [];
    public array $errors = [];
}
