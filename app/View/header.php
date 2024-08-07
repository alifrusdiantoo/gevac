<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $model["title"] ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">GEVAC</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">John Doe</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="row container-fluid m-0 p-0">
        <aside class="col-sm-2 shadow-sm p-0">
            <ul class="nav flex-column gap-2">
                <li class="nav-item d-flex align-items-center px-3 active">
                    <i class="bi bi-speedometer2"></i>
                    <a class="nav-link text-reset" href="#">Dashboard</a>
                </li>
                <li class="nav-item d-flex align-items-center px-3">
                    <i class="bi bi-person"></i>
                    <a class="nav-link text-reset" href="#">Profile</a>
                </li>
                <li class="nav-item px-3">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    <i class="bi bi-file-text"></i>
                                    <a class="nav-link text-reset" href="#">Data</a>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body d-flex flex-column px-3 py-0">
                                    <a href="" class="nav-link text-reset">Dusun</a>
                                    <a href="" class="nav-link text-reset">Admin</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-flex align-items-center px-3">
                    <i class="bi bi-door-open"></i>
                    <a class="nav-link text-reset" href="#">Sign Out</a>
                </li>
            </ul>
        </aside>

        <section class="col bg-light">
            <div class="container-fluid p-0 d-flex gap-3">