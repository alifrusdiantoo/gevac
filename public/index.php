<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rusdianto\Gevac\App\Router;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Controller\HomeController;
use Rusdianto\Gevac\Controller\PesertaController;
use Rusdianto\Gevac\Controller\UserController;

Database::getConnection("prod");

// Home controller
Router::add("GET", "/", HomeController::class, "index", []);

// Peserta controller
Router::add("GET", "/peserta", PesertaController::class, "index", []);

// User controller
Router::add("GET", "/users", UserController::class, "index", []);
Router::add("GET", "/users/register", UserController::class, "register", []);
Router::add("POST", "/users/register", UserController::class, "postRegister", []);
Router::add("POST", "/users/{id}", UserController::class, "delete", []);
Router::add("GET", "/users/edit/{id}", UserController::class, "updateProfile", []);
Router::add("POST", "/users/edit/{id}", UserController::class, "postUpdateProfile", []);
Router::add("GET", "/users/password/{id}", UserController::class, "updatePassword", []);
Router::add("POST", "/users/password/{id}", UserController::class, "postUpdatePassword", []);

Router::run();
