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





<link rel="stylesheet" href="{{ asset('css/admin_menu.css') }}">

<script src="{{ asset('js/admin_menu.js') }}"></script>

@endsection
