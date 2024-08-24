<div class="modal modal-sm fade" id="edit-data-modal" tabindex="-1" aria-labelledby="edit-data-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" onclick="closeModal('edit-data-modal')" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="edit-data-form">
                    <div class="d-flex flex-column">
                        <div class="mb-4">
                            <input type="text" class="form-control d-none" id="edit-data-id" name="id" readonly required />
                            <label for="edit-data-name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-data-name" name="nama" placeholder="Ciawitali" required />
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary flex-fill">Update</button>
                        <button type="button" class="btn btn-sm btn-secondary flex-fill" onclick="closeModal('edit-data-modal')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>