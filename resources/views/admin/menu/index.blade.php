@extends('layouts.admin')

@section('title', 'Kelola Menu')

@section('content')
<div class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
    <div>
        <h1>Kelola Menu</h1>
        <p>Tambah, edit, dan hapus menu makanan & minuman.</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="openModal()">
        <i class="fas fa-plus"></i> Tambah Menu
    </button>
</div>

<div class="table-card" style="margin-top: 24px;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $index => $menu)
            <tr>
                <td>{{ $menus->firstItem() + $index }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 44px; height: 44px; border-radius: 10px; background: #f5f6fa; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-image" style="color: #ccc;"></i>
                            @endif
                        </div>
                        <div>
                            <div style="font-weight: 600;">{{ $menu->nama }}</div>
                            <div style="font-size: 12px; color: #999;">{{ Str::limit($menu->deskripsi, 40) }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge" style="background: #f0f0f0; color: #555;">{{ $menu->kategori->nama_kategori }}</span></td>
                <td style="font-weight: 600;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td>
                    <span style="color: {{ $menu->stok > 10 ? '#2e7d32' : ($menu->stok > 0 ? '#e65100' : '#c62828') }}; font-weight: 600;">
                        {{ $menu->stok }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn-icon" title="Edit" onclick="openEditModal(this)"
                                data-id="{{ $menu->id }}"
                                data-nama="{{ $menu->nama }}"
                                data-kategori="{{ $menu->kategori_id }}"
                                data-harga="{{ $menu->harga }}"
                                data-stok="{{ $menu->stok }}"
                                data-deskripsi="{{ $menu->deskripsi }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.menu.destroy', $menu) }}" onsubmit="konfirmasiHapus(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" style="color: #c62828;" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999; padding: 40px;">
                    Belum ada menu. <a href="javascript:void(0)" onclick="openModal()" style="color: #ff6b35; font-weight: 600;">Tambah menu pertama</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($menus->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan <b>{{ $menus->firstItem() }}</b> sampai <b>{{ $menus->lastItem() }}</b> dari <b>{{ $menus->total() }}</b> menu
        </div>
        <div class="pagination-wrapper">
            {{ $menus->links('pagination::bootstrap-4') }} 
            {{-- Kita kunci ke bootstrap-4 agar Laravel menghasilkan struktur HTML yang bersih dan mudah di-styling --}}
        </div>
    </div>
    @endif
</div>

<div id="modalTambahMenu" class="modal-overlay" onclick="closeModalOutside(event)">
    <div class="modal-content-box animate-pop">
        <div class="modal-header-box">
            <h2>Tambah Menu Baru</h2>
            <button type="button" class="close-x-btn" onclick="closeModal()">&times;</button>
        </div>
        
        <div class="modal-body-box">
            <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Menu</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', 0) }}" required min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEditMenu" class="modal-overlay" onclick="closeEditModalOutside(event)">
    <div class="modal-content-box animate-pop">
        <div class="modal-header-box">
            <h2>Edit Menu Makanan</h2>
            <button type="button" class="close-x-btn" onclick="closeEditModal()">&times;</button>
        </div>
        
        <div class="modal-body-box">
            <form id="formEditMenu" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="form-group">
                    <label for="edit_nama">Nama Menu</label>
                    <input type="text" name="nama" id="edit_nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_kategori_id">Kategori</label>
                    <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label for="edit_harga">Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="edit_stok">Stok</label>
                        <input type="number" name="stok" id="edit_stok" class="form-control" required min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_gambar">Gambar (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" name="gambar" id="edit_gambar" class="form-control" accept="image/*">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Container Utama Pagination */
.pagination-container {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Membuat info di kiri, tombol page di kanan */
    padding: 20px 24px;
    border-top: 1px solid #f0f0f0;
    background: #fff;
    border-radius: 0 0 14px 14px; /* Menempel rapi di bawah table-card */
}

/* Teks Informasi Data (Sebelah Kiri) */
.pagination-info {
    font-size: 14px;
    color: #6c757d;
}
.pagination-info b {
    color: #1e2330;
    font-weight: 600;
}

/* Merapikan Navigasi Bantuan Laravel (Sebelah Kanan) */
.pagination-wrapper ul.pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

/* Gaya Kotak Angka / Tombol */
.pagination-wrapper .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 8px;
    font-size: 14px;
    font-weight: 500;
    color: #555;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

/* Efek Ketika Tombol Di-hover (Kursor Mendekat) */
.pagination-wrapper .page-item:not(.active):not(.disabled) .page-link:hover {
    background: #fff3ed; /* Oranye sangat muda */
    border-color: #ff6b35; /* Warna oranye utama kamu */
    color: #ff6b35;
    transform: translateY(-2px); /* Efek sedikit mengangkat */
    box-shadow: 0 4px 10px rgba(255, 107, 53, 0.15);
}

/* Gaya Tombol yang Sedang Aktif (Halaman saat ini) */
.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #ff8c42 0%, #ff6b35 100%); /* Gradasi Oranye */
    border-color: #ff6b35;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
}

/* Gaya Tombol yang Mati (Misal: Tombol 'Previous' saat di halaman 1) */
.pagination-wrapper .page-item.disabled .page-link {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #ccc;
    cursor: not-allowed;
}

/* Background Overlay Hitam Transparan */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px); /* Efek blur premium pada background */
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

/* Munculkan modal overlay */
.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* Kotak Form di Dalam Pop-up */
.modal-content-box {
    background: #fff;
    width: 100%;
    max-width: 550px;
    border-radius: 14px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    transform: scale(0.9) translateY(-30px);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); /* Efek pop elastis halus */
}

/* Efek gerak naik/membesar saat aktif */
.modal-overlay.show .modal-content-box {
    transform: scale(1) translateY(0);
}

/* Header Pop-up */
.modal-header-box {
    padding: 20px 24px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.modal-header-box h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #1e2330;
}

/* Tombol Silang (X) */
.close-x-btn {
    background: none;
    border: none;
    font-size: 28px;
    color: #aaa;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    transition: color 0.2s;
}
.close-x-btn:hover {
    color: #333;
}

/* Area Form Isi Pop-up */
.modal-body-box {
    padding: 24px;
    max-height: 80vh;
    overflow-y: auto; /* Jika layar user pendek, form bisa di-scroll internal */
}
</style>

<script>

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
</script>
@endsection