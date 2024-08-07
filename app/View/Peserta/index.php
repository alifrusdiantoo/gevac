<div class="card p-4 w-100">
    <p class="fs-6 mb-4"><b>Data Peserta</b></p>
    <div class="d-flex-inline mb-3">
        <a class="btn btn-sm btn-primary" href="#" role="button"><i class="bi bi-plus"></i>Tambah</a>
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
                <tr class="text-center">
                    <th>1</th>
                    <td>3207116504630001</td>
                    <td>Ayi</td>
                    <td>25-04-1963</td>
                    <td>Nanggerang RT 04/RW 04</td>
                    <td>P</td>
                    <td>2</td>
                    <td>089605352842</td>
                    <td>
                        <a href="" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-dark" onclick="openDeleteModal('1')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <nav aria-label="pagination data peserta vaksin" class="d-flex justify-content-end">
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
    </nav>
</div>

<!-- Start Modal Delete -->
<div class="modal modal-sm fade" id="delete-category-modal" tabindex="-1" aria-labelledby="delete-category-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-content-between">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" onclick="closeModal('delete-category-modal')" aria-label="Close"></button>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                    <p>Data yang dihapus tidak dapat dipulihkan kembali. Lanjutkan hapus data? (ID: <span id="id-category"></span>)</p>
                </div>
                <form action="" method="post" id="delete-category-form" class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary flex-fill" onclick="closeModal('delete-category-modal')">Batal</button>
                    <button type="button" class="btn btn-danger flex-fill">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete -->