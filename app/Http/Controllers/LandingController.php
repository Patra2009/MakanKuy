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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $menu = Menu::where('stok', '>', 0)->findOrFail($validated['menu_id']);

        if ($validated['jumlah'] > $menu->stok) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah pesanan melebihi stok yang tersedia.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $menu) {
            $telepon = $this->normalizePhone($validated['no_hp']);
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
                'no_hp' => $telepon,
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
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

    public function statusPesanan(Request $request)
    {
        $validated = $request->validate([
            'no_hp' => 'required|string|max:20',
            'kode_pesanan' => 'nullable|string|max:20',
        ]);

        $telepon = $this->normalizePhone($validated['no_hp']);
        $kodePesanan = $validated['kode_pesanan'] ?? null;

        $pesanans = Pesanan::with(['detailPesanans.menu', 'user'])
            ->where(function ($query) use ($telepon, $validated) {
                $query->where('no_hp', $telepon)
                    ->orWhere('alamat_pengiriman', 'like', '%' . $validated['no_hp'] . '%');
            })
            ->when($kodePesanan, function ($query) use ($kodePesanan) {
                $id = (int) preg_replace('/[^0-9]/', '', $kodePesanan);

                if ($id > 0) {
                    $query->where('id', $id);
                }
            })
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'orders' => $pesanans->map(function (Pesanan $pesanan) {
                return [
                    'kode' => $pesanan->kode_pesanan,
                    'pelanggan' => $pesanan->user?->name,
                    'status' => $pesanan->status,
                    'status_label' => ucfirst($pesanan->status),
                    'tanggal' => $pesanan->created_at?->format('d M Y, H:i'),
                    'total' => 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.'),
                    'alamat' => $pesanan->alamat_pengiriman,
                    'items' => $pesanan->detailPesanans->map(function (DetailPesanan $detail) {
                        return [
                            'nama' => $detail->menu?->nama,
                            'jumlah' => $detail->jumlah,
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
