<div class="modal modal-sm fade" id="add-data-modal" tabindex="-1" aria-labelledby="add-data-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6>Tambah Dusun</h6>
                    <button type="button" class="btn-close" onclick="closeModal('add-data-modal')" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="add-data-form">
                    <div class="d-flex flex-column">
                        <div class="mb-4">
                            <label for="add-data-name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="add-data-name" name="nama" placeholder="Masukkan nama dusun" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-fill">Tambah</button>
                        <button type="button" class="btn btn-sm btn-secondary flex-fill" onclick="closeModal('add-data-modal')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>