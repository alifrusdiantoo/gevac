<main class="row container-fluid m-0 p-0">
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