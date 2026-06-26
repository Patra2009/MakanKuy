@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
    <div>
        <h1>Kategori</h1>
        <p>Kelola kategori menu makanan dan minuman.</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('active')">
        <i class="fas fa-plus"></i> Tambah Kategori
    </button>
</div>

<div class="table-card" style="margin-top: 24px;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Menu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $index => $kat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: 600;">{{ $kat->nama_kategori }}</td>
                <td>{{ $kat->deskripsi ?? '-' }}</td>
                <td><span class="badge" style="background: #e3f2fd; color: #1565c0;">{{ $kat->menus_count }} menu</span></td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <button class="btn-icon" title="Edit" onclick="editKategori({{ $kat->id }}, '{{ $kat->nama_kategori }}', '{{ $kat->deskripsi }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.kategori.destroy', $kat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" style="color: #c62828; border-color: #fcc;" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">Belum ada kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h3>Tambah Kategori</h3>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('active')">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTambah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Kategori</h3>
            <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('active')">&times;</button>
        </div>
        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalEdit').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function editKategori(id, nama, deskripsi) {
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('formEdit').action = '/admin/kategori/' + id;
    document.getElementById('modalEdit').classList.add('active');
}
</script>
@endsection
