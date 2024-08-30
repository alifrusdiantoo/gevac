<?php

namespace Rusdianto\Gevac\Controller;

use Rusdianto\Gevac\App\View;
use Rusdianto\Gevac\Config\Database;
use Rusdianto\Gevac\Helper\Helper;
use Rusdianto\Gevac\Repository\DusunRepository;
use Rusdianto\Gevac\Repository\PesertaRepository;
use Rusdianto\Gevac\Service\SessionService;
use Rusdianto\Gevac\Repository\UserRepository;
use Rusdianto\Gevac\Repository\SessionRepository;
use Rusdianto\Gevac\Service\PesertaService;

class OverviewController
{
    private PesertaService $pesertaService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pesertaRepository = new PesertaRepository($connection);
        $dusunRepository = new DusunRepository($connection);
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);

        $this->pesertaService = new PesertaService($pesertaRepository, $dusunRepository);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(string $message = "", string $error = ""): void
    {
        $statistics = $this->pesertaService->getOverviewStatistics();
        $data = Helper::prepareViewData($this->sessionService, [
            "title" => "Gevac | Overview",
            "statistics" => $statistics,
            "message" => $message,
            "error" => $error
        ]);
        View::render("Overview/index", $data);
    }
}
