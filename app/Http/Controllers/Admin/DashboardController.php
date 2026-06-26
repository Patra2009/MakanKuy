<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pesanan::where('status', '!=', 'dibatalkan')->sum('total_harga');
        $totalPesanan = Pesanan::count();
        $totalPelanggan = User::where('role', 'user')->count();
        $menuAktif = Menu::where('stok', '>', 0)->count();

        $pesananTerbaru = Pesanan::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPesanan',
            'totalPelanggan',
            'menuAktif',
            'pesananTerbaru'
        ));
    }
}
