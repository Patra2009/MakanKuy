<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MakanKuy Admin Panel - Kelola pesanan, menu, dan pelanggan">
    <title>@yield('title', 'Admin Panel') - MakanKuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">M</div>
            <span>Admin Panel</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.pesanan.index') }}" class="nav-item {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan</span>
            </a>
            <a href="{{ route('admin.menu.index') }}" class="nav-item {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                <i class="fas fa-utensils"></i>
                <span>Kelola Menu</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.promo.index') }}" class="nav-item {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Promo</span>
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="nav-item {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('admin.kontak.index') }}" class="nav-item {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Pesan Kontak</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('landing') }}" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-right">
                <button class="topbar-notification">
                    <i class="fas fa-bell"></i>
                    <div class="notification-badge"></div>
                </button>
                <div class="topbar-profile">
                    <div class="topbar-profile-info">
                        <div class="name">Admin Utama</div>
                        <div class="role">Super Admin</div>
                    </div>
                    <div class="topbar-avatar">A</div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
