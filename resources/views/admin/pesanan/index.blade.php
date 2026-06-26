@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="page-header">
    <h1>Kelola Pesanan</h1>
    <p>Pantau dan proses pesanan pelanggan.</p>
</div>

<div class="table-card" style="margin-top: 24px;">
    <div class="filter-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <form method="GET" action="{{ route('admin.pesanan.index') }}" style="width: 100%;">
                <input type="text" name="search" placeholder="Cari kode pesanan..." value="{{ request('search') }}">
            </form>
        </div>
        <div style="margin-left: auto;">
            <form method="GET" action="{{ route('admin.pesanan.index') }}" id="filterForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select class="form-control" name="status" onchange="document.getElementById('filterForm').submit();" style="width: 180px;">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Pesanan</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $pesanan)
            <tr>
                <td style="font-weight: 600;">{{ $pesanan->kode_pesanan }}</td>
                <td>{{ $pesanan->user->name }}</td>
                <td>{{ $pesanan->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $pesanan->metode_pembayaran ?? '-' }}</td>
                <td style="font-weight: 600;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span class="badge badge-{{ $pesanan->status }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn-icon" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #999; padding: 40px;">
                    Tidak ada pesanan ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pesanans->hasPages())
    <div class="pagination-wrapper">
        {{ $pesanans->links() }}
    </div>
    @endif
</div>
@endsection
