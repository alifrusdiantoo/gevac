<?php

namespace Rusdianto\Gevac\Middleware;

interface Middleware
{
    public function before(): void;
}
