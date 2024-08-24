<main class="row container-fluid m-0 p-0">
    <?php require __DIR__ . "/../Component/sidebar.php" ?>

    <section class="col bg-light">
        <div class="container-fluid p-0">
            <?php
            if (!empty($model["message"]) || !empty($model["error"])) : ?>
                <div class="alert <?= !empty($model["message"]) ? "alert-success" : "alert-danger" ?> alert-dismissible fade show" role="alert">
                    <?= !empty($model["message"]) ? $model["message"] : $model["error"] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <div class="card p-4">
                <p class="fs-6 mb-4"><b>Data User</b></p>
                <div class="d-flex-inline mb-3">
                    <a class="btn btn-sm btn-primary" href="/users/register" role="button"><i class="bi bi-plus"></i>Tambah</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped fs-sm">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$model['users']) : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum terdapat pengguna untuk ditampilkan</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($model['users'] as $user) : ?>
                                    <tr class="text-center">
                                        <td style="width: 25%;"><?= $user['id'] ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['nama'] ?></td>
                                        <td><span class="badge text-bg-success"><?= $user['roles'] ?></span></td>
                                        <td>
                                            <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-dark" onclick="openDeleteModal('<?= $user['id'] ?>', 'users')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <!-- <nav aria-label="pagination data peserta vaksin" class="d-flex justify-content-end">
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav> -->
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . "/../Component/delete.php" ?>