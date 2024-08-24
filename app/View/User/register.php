<main class="row container-fluid m-0 p-0">
    <?php require_once __DIR__ . "/../Component/sidebar.php" ?>

    <section class="col bg-light">
        <div class="container-fluid p-0">
            <?php if (!empty($model['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $model['error']; ?>
                </div>
            <?php } ?>
            <div class="card p-4">
                <p class="fs-6 mb-4"><b>Tambah Admin</b></p>
                <form action="/users/register" method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="John Doe" value="<?= $_POST["nama"] ?? "" ?>" required />
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $_POST["username"] ?? "" ?>" placeholder="johndowe" pattern="^[a-zA-Z0-9_.]{3,20}$" required />
                            <span class="form-text">3 hingga 20 karakter dari huruf, angka, titik atau underscore</span>
                        </div>

                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="*********" minlength="8" required />
                            <span class="form-text">Minimal 8 karakter</span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Select Role" name="roles">
                            <option value="admin" selected>Admin</option>
                            <option value="sup-admin">Super Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</main>