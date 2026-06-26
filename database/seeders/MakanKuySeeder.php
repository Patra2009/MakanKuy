<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Promo;
use App\Models\Kontak;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MakanKuySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === Users ===
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@makankuy.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@email.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user3 = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@email.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user4 = User::create([
            'name' => 'Rina Melati',
            'email' => 'rina@email.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // === Kategori ===
        $makanan = Kategori::create([
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Berbagai pilihan makanan lezat',
        ]);

        $minuman = Kategori::create([
            'nama_kategori' => 'Minuman',
            'deskripsi' => 'Minuman segar dan nikmat',
        ]);

        $cemilan = Kategori::create([
            'nama_kategori' => 'Cemilan',
            'deskripsi' => 'Cemilan dan dessert favorit',
        ]);

        // === Menu ===
        $menu1 = Menu::create([
            'kategori_id' => $makanan->id,
            'nama' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur mata sapi, ayam suwir, sate ayam, dan kerupuk.',
            'harga' => 35000,
            'stok' => 50,
            'gambar' => null,
        ]);

        $menu2 = Menu::create([
            'kategori_id' => $makanan->id,
            'nama' => 'Mie Goreng Jawa',
            'deskripsi' => 'Mie goreng bumbu khas Jawa dengan sayuran segar dan telur orak-arik.',
            'harga' => 30000,
            'stok' => 40,
            'gambar' => null,
        ]);

        $menu3 = Menu::create([
            'kategori_id' => $makanan->id,
            'nama' => 'Sate Ayam Madura',
            'deskripsi' => '10 tusuk sate ayam dengan bumbu kacang kental dan irisan bawang...',
            'harga' => 40000,
            'stok' => 30,
            'gambar' => null,
        ]);

        $menu4 = Menu::create([
            'kategori_id' => $makanan->id,
            'nama' => 'Ayam Bakar Taliwang',
            'deskripsi' => 'Ayam bakar pedas manis khas Lombok disajikan dengan plecing...',
            'harga' => 45000,
            'stok' => 25,
            'gambar' => null,
        ]);

        $menu5 = Menu::create([
            'kategori_id' => $minuman->id,
            'nama' => 'Es Teh Manis',
            'deskripsi' => 'Teh melati seduh segar dengan es batu dan gula asli.',
            'harga' => 10000,
            'stok' => 100,
            'gambar' => null,
        ]);

        $menu6 = Menu::create([
            'kategori_id' => $minuman->id,
            'nama' => 'Kopi Susu Gula Aren',
            'deskripsi' => 'Espresso blend dengan susu segar dan manisnya gula aren asli.',
            'harga' => 25000,
            'stok' => 60,
            'gambar' => null,
        ]);

        $menu7 = Menu::create([
            'kategori_id' => $minuman->id,
            'nama' => 'Es Jeruk Peras',
            'deskripsi' => 'Perasan jeruk segar asli tanpa pemanis buatan.',
            'harga' => 15000,
            'stok' => 80,
            'gambar' => null,
        ]);

        $menu8 = Menu::create([
            'kategori_id' => $cemilan->id,
            'nama' => 'Pisang Goreng Keju',
            'deskripsi' => 'Pisang kepok goreng renyah dengan taburan keju parut dan susu kental...',
            'harga' => 20000,
            'stok' => 45,
            'gambar' => null,
        ]);

        $menu9 = Menu::create([
            'kategori_id' => $cemilan->id,
            'nama' => 'Kentang Goreng',
            'deskripsi' => 'Kentang goreng crispy dengan saus sambal dan mayonnaise.',
            'harga' => 18000,
            'stok' => 55,
            'gambar' => null,
        ]);

        $menu10 = Menu::create([
            'kategori_id' => $cemilan->id,
            'nama' => 'Dimsum Ayam',
            'deskripsi' => 'Dimsum kukus isi ayam dan udang dengan saus kecap pedas.',
            'harga' => 25000,
            'stok' => 35,
            'gambar' => null,
        ]);

        // === Pesanan ===
        $pesanan1 = Pesanan::create([
            'user_id' => $user1->id,
            'total_harga' => 125000,
            'status' => 'menunggu',
            'metode_pembayaran' => 'E-Wallet',
            'created_at' => '2023-10-25 14:30:00',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan1->id,
            'menu_id' => $menu1->id,
            'jumlah' => 2,
            'harga' => 35000,
            'subtotal' => 70000,
        ]);
        DetailPesanan::create([
            'pesanan_id' => $pesanan1->id,
            'menu_id' => $menu6->id,
            'jumlah' => 2,
            'harga' => 25000,
            'subtotal' => 50000,
        ]);

        $pesanan2 = Pesanan::create([
            'user_id' => $user2->id,
            'total_harga' => 85000,
            'status' => 'diproses',
            'metode_pembayaran' => 'Transfer',
            'created_at' => '2023-10-25 14:15:00',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan2->id,
            'menu_id' => $menu3->id,
            'jumlah' => 1,
            'harga' => 40000,
            'subtotal' => 40000,
        ]);
        DetailPesanan::create([
            'pesanan_id' => $pesanan2->id,
            'menu_id' => $menu4->id,
            'jumlah' => 1,
            'harga' => 45000,
            'subtotal' => 45000,
        ]);

        $pesanan3 = Pesanan::create([
            'user_id' => $user3->id,
            'total_harga' => 210000,
            'status' => 'selesai',
            'metode_pembayaran' => 'Cash',
            'created_at' => '2023-10-25 13:45:00',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan3->id,
            'menu_id' => $menu4->id,
            'jumlah' => 4,
            'harga' => 45000,
            'subtotal' => 180000,
        ]);
        DetailPesanan::create([
            'pesanan_id' => $pesanan3->id,
            'menu_id' => $menu5->id,
            'jumlah' => 3,
            'harga' => 10000,
            'subtotal' => 30000,
        ]);

        $pesanan4 = Pesanan::create([
            'user_id' => $user4->id,
            'total_harga' => 45000,
            'status' => 'dibatalkan',
            'metode_pembayaran' => 'E-Wallet',
            'created_at' => '2023-10-25 12:20:00',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan4->id,
            'menu_id' => $menu4->id,
            'jumlah' => 1,
            'harga' => 45000,
            'subtotal' => 45000,
        ]);

        // === Promo ===
        Promo::create([
            'judul' => 'Diskon 20% Menu Spesial',
            'deskripsi' => 'Nikmati hidangan lezat dengan harga hemat. Pesan sekarang dan kami antar selagi hangat!',
            'diskon' => 20.00,
            'tanggal_mulai' => '2023-10-01',
            'tanggal_akhir' => '2023-12-31',
            'status' => 'aktif',
        ]);

        Promo::create([
            'judul' => 'Gratis Ongkir',
            'deskripsi' => 'Gratis ongkos kirim untuk pembelian minimal Rp 50.000',
            'diskon' => 0,
            'tanggal_mulai' => '2023-10-15',
            'tanggal_akhir' => '2023-11-15',
            'status' => 'aktif',
        ]);

        // === Kontak ===
        Kontak::create([
            'nama' => 'Dewi Sartika',
            'pesan' => 'Makanannya enak sekali, pelayanan cepat!',
            'created_at' => now(),
        ]);

        Kontak::create([
            'nama' => 'Rizky Pratama',
            'pesan' => 'Apakah bisa pesan untuk acara kantor?',
            'created_at' => now(),
        ]);
    }
}
