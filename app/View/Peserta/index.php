<main class="row container-fluid m-0 p-0">
    <?php require_once __DIR__ . "/../Component/sidebar.php" ?>

    <section class="col bg-light">
        <?php if (!empty($model["message"]) || !empty($model["error"])) : ?>
            <div class="alert <?= !empty($model["message"]) ? "alert-success" : "alert-danger" ?> alert-dismissible fade show" role="alert">
                <?= !empty($model["message"]) ? $model["message"] : $model["error"] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <div class="container-fluid p-0 d-flex gap-3">
            <div class="card p-4 w-100">
                <p class="fs-6 mb-4"><b>Data Peserta</b></p>
                <div class="d-flex-inline mb-3">
                    <a class="btn btn-sm btn-primary" href="/peserta/add" role="button"><i class="bi bi-plus"></i> Tambah</a>
                    <a class="btn btn-sm btn-success" href="/peserta/print" role="button"><i class="bi bi-printer"></i> Print Data</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped fs-sm">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Dosis</th>
                                <th scope="col">Kontak</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($model["peserta"] as $peserta) : ?>
                                <tr class="text-center">
                                    <th><?= $i++ ?></th>
                                    <td><?= $peserta["nik"] ?></td>
                                    <td class="text-start"><?= $peserta["nama"] ?></td>
                                    <td><?= $peserta["tgl_lahir"]; ?></td>
                                    <td><?= $peserta["nama_dusun"] ?> RT <?= $peserta["rt"] ?>/RW <?= $peserta["rw"] ?></td>
                                    <td><?= $peserta["jenis_kelamin"] ?></td>
                                    <td><?= $peserta["dosis"] ?></td>
                                    <td><?= $peserta["kontak"] ?></td>
                                    <td>
                                        <a href="/peserta/edit/<?= $peserta['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-dark" onclick="openDeleteModal('<?= $peserta['id'] ?>', 'peserta')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="pagination data peserta vaksin" class="d-flex justify-content-end">
                    <ul class="pagination pagination-sm">
                        <li class="page-item <?= $model["currentPage"] == 1 ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= $model["currentPage"] - 1 ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $model["totalPages"]; $i++): ?>
                            <li class="page-item <?= $i == $model["currentPage"] ? "active" : "" ?>" aria-current="page">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $model["currentPage"] == $model["totalPages"] ? "disabled" : "" ?>">
                            <a class="page-link" href="?page=<?= $model["currentPage"] + 1 ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . "/../Component/delete.php" ?>