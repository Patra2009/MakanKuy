@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Ringkasan aktivitas toko hari ini.</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon revenue">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orders">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ number_format($totalPesanan) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon customers">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Pelanggan</div>
            <div class="stat-value">{{ number_format($totalPelanggan) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon menu">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Menu Aktif</div>
            <div class="stat-value">{{ $menuAktif }}</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="table-card">
    <div class="table-header">
        <h2>Pesanan Terbaru</h2>
        <a href="{{ route('admin.pesanan.index') }}">Lihat Semua</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kode Pesanan</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesananTerbaru as $pesanan)
            <tr>
                <td style="font-weight: 600;">{{ $pesanan->kode_pesanan }}</td>
                <td>{{ $pesanan->user->name }}</td>
                <td>{{ $pesanan->created_at->format('Y-m-d H:i') }}</td>
                <td style="font-weight: 600;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span class="badge badge-{{ $pesanan->status }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">
                    Belum ada pesanan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
