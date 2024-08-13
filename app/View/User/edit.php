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
                <p class="fs-6 mb-4"><b>Ubah Profil</b></p>
                <form action="/users/edit/<?= $model["user"]["id"] ?>" method="post">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID User</label>
                        <input type="text" class="form-control bg-light" id="id" name="id" value="<?= $model["user"]["id"] ?? "" ?>" readonly>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $_POST["username"] ?? $model["user"]["username"] ?>" placeholder="johndowe" pattern="^[a-zA-Z0-9_.]{3,20}$" required />
                            <span class="form-text">3 hingga 20 karakter dari huruf, angka, titik atau underscore</span>
                        </div>

                        <div class="col">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="John Doe" value="<?= $_POST["nama"] ?? $model["user"]["nama"] ?>" required />
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Select Role" name="roles">
                            <option value="admin" selected>Admin</option>
                            <option value="sup-admin">Super Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                    <a href="/users/password/<?= $model["user"]["id"] ?>" class="btn btn-sm btn-secondary ">Ubah Password</a>
                </form>
            </div>
        </div>
    </section>
</main>