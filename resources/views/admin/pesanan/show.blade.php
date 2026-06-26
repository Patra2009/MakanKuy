@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="page-header" style="display: flex; align-items: center; gap: 16px;">
    <a href="{{ route('admin.pesanan.index') }}" class="btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1>Detail Pesanan {{ $pesanan->kode_pesanan }}</h1>
        <p>Informasi lengkap pesanan pelanggan.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 24px;">
    <!-- Info Pesanan -->
    <div class="table-card">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Informasi Pesanan</h3>
        <table>
            <tr><td style="color: #888; width: 140px;">Kode Pesanan</td><td style="font-weight: 600;">{{ $pesanan->kode_pesanan }}</td></tr>
            <tr><td style="color: #888;">Pelanggan</td><td>{{ $pesanan->user->name }}</td></tr>
            <tr><td style="color: #888;">Email</td><td>{{ $pesanan->user->email }}</td></tr>
            <tr><td style="color: #888;">Tanggal</td><td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td></tr>
            <tr><td style="color: #888;">Metode Bayar</td><td>{{ $pesanan->metode_pembayaran ?? '-' }}</td></tr>
            <tr>
                <td style="color: #888;">Status</td>
                <td><span class="badge badge-{{ $pesanan->status }}">{{ ucfirst($pesanan->status) }}</span></td>
            </tr>
        </table>

        <!-- Update Status -->
        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #f0f0f0;">
            <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan) }}" style="display: flex; gap: 10px; align-items: center;">
                @csrf
                @method('PATCH')
                <select name="status" class="form-control" style="width: auto;">
                    <option value="menunggu" {{ $pesanan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
            </form>
        </div>
    </div>

    <!-- Detail Item -->
    <div class="table-card">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Item Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->detailPesanans as $detail)
                <tr>
                    <td>{{ $detail->menu->nama }}</td>
                    <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td style="font-weight: 600;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: 600; padding-top: 16px; border-top: 2px solid #f0f0f0;">Total</td>
                    <td style="font-weight: 700; font-size: 16px; color: #ff6b35; padding-top: 16px; border-top: 2px solid #f0f0f0;">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
