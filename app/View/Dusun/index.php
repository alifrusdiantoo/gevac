<main class="row container-fluid m-0 p-0">
    <?php require __DIR__ . "/../Component/sidebar.php" ?>

    <section class="col bg-light">
        <div class="container-fluid p-0">
            <?php if (!empty($model["message"]) || !empty($model["error"])) : ?>
                <div class="alert <?= !empty($model["message"]) ? "alert-success" : "alert-danger" ?> alert-dismissible fade show" role="alert">
                    <?= !empty($model["message"]) ? $model["message"] : $model["error"] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <div class="card p-4">
                <p class="fs-6 mb-4"><b>Data Dusun</b></p>
                <div class="d-flex-inline mb-3">
                    <button class="btn btn-sm btn-primary" onclick="openAddModal('dusun')"><i class="bi bi-plus"></i>Tambah</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped fs-sm">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 10%">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($model["dusun"] as $dusun) :
                            ?>
                                <tr class="text-center">
                                    <th><?= $i++ ?></th>
                                    <td><?= $dusun["nama"] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="openEditModal('<?= $dusun['id'] ?>', '<?= $dusun['nama'] ?>', 'dusun')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-dark" onclick="openDeleteModal('<?= $dusun['id'] ?>', 'dusun')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . "/../Component/add.php" ?>
<?php require __DIR__ . "/../Component/update.php" ?>
<?php require __DIR__ . "/../Component/delete.php" ?>