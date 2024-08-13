<?php

namespace Rusdianto\Gevac\Controller;

use Rusdianto\Gevac\App\View;

class HomeController
{
    public function index(): void
    {
        View::render("Home/index", [
            "title" => "Gevac | Login"
        ]);
    }
}
