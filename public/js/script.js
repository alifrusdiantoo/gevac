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
    document.getElementById('edit-category-form').action = '/dashboard/categories/' + id;
    document.getElementById('edit-category-name').value = name;
    openModal('edit-category-modal');
}

function openDeleteModal(id) {
    document.getElementById('delete-category-form').action = '/dashboard/categories/' + id;
    document.getElementById('id-category').innerHTML = id;
    openModal('delete-category-modal');
}