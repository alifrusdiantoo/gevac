<?php

namespace Rusdianto\Gevac\Controller;

use Rusdianto\Gevac\App\View;

class PesertaController
{
    public function index(): void
    {
        View::render('Peserta/index', [
            "title" => "Gevac | Data Peserta"
        ]);
    }
}
