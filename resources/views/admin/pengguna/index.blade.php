@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')
<div class="page-header">
    <h1>Pengguna</h1>
    <p>Daftar semua pengguna terdaftar.</p>
</div>

<div class="table-card" style="margin-top: 24px;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $user->role == 'admin' ? 'linear-gradient(135deg, #ff6b35, #f7931e)' : '#e3f2fd' }}; display: flex; align-items: center; justify-content: center; color: {{ $user->role == 'admin' ? '#fff' : '#1565c0' }}; font-weight: 600; font-size: 14px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span style="font-weight: 500;">{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge" style="background: {{ $user->role == 'admin' ? '#fff3e0' : '#e8f5e9' }}; color: {{ $user->role == 'admin' ? '#e65100' : '#2e7d32' }};">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">Belum ada pengguna.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
