<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Rusdianto\Gevac\App\Router;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Controller\DusunController;
use Rusdianto\Gevac\Controller\OverviewController;
use Rusdianto\Gevac\Controller\UserController;
use Rusdianto\Gevac\Controller\PesertaController;
use Rusdianto\Gevac\Middleware\MustLoginMiddleware;
use Rusdianto\Gevac\Middleware\MustNotLoginMiddleware;
use Rusdianto\Gevac\Middleware\SupAdminOnlyMiddleware;

Database::getConnection("prod");

// Overview controller
Router::add("GET", "/overview", OverviewController::class, "index", [MustLoginMiddleware::class]);

// Peserta controller
Router::add("GET", "/peserta", PesertaController::class, "index", [MustLoginMiddleware::class]);

// Dusun controller
Router::add("GET", "/dusun", DusunController::class, "index", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/dusun/add", DusunController::class, "add", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/dusun/{id}", DusunController::class, "delete", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/dusun/edit/{id}", DusunController::class, "update", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);

// User controller
Router::add("GET", "/", UserController::class, "login", [MustNotLoginMiddleware::class]);
Router::add("POST", "/", UserController::class, "postLogin", [MustNotLoginMiddleware::class]);
Router::add("GET", "/logout", UserController::class, "logout", [MustLoginMiddleware::class]);
Router::add("GET", "/users", UserController::class, "index", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("GET", "/users/register", UserController::class, "register", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/users/register", UserController::class, "postRegister", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/users/{id}", UserController::class, "delete", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("GET", "/users/edit/{id}", UserController::class, "updateProfile", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/users/edit/{id}", UserController::class, "postUpdateProfile", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("GET", "/users/password/{id}", UserController::class, "updatePassword", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);
Router::add("POST", "/users/password/{id}", UserController::class, "postUpdatePassword", [MustLoginMiddleware::class, SupAdminOnlyMiddleware::class]);

Router::run();
