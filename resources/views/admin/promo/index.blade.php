@extends('layouts.admin')

@section('title', 'Promo')

@section('content')
<div class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
    <div>
        <h1>Promo</h1>
        <p>Kelola promo dan diskon untuk pelanggan.</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('active')">
        <i class="fas fa-plus"></i> Tambah Promo
    </button>
</div>

<div class="table-card" style="margin-top: 24px;">
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Diskon</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
            <tr>
                <td>
                    <div style="font-weight: 600;">{{ $promo->judul }}</div>
                    <div style="font-size: 12px; color: #999;">{{ Str::limit($promo->deskripsi, 50) }}</div>
                </td>
                <td style="font-weight: 600; color: #ff6b35;">{{ $promo->diskon }}%</td>
                <td>{{ $promo->tanggal_mulai->format('d M Y') }} - {{ $promo->tanggal_akhir->format('d M Y') }}</td>
                <td>
                    <span class="badge" style="background: {{ $promo->status == 'aktif' ? '#e8f5e9' : '#f5f5f5' }}; color: {{ $promo->status == 'aktif' ? '#2e7d32' : '#999' }};">
                        {{ ucfirst($promo->status) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <button type="button" class="btn-icon" style="color: #1565c0; border-color: #bbdefb;" 
                                onclick="openEditModal(this)"
                                data-id="{{ $promo->id }}"
                                data-judul="{{ $promo->judul }}"
                                data-deskripsi="{{ $promo->deskripsi }}"
                                data-diskon="{{ $promo->diskon }}"
                                data-tanggal-mulai="{{ $promo->tanggal_mulai ? $promo->tanggal_mulai->format('Y-m-d') : '' }}"
                                data-tanggal-akhir="{{ $promo->tanggal_akhir ? $promo->tanggal_akhir->format('Y-m-d') : '' }}"
                                data-status="{{ $promo->status }}"
                                title="Edit Promo">
                            <i class="fas fa-edit"></i>
                        </button>

                        <form method="POST" action="{{ route('admin.promo.destroy', $promo) }}" onsubmit="konfirmasiHapus(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" style="color: #c62828; border-color: #fcc;" title="Hapus Promo">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">Belum ada promo.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h3>Tambah Promo</h3>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('active')">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.promo.store') }}">
            @csrf
            <div class="form-group">
                <label>Judul Promo</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" min="0" max="100" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTambah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Promo</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form method="POST" id="formEditPromo" action="">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Judul Promo</label>
                <input type="text" name="judul" id="edit_judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" id="edit_diskon" class="form-control" min="0" max="100" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="edit_tanggal_akhir" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(button) {
    // 1. Ambil semua data dari atribut tombol yang diklik
    const id = button.getAttribute('data-id');
    const judul = button.getAttribute('data-judul');
    const deskripsi = button.getAttribute('data-deskripsi');
    const diskon = button.getAttribute('data-diskon');
    const tglMulai = button.getAttribute('data-tanggal-mulai');
    const tglAkhir = button.getAttribute('data-tanggal-akhir');
    const status = button.getAttribute('data-status');

    // 2. Isikan data tersebut ke dalam input form modal edit
    document.getElementById('edit_judul').value = judul;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_diskon').value = diskon;
    document.getElementById('edit_tanggal_mulai').value = tglMulai;
    document.getElementById('edit_tanggal_akhir').value = tglAkhir;
    document.getElementById('edit_status').value = status;

    // 3. Set action URL Form secara dinamis mengarah ke route update promo Laravel
    document.getElementById('formEditPromo').action = `/admin/promo/${id}`;

    // 4. Munculkan pop-up edit dengan menambahkan class 'active'
    document.getElementById('modalEdit').classList.add('active');
}

function closeEditModal() {
    // Sembunyikan pop-up edit dengan menghapus class 'active'
    document.getElementById('modalEdit').classList.remove('active');
}

// Opsional: Menutup modal edit jika pengguna mengklik area luar modal box
window.addEventListener('click', function(event) {
    const modalEdit = document.getElementById('modalEdit');
    if (event.target === modalEdit) {
        closeEditModal();
    }
    const modalTambah = document.getElementById('modalTambah');
    if (event.target === modalTambah) {
        modalTambah.classList.remove('active');
    }
});
</script>
@endsection