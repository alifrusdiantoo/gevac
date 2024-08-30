<div class="modal modal-sm fade" id="delete-data-modal" tabindex="-1" aria-labelledby="delete-data-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-content-between">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" onclick="closeModal('delete-data-modal')" aria-label="Close"></button>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center text-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                        <path
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                    <span>Data yang dihapus tidak dapat dipulihkan kembali. Lanjutkan hapus data?</span>
                    <small class="fw-light text-secondary">Id: <span id="id-data"></span></small>
                </div>
                <form action="" method="post" id="delete-data-form" class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary flex-fill" onclick="closeModal('delete-data-modal')">Batal</button>
                    <button type="submit" class="btn btn-danger flex-fill">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>