<?php

namespace Rusdianto\Gevac\DTO;

class UserDeleteResponse
{
    public function __construct(public bool $success = false,  public array $message = [], public array $errors = [])
    {
        // 
    }
}
