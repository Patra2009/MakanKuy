@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('content')
<div class="page-header">
    <h1>Pesan Kontak</h1>
    <p>Pesan dari pengunjung landing page.</p>
</div>

<div class="table-card" style="margin-top: 24px;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pesan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kontaks as $index => $kontak)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: 600;">{{ $kontak->nama }}</td>
                <td>{{ $kontak->pesan }}</td>
                <td>{{ $kontak->created_at ? $kontak->created_at->format('d M Y, H:i') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #999; padding: 40px;">Belum ada pesan kontak.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
