<?php

namespace Rusdianto\Gevac\DTO;

class UserShowResponse
{
    public function __construct(public array $users = [], public bool $success = false,  public array $message = [], public array $errors = [])
    {
        // 
    }
}
