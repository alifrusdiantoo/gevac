<?php

use Rusdianto\Gevac\App\Router;
use Rusdianto\Gevac\Controller\PesertaController;

require_once __DIR__ . "/../vendor/autoload.php";

// Peserta Controller
Router::add("GET", "/peserta", PesertaController::class, "index", []);

Router::run();
