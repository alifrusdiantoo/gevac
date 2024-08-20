<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rusdianto\Gevac\App\Router;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Controller\UserController;
use Rusdianto\Gevac\Controller\PesertaController;
use Rusdianto\Gevac\Middleware\MustLoginMiddleware;
use Rusdianto\Gevac\Middleware\MustNotLoginMiddleware;

Database::getConnection("prod");

// Home controller

// Peserta controller
Router::add("GET", "/peserta", PesertaController::class, "index", [MustLoginMiddleware::class]);

// User controller
Router::add("GET", "/", UserController::class, "login", [MustNotLoginMiddleware::class]);
Router::add("POST", "/", UserController::class, "postLogin", [MustNotLoginMiddleware::class]);
Router::add("GET", "/logout", UserController::class, "logout", [MustLoginMiddleware::class]);
Router::add("GET", "/users", UserController::class, "index", [MustLoginMiddleware::class]);
Router::add("GET", "/users/register", UserController::class, "register", [MustLoginMiddleware::class]);
Router::add("POST", "/users/register", UserController::class, "postRegister", [MustLoginMiddleware::class]);
Router::add("POST", "/users/{id}", UserController::class, "delete", [MustLoginMiddleware::class]);
Router::add("GET", "/users/edit/{id}", UserController::class, "updateProfile", [MustLoginMiddleware::class]);
Router::add("POST", "/users/edit/{id}", UserController::class, "postUpdateProfile", [MustLoginMiddleware::class]);
Router::add("GET", "/users/password/{id}", UserController::class, "updatePassword", [MustLoginMiddleware::class]);
Router::add("POST", "/users/password/{id}", UserController::class, "postUpdatePassword", [MustLoginMiddleware::class]);

Router::run();
