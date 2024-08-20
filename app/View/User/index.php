<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">GEVAC</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Halo, <b><?= $model["user"]["name"] ?></b></span>
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
                <a class="nav-link text-reset" href="/logout">Sign Out</a>
            </li>
        </ul>
    </aside>

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
                                            <button class="btn btn-sm btn-dark" onclick="openDeleteModal('<?= $user['id'] ?>')">
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

<!-- Modal -->
<div class="modal modal-sm fade" id="deleteDataModal" tabindex="-1" aria-labelledby="delete-data-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-content-between">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" onclick="closeModal('deleteDataModal')" aria-label="Close"></button>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center text-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                        <path
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                    <span>Data yang dihapus tidak dapat dipulihkan kembali. Lanjutkan hapus data?</span>
                    <small class="fw-light text-secondary">Id: <span id="idData"></span></small>
                </div>
                <form action="" method="post" id="deleteDataForm" class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary flex-fill" onclick="closeModal('deleteDataModal')">Batal</button>
                    <button type="submit" class="btn btn-danger flex-fill">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>