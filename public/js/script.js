const active = document.querySelector('.active');

if (active) {
    active.classList.add('bg-light');
}

function openModal(modalId) {
    var myModal = new bootstrap.Modal(document.getElementById(modalId));
    myModal.show();
}

function closeModal(modalId) {
    var myModalEl = document.getElementById(modalId);
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
}

function openAddModal(data) {
    document.getElementById('add-data-form').action = `/${data}/add`;
    openModal('add-data-modal');
}

function openEditModal(id, name, data) {
    document.getElementById('edit-data-form').action = `/${data}/edit/` + id;
    document.getElementById('edit-data-id').value = id;
    document.getElementById('edit-data-name').value = name;
    openModal('edit-data-modal');
}

function openDeleteModal(id, data) {
    document.getElementById('delete-data-form').action = `/${data}/` + id;
    document.getElementById('id-data').innerHTML = id;
    openModal('delete-data-modal');
}