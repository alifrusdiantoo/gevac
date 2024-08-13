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
        <div class="container-fluid p-0">
            <?php if (!empty($model['message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $model['message']; ?>
                </div>
            <?php } ?>
            <div class="card p-4">
                <p class="fs-6 mb-4"><b>Ubah Password</b></p>
                <form action="/users/password/<?= $model["user"]["id"] ?>" method="post">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID User</label>
                        <input type="text" class="form-control bg-light" id="id" name="id" value="<?= $model["user"]["id"] ?? "" ?>" readonly>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <label for="oldPassword" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="*********" minlength="8" required />
                            <span class="form-text">Minimal 8 karakter</span>
                        </div>

                        <div class="col">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="*********" minlength="8" required />
                            <span class="form-text">Minimal 8 karakter</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </section>
</main>