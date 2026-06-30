<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MakanKuy - Pesan makanan dan minuman favorit Anda dengan mudah dan cepat">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MakanKuy - Pesan Makanan Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    @if(session('success'))
        <div class="landing-alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="landing-alert landing-alert-error">
            <i class="fas fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('landing') }}" class="navbar-brand">
                <div class="brand-icon">M</div>
                <span class="brand-name">MakanKuy</span>
            </a>
            <div class="navbar-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari makanan atau minuman..." id="searchMenu">
            </div>
            <div class="navbar-actions">
                <button type="button" class="navbar-cart" id="openStatusModal" title="Cek status pesanan">
                    <i class="fas fa-shopping-cart"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="admin-link" title="Admin Panel">
                    <i class="fas fa-user-shield"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-card">
                @if($promo)
                <div class="hero-badge">PROMO HARI INI</div>
                <h1>{{ $promo->judul }}<br><span class="highlight">Menu Spesial</span></h1>
                <p>{{ $promo->deskripsi }}</p>
                @else
                <div class="hero-badge">SELAMAT DATANG</div>
                <h1>Pesan Makanan<br><span class="highlight">Favoritmu</span></h1>
                <p>Nikmati berbagai pilihan makanan dan minuman lezat. Pesan sekarang dengan mudah!</p>
                @endif
                <a href="#menu" class="hero-btn">
                    Pesan Sekarang <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div class="section-header">
                <h2>Menu Pilihan</h2>
            </div>

            <!-- Category Tabs -->
            <div class="category-tabs">
                <button class="cat-tab active" data-category="semua">Semua</button>
                @foreach($kategoris as $kat)
                <button class="cat-tab" data-category="{{ $kat->id }}">{{ $kat->nama_kategori }}</button>
                @endforeach
            </div>

            <!-- Menu Grid -->
            <div class="menu-grid" id="menuGrid">
                @foreach($menus as $index => $menu)
                <div class="menu-card"
                    data-category="{{ $menu->kategori_id }}"
                    data-name="{{ strtolower($menu->nama) }}"
                    data-menu-id="{{ $menu->id }}"
                    data-title="{{ $menu->nama }}"
                    data-description="{{ $menu->deskripsi }}"
                    data-price="{{ $menu->harga }}"
                    data-price-formatted="Rp {{ number_format($menu->harga, 0, ',', '.') }}"
                    data-stock="{{ $menu->stok }}"
                    data-image="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : '' }}">
                    <div class="menu-card-img">
                        @if($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}">
                        @else
                            <i class="fas fa-utensils placeholder-icon"></i>
                        @endif
                        @if($index < 4 || $index % 3 == 0)
                        <div class="menu-card-badge">
                            <i class="fas fa-star" style="font-size: 9px;"></i> Populer
                        </div>
                        @endif
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-name">{{ $menu->nama }}</div>
                        <div class="menu-card-desc">{{ $menu->deskripsi }}</div>
                        <div class="menu-card-footer">
                            <div class="menu-card-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                            <button type="button" class="menu-card-add" title="Pesan menu">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Order Modal -->
    <div class="order-modal" id="orderModal" aria-hidden="true">
        <div class="order-modal-backdrop" data-close-modal></div>
        <div class="order-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="orderMenuName">
            <button type="button" class="order-modal-close" data-close-modal aria-label="Tutup popup">
                <i class="fas fa-times"></i>
            </button>

            <div class="order-modal-menu">
                <div class="order-modal-image" id="orderMenuImageWrap">
                    <img src="" alt="" id="orderMenuImage">
                    <i class="fas fa-utensils" id="orderMenuPlaceholder"></i>
                </div>
                <div>
                    <h3 id="orderMenuName">Nama Menu</h3>
                    <p id="orderMenuDesc">Deskripsi menu</p>
                    <div class="order-modal-meta">
                        <span id="orderMenuPrice">Rp 0</span>
                        <span id="orderMenuStock">Stok 0</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('pesanan.store') }}" class="order-form">
                @csrf
                <input type="hidden" name="menu_id" id="orderMenuId">

                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pemesan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="form-group">
                    <label for="alamat_pengiriman">Alamat Pengiriman</label>
                    <textarea name="alamat_pengiriman" id="alamat_pengiriman" placeholder="Tulis alamat lengkap Anda" required>{{ old('alamat_pengiriman') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="deliveryMap">Lokasi Antaran</label>
                    <div class="delivery-map-select">
                        <div id="deliveryMap"></div>
                        <div class="delivery-map-footer">
                            <span id="deliveryLocationText">Belum ada titik lokasi yang dipilih.</span>
                            <button type="button" class="location-btn" id="useCurrentLocation">
                                <i class="fas fa-location-crosshairs"></i> Lokasi Saya
                            </button>
                        </div>
                    </div>
                    <small class="delivery-map-hint">Klik titik di map atau gunakan lokasi Anda agar kurir lebih mudah menemukan alamat.</small>
                    <input type="hidden" name="latitude" id="deliveryLatitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="deliveryLongitude" value="{{ old('longitude') }}">
                </div>

                <div class="order-form-row">
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="metode_pembayaran">Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" required>
                            <option value="COD" {{ old('metode_pembayaran') == 'COD' ? 'selected' : '' }}>COD</option>
                            <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="E-Wallet" {{ old('metode_pembayaran') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div class="order-total">
                    <span>Total</span>
                    <strong id="orderTotal">Rp 0</strong>
                </div>

                <button type="submit" class="order-submit">
                    <i class="fas fa-bag-shopping"></i> Buat Pesanan
                </button>
            </form>
        </div>
    </div>

    <!-- Status Modal -->
    <div class="order-modal status-modal" id="statusModal" aria-hidden="true">
        <div class="order-modal-backdrop" data-close-status></div>
        <div class="order-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="statusModalTitle">
            <button type="button" class="order-modal-close" data-close-status aria-label="Tutup popup status">
                <i class="fas fa-times"></i>
            </button>

            <h2 id="statusModalTitle">Status Pesanan</h2>
            <p class="status-modal-intro">Masukkan nomor HP yang dipakai saat memesan untuk melihat progres pesanan terbaru.</p>

            <form class="status-form" id="statusForm">
                <div>
                    <label for="statusNoHp">Nomor HP</label>
                    <input type="text" id="statusNoHp" name="no_hp" placeholder="081234567890" required>
                </div>
                <div>
                    <label for="statusKode">Nama Pelanggan</label>
                    <input type="text" id="statusKode" name="nama_pelanggan" placeholder="Masukkan nama Anda" required>
                </div>
                <button type="submit" class="status-submit">
                    <i class="fas fa-magnifying-glass"></i> Cek
                </button>
            </form>

            <div class="status-results" id="statusResults">
                <div class="status-empty">Status pesanan akan tampil di sini.</div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="contact-section" id="kontak">
        <div class="container">
            <div class="contact-card">
                <h2>Hubungi Kami</h2>
                <p>Punya pertanyaan atau saran? Kirim pesan kepada kami!</p>
                <form class="contact-form" method="POST" action="{{ route('kontak.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea name="pesan" id="pesan" placeholder="Tulis pesan Anda..." required></textarea>
                    </div>
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} <a href="{{ route('landing') }}">MakanKuy</a>. Semua hak cipta dilindungi. |
            <a href="{{ route('admin.dashboard') }}">Admin Panel</a></p>
        </div>
    </footer>

    
    

    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        window.AppConfig = {
            routes: {
                pesananStatus: "{{ route('pesanan.status') }}"
            }
        };
    </script>
    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
