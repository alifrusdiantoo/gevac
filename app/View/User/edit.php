<main class="row container-fluid m-0 p-0">
    <?php require_once __DIR__ . "/../Component/sidebar.php" ?>

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