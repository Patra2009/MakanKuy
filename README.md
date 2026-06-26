# MakanKuy

MakanKuy adalah aplikasi pemesanan makanan berbasis Laravel. Aplikasi ini memiliki landing page untuk pelanggan, form pemesanan dengan pilihan lokasi antaran melalui map, fitur cek status pesanan dari tombol keranjang, dan panel admin untuk mengelola menu, kategori, promo, kontak, pengguna, serta pesanan.

## Fitur Utama

- Landing page daftar menu makanan, minuman, dan cemilan.
- Pencarian menu dan filter berdasarkan kategori.
- Popup pemesanan langsung dari kartu menu.
- Pemilihan lokasi antaran menggunakan map Leaflet/OpenStreetMap.
- Penyimpanan alamat, nomor HP, latitude, dan longitude pembeli.
- Cek status pesanan pelanggan melalui tombol keranjang di dekat kolom pencarian.
- Panel admin untuk memantau dan mengubah status pesanan.
- Seeder data demo untuk menu, promo, user, dan pesanan.

## Teknologi

- PHP 8.3+
- Laravel 13
- MySQL/MariaDB atau database lain yang didukung Laravel
- Composer
- Node.js dan npm
- Leaflet + OpenStreetMap untuk map di halaman pemesanan

## Cara Menjalankan Project

Clone repository:

```bash
git clone https://github.com/username/nama-repo.git
cd nama-repo
```

Install dependency PHP:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Buat file environment:

```bash
cp .env.example .env
```

Untuk Windows PowerShell, jika perintah `cp` tidak tersedia:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur database di file `.env`, contoh MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=makankuy
DB_USERNAME=root
DB_PASSWORD=
```

Buat database sesuai nama `DB_DATABASE`, lalu jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

Buat symbolic link storage:

```bash
php artisan storage:link
```

Build asset frontend:

```bash
npm run build
```

Jalankan server lokal:

```bash
php artisan serve
```

Buka aplikasi di browser:

```text
http://127.0.0.1:8000
```

## Akun Demo

Seeder membuat akun admin berikut:

```text
Email: admin@makankuy.com
Password: password
```

Panel admin dapat dibuka dari tombol admin di navbar landing page atau melalui:

```text
http://127.0.0.1:8000/admin
```

## Cara Mencoba Fitur Pesanan

1. Buka landing page.
2. Pilih salah satu menu, lalu klik tombol tambah atau kartu menu.
3. Isi nama, nomor HP, alamat pengiriman, jumlah, dan metode pembayaran.
4. Pada bagian `Lokasi Antaran`, klik titik di map atau gunakan tombol `Lokasi Saya`.
5. Klik `Buat Pesanan`.
6. Buka panel admin untuk melihat detail pesanan, termasuk link lokasi map.

Untuk cek status pesanan sebagai pelanggan:

1. Klik tombol keranjang di samping kolom pencarian.
2. Masukkan nomor HP yang digunakan saat memesan.
3. Opsional: masukkan kode pesanan seperti `ORD-001`.
4. Klik `Cek`.

## Catatan Map

Map menggunakan Leaflet dan tile dari OpenStreetMap melalui CDN. Jika map tidak muncul, pastikan perangkat terhubung ke internet dan browser tidak memblokir akses ke CDN.

Fitur `Lokasi Saya` menggunakan geolocation browser. Browser biasanya meminta izin lokasi terlebih dahulu, dan fitur ini bekerja paling baik saat aplikasi dibuka melalui `localhost` atau domain HTTPS.

## Perintah Berguna

Menjalankan migrasi ulang dengan data demo:

```bash
php artisan migrate:fresh --seed
```

Menjalankan mode development Vite:

```bash
npm run dev
```

Menjalankan test:

```bash
php artisan test
```

## Struktur Penting

- `routes/web.php` - routing landing page, pesanan, kontak, dan admin.
- `app/Http/Controllers/LandingController.php` - proses landing page, pemesanan, kontak, dan cek status pesanan.
- `app/Http/Controllers/Admin` - controller panel admin.
- `resources/views/landing/index.blade.php` - tampilan landing page dan popup pemesanan.
- `resources/views/admin` - tampilan panel admin.
- `database/migrations` - struktur tabel database.
- `database/seeders/MakanKuySeeder.php` - data demo aplikasi.

## Lisensi

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan aplikasi pemesanan makanan.
