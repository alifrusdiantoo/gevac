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

function openEditModal(id, name) {
    document.getElementById('edit-data-form').action = '/users/edit/' + id;
    document.getElementById('edit-data-name').value = name;
    openModal('edit-data-modal');
}

function openDeleteModal(id) {
    document.getElementById('deleteDataForm').action = '/users/' + id;
    document.getElementById('idData').innerHTML = id;
    openModal('deleteDataModal');
}