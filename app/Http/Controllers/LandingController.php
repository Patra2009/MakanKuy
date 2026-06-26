<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Promo;
use App\Models\Kontak;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $menus = Menu::with('kategori')->where('stok', '>', 0)->get();
        $promo = Promo::where('status', 'aktif')->first();

        return view('landing.index', compact('kategoris', 'menus', 'promo'));
    }

    public function storeKontak(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'pesan' => 'required',
        ]);

        Kontak::create([
            'nama' => $request->nama,
            'pesan' => $request->pesan,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function storePesanan(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'nama_pelanggan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string|max:50',
        ]);

        $menu = Menu::where('stok', '>', 0)->findOrFail($validated['menu_id']);

        if ($validated['jumlah'] > $menu->stok) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah pesanan melebihi stok yang tersedia.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $menu) {
            $telepon = preg_replace('/[^0-9]/', '', $validated['no_hp']);
            $email = 'pelanggan' . ($telepon ?: Str::random(8)) . '@makankuy.local';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $validated['nama_pelanggan'],
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'user',
                ]
            );

            $subtotal = $menu->harga * $validated['jumlah'];

            $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'total_harga' => $subtotal,
                'status' => 'menunggu',
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'] . "\nNo. HP: " . $validated['no_hp'],
            ]);

            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menu->id,
                'jumlah' => $validated['jumlah'],
                'harga' => $menu->harga,
                'subtotal' => $subtotal,
            ]);

            $menu->decrement('stok', $validated['jumlah']);
        });

        return redirect()->route('landing')->with('success', 'Pesanan berhasil dibuat! Admin akan segera memproses pesanan Anda.');
    }
}
