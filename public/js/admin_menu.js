// Fungsi membuka pop-up
function openModal() {
    const modal = document.getElementById('modalTambahMenu');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden'; /* Matikan scroll halaman utama saat pop-up aktif */
}

// Fungsi menutup pop-up
function closeModal() {
    const modal = document.getElementById('modalTambahMenu');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto'; /* Aktifkan kembali scroll halaman utama */
}

// Fungsi menutup pop-up jika user klik area luar kotak form
function closeModalOutside(event) {
    const modalContent = document.querySelector('.modal-content-box');
    if (!modalContent.contains(event.target)) {
        closeModal();
    }
}

function openEditModal(button) {
    // 1. Ambil semua data dari atribut tombol yang diklik
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');
    const kategori = button.getAttribute('data-kategori');
    const harga = button.getAttribute('data-harga');
    const stok = button.getAttribute('data-stok');
    const deskripsi = button.getAttribute('data-deskripsi');

    // 2. Isikan data tersebut ke dalam input form edit
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kategori_id').value = kategori;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_deskripsi').value = deskripsi;

    // 3. Set action URL Form secara dinamis mengarah ke route update Laravel
    // Sesuaikan url ini dengan link menu update kamu, standarnya: /admin/menu/{id}
    document.getElementById('formEditMenu').action = `/admin/menu/${id}`;

    // 4. Munculkan pop-up edit
    const modal = document.getElementById('modalEditMenu');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModalEdit() {
    const modal = document.getElementById('modalEditMenu');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function closeEditModalOutside(event) {
    const modalContent = document.querySelector('#modalEditMenu .modal-content-box');
    if (!modalContent.contains(event.target)) {
        closeModalEdit();
    }
}

@if($errors->any() || session('error'))
    window.addEventListener('DOMContentLoaded', () => {
        openModal();
    });
@endif