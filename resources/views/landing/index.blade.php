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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #2d3436;
            overflow-x: hidden;
        }

        /* ===== HEADER / NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 16px 0;
            border-bottom: 1px solid #f0f0f0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .navbar-brand .brand-name {
            font-size: 20px;
            font-weight: 700;
            color: #1e2330;
            letter-spacing: -0.5px;
        }

        .navbar-search {
            flex: 1;
            max-width: 480px;
            margin: 0 40px;
            position: relative;
        }

        .navbar-search input {
            width: 100%;
            padding: 11px 16px 11px 44px;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            outline: none;
            transition: all 0.2s;
        }

        .navbar-search input:focus {
            border-color: #ff6b35;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .navbar-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-cart {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #555;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: 1px solid #e8e8e8;
            font-family: 'Inter', sans-serif;
        }

        .navbar-cart:hover {
            background: #fff3ee;
            color: #ff6b35;
            border-color: #ffd0b5;
        }

        .admin-link {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1e2330;
            color: #fff;
            text-decoration: none;
            transition: all 0.2s;
        }

        .admin-link:hover {
            background: #ff6b35;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            padding: 40px 0;
        }

        .hero-card {
            background: linear-gradient(135deg, #fff8f0 0%, #ffe8d6 50%, #ffd8b8 100%);
            border-radius: 24px;
            padding: 48px 56px;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,107,53,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .hero h1 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            color: #1e2330;
            letter-spacing: -1px;
        }

        .hero h1 .highlight {
            color: #ff6b35;
        }

        .hero p {
            font-size: 16px;
            color: #666;
            line-height: 1.7;
            margin-bottom: 28px;
            max-width: 440px;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            padding: 14px 28px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.35);
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(255, 107, 53, 0.45);
        }

        /* ===== MENU SECTION ===== */
        .menu-section {
            padding: 40px 0 60px;
        }

        .section-header {
            margin-bottom: 28px;
        }

        .section-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: #1e2330;
            letter-spacing: -0.5px;
        }

        /* Category Tabs */
        .category-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .cat-tab {
            padding: 9px 22px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #555;
            font-family: 'Inter', sans-serif;
        }

        .cat-tab:hover {
            border-color: #ff6b35;
            color: #ff6b35;
            background: #fff8f4;
        }

        .cat-tab.active {
            background: #1e2330;
            color: #fff;
            border-color: #1e2330;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .menu-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.1);
            border-color: transparent;
        }

        .menu-card-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .menu-card:hover .menu-card-img img {
            transform: scale(1.05);
        }

        .menu-card-img .placeholder-icon {
            font-size: 40px;
            color: #ddd;
        }

        .menu-card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }

        .menu-card-body {
            padding: 18px;
        }

        .menu-card-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e2330;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .menu-card-desc {
            font-size: 13px;
            color: #888;
            line-height: 1.5;
            margin-bottom: 14px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .menu-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-card-price {
            font-size: 17px;
            font-weight: 700;
            color: #ff6b35;
        }

        .menu-card-add {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #1e2330;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            cursor: pointer;
            transition: all 0.25s;
            color: #1e2330;
            font-size: 16px;
        }

        .menu-card-add:hover {
            background: #1e2330;
            color: #fff;
            transform: scale(1.1);
        }

        /* ===== ORDER MODAL ===== */
        .order-modal {
            position: fixed;
            inset: 0;
            z-index: 300;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .order-modal.active {
            display: flex;
        }

        .order-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(30, 35, 48, 0.62);
            backdrop-filter: blur(4px);
        }

        .order-modal-dialog {
            position: relative;
            width: min(100%, 560px);
            max-height: 92vh;
            overflow-y: auto;
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 24px 70px rgba(0,0,0,0.22);
            animation: modalIn 0.25s ease;
        }

        .order-modal-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            background: #f5f6f7;
            color: #555;
            cursor: pointer;
            transition: all 0.2s;
        }

        .order-modal-close:hover {
            background: #fff3ee;
            color: #ff6b35;
        }

        .order-modal-menu {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding-right: 24px;
            margin-bottom: 22px;
        }

        .order-modal-image {
            width: 112px;
            height: 112px;
            border-radius: 14px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #ddd;
            font-size: 32px;
        }

        .order-modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .order-modal-menu h3 {
            font-size: 21px;
            font-weight: 750;
            color: #1e2330;
            margin: 6px 0 8px;
        }

        .order-modal-menu p {
            font-size: 13px;
            color: #777;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .order-modal-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 650;
        }

        .order-modal-meta span {
            padding: 6px 10px;
            border-radius: 10px;
            background: #f8f9fa;
            color: #555;
        }

        .order-modal-meta span:first-child {
            background: #fff3ee;
            color: #ff6b35;
        }

        .order-form .form-group {
            margin-bottom: 14px;
        }

        .order-form label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        .order-form input,
        .order-form textarea,
        .order-form select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            background: #fff;
            transition: all 0.2s;
        }

        .order-form textarea {
            min-height: 86px;
            resize: vertical;
        }

        .order-form input:focus,
        .order-form textarea:focus,
        .order-form select:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .order-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .delivery-map-select {
            overflow: hidden;
            border: 1px solid #e0e0e0;
            border-radius: 14px;
            background: #f8f9fa;
        }

        #deliveryMap {
            width: 100%;
            height: 220px;
            background: #eef1f4;
        }

        .delivery-map-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 12px;
        }

        .delivery-map-footer span {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }

        .delivery-map-hint {
            display: block;
            margin-top: 6px;
            color: #888;
            font-size: 12px;
            line-height: 1.5;
        }

        .location-btn {
            flex: 0 0 auto;
            border: 1px solid #ffd0b5;
            border-radius: 10px;
            padding: 8px 10px;
            background: #fff;
            color: #ff6b35;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 650;
            transition: all 0.2s;
        }

        .location-btn:hover {
            background: #fff3ee;
        }

        .order-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            margin: 4px 0 16px;
            border-radius: 14px;
            background: #f8f9fa;
            color: #555;
        }

        .order-total strong {
            color: #ff6b35;
            font-size: 20px;
        }

        .order-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
        }

        .order-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }

        /* ===== STATUS MODAL ===== */
        .status-modal .order-modal-dialog {
            width: min(100%, 640px);
        }

        .status-modal h2 {
            font-size: 22px;
            color: #1e2330;
            margin-bottom: 6px;
        }

        .status-modal-intro {
            color: #777;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .status-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: end;
            margin-bottom: 18px;
        }

        .status-form label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        .status-form input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.2s;
        }

        .status-form input:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .status-submit {
            height: 44px;
            padding: 0 16px;
            border: none;
            border-radius: 12px;
            background: #1e2330;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            cursor: pointer;
        }

        .status-results {
            display: grid;
            gap: 12px;
        }

        .status-empty {
            padding: 18px;
            border-radius: 14px;
            background: #f8f9fa;
            color: #777;
            font-size: 14px;
            text-align: center;
        }

        .status-card {
            border: 1px solid #f0f0f0;
            border-radius: 14px;
            padding: 16px;
            background: #fff;
        }

        .status-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .status-code {
            font-weight: 800;
            color: #1e2330;
        }

        .status-badge {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 750;
            text-transform: capitalize;
            background: #f8f9fa;
            color: #555;
        }

        .status-badge.menunggu { background: #fff8e1; color: #a06200; }
        .status-badge.diproses { background: #e3f2fd; color: #1565c0; }
        .status-badge.selesai { background: #e8f5e9; color: #2e7d32; }
        .status-badge.dibatalkan { background: #ffebee; color: #c62828; }

        .status-card p {
            margin: 4px 0;
            color: #666;
            font-size: 13px;
            line-height: 1.5;
        }

        /* ===== CONTACT SECTION ===== */
        .contact-section {
            padding: 60px 0;
            background: #f8f9fa;
        }

        .contact-card {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .contact-card h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
            color: #1e2330;
        }

        .contact-card p {
            color: #888;
            text-align: center;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .contact-form .form-group {
            margin-bottom: 16px;
        }

        .contact-form label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            outline: none;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .contact-form button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
        }

        .contact-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #1e2330;
            color: #999;
            padding: 32px 0;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #ff6b35;
            text-decoration: none;
        }

        /* ===== ALERT ===== */
        .landing-alert {
            position: fixed;
            top: 80px;
            right: 24px;
            padding: 14px 24px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            z-index: 200;
            animation: slideIn 0.4s ease, fadeOut 0.4s ease 3s forwards;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .landing-alert-error {
            background: #ffebee;
            color: #c62828;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; transform: translateX(40px); }
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(16px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .menu-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 768px) {
            .menu-grid { grid-template-columns: repeat(2, 1fr); }
            .hero h1 { font-size: 28px; }
            .hero-card { padding: 32px 28px; }
            .navbar-search { margin: 0 16px; max-width: 300px; }
            .status-form { grid-template-columns: 1fr; }
            .status-submit { width: 100%; }
        }

        @media (max-width: 480px) {
            .menu-grid { grid-template-columns: 1fr; }
            .navbar-search { display: none; }
            .order-form-row,
            .order-modal-menu {
                grid-template-columns: 1fr;
            }
            .order-modal {
                padding: 14px;
            }
            .order-modal-dialog {
                padding: 20px;
            }
            .delivery-map-footer {
                align-items: stretch;
                flex-direction: column;
            }
            .location-btn {
                width: 100%;
            }
        }
    </style>
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
        // Category Filter
        document.querySelectorAll('.cat-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;
                const cards = document.querySelectorAll('.menu-card');

                cards.forEach(card => {
                    if (category === 'semua' || card.dataset.category === category) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.4s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search Menu
        document.getElementById('searchMenu').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.menu-card').forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(query) ? 'block' : 'none';
            });
        });

        // Order Modal
        const orderModal = document.getElementById('orderModal');
        const orderMenuId = document.getElementById('orderMenuId');
        const orderMenuName = document.getElementById('orderMenuName');
        const orderMenuDesc = document.getElementById('orderMenuDesc');
        const orderMenuPrice = document.getElementById('orderMenuPrice');
        const orderMenuStock = document.getElementById('orderMenuStock');
        const orderMenuImage = document.getElementById('orderMenuImage');
        const orderMenuPlaceholder = document.getElementById('orderMenuPlaceholder');
        const jumlahInput = document.getElementById('jumlah');
        const orderTotal = document.getElementById('orderTotal');
        const deliveryLatitude = document.getElementById('deliveryLatitude');
        const deliveryLongitude = document.getElementById('deliveryLongitude');
        const deliveryLocationText = document.getElementById('deliveryLocationText');
        const useCurrentLocation = document.getElementById('useCurrentLocation');
        const defaultDeliveryLocation = [-6.2, 106.816666];
        let activeMenuPrice = 0;
        let deliveryMap = null;
        let deliveryMarker = null;

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        };

        const updateOrderTotal = () => {
            const jumlah = Math.max(1, parseInt(jumlahInput.value || '1', 10));
            const max = parseInt(jumlahInput.max || '1', 10);
            jumlahInput.value = Math.min(jumlah, max);
            orderTotal.textContent = formatRupiah(activeMenuPrice * parseInt(jumlahInput.value, 10));
        };

        const updateDeliveryLocation = (lat, lng, shouldCenter = true) => {
            const fixedLat = Number(lat).toFixed(7);
            const fixedLng = Number(lng).toFixed(7);

            deliveryLatitude.value = fixedLat;
            deliveryLongitude.value = fixedLng;
            deliveryLocationText.textContent = `Titik dipilih: ${Number(lat).toFixed(5)}, ${Number(lng).toFixed(5)}`;

            if (!deliveryMap || !deliveryMarker) {
                return;
            }

            deliveryMarker.setLatLng([lat, lng]);

            if (shouldCenter) {
                deliveryMap.setView([lat, lng], 16);
            }
        };

        const initDeliveryMap = () => {
            if (!window.L) {
                deliveryLocationText.textContent = 'Map belum tersedia. Alamat tetap bisa dikirim.';
                return;
            }

            if (!deliveryMap) {
                const initialLocation = deliveryLatitude.value && deliveryLongitude.value
                    ? [Number(deliveryLatitude.value), Number(deliveryLongitude.value)]
                    : defaultDeliveryLocation;

                deliveryMap = L.map('deliveryMap', {
                    zoomControl: true,
                    attributionControl: false
                }).setView(initialLocation, 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(deliveryMap);

                deliveryMarker = L.marker(initialLocation, { draggable: true }).addTo(deliveryMap);
                deliveryMarker.on('dragend', function(event) {
                    const markerLocation = event.target.getLatLng();
                    updateDeliveryLocation(markerLocation.lat, markerLocation.lng, false);
                });

                deliveryMap.on('click', function(event) {
                    updateDeliveryLocation(event.latlng.lat, event.latlng.lng);
                });

                if (deliveryLatitude.value && deliveryLongitude.value) {
                    updateDeliveryLocation(deliveryLatitude.value, deliveryLongitude.value);
                }
            }

            setTimeout(() => deliveryMap.invalidateSize(), 150);
        };

        const openOrderModal = (card) => {
            activeMenuPrice = Number(card.dataset.price);

            orderMenuId.value = card.dataset.menuId;
            orderMenuName.textContent = card.dataset.title;
            orderMenuDesc.textContent = card.dataset.description || 'Tidak ada deskripsi menu.';
            orderMenuPrice.textContent = card.dataset.priceFormatted;
            orderMenuStock.textContent = `Stok ${card.dataset.stock}`;
            jumlahInput.max = card.dataset.stock;
            jumlahInput.value = 1;

            if (card.dataset.image) {
                orderMenuImage.src = card.dataset.image;
                orderMenuImage.alt = card.dataset.title;
                orderMenuImage.style.display = 'block';
                orderMenuPlaceholder.style.display = 'none';
            } else {
                orderMenuImage.removeAttribute('src');
                orderMenuImage.style.display = 'none';
                orderMenuPlaceholder.style.display = 'block';
            }

            updateOrderTotal();
            orderModal.classList.add('active');
            orderModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            initDeliveryMap();
            document.getElementById('nama_pelanggan').focus();
        };

        const closeOrderModal = () => {
            orderModal.classList.remove('active');
            orderModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        document.querySelectorAll('.menu-card').forEach(card => {
            card.addEventListener('click', () => openOrderModal(card));
        });

        document.querySelectorAll('.menu-card-add').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.stopPropagation();
                openOrderModal(this.closest('.menu-card'));
            });
        });

        document.querySelectorAll('[data-close-modal]').forEach(element => {
            element.addEventListener('click', closeOrderModal);
        });

        jumlahInput.addEventListener('input', updateOrderTotal);

        useCurrentLocation.addEventListener('click', function() {
            if (!navigator.geolocation) {
                deliveryLocationText.textContent = 'Browser tidak mendukung lokasi otomatis.';
                return;
            }

            deliveryLocationText.textContent = 'Mengambil lokasi Anda...';
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    updateDeliveryLocation(position.coords.latitude, position.coords.longitude);
                },
                function() {
                    deliveryLocationText.textContent = 'Lokasi otomatis gagal. Pilih titik dari map.';
                },
                { enableHighAccuracy: true, timeout: 8000 }
            );
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && orderModal.classList.contains('active')) {
                closeOrderModal();
            }
        });

        // Status Pesanan
        const statusModal = document.getElementById('statusModal');
        const openStatusModal = document.getElementById('openStatusModal');
        const statusForm = document.getElementById('statusForm');
        const statusResults = document.getElementById('statusResults');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const openCustomerStatusModal = () => {
            statusModal.classList.add('active');
            statusModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            document.getElementById('statusNoHp').focus();
        };

        const closeCustomerStatusModal = () => {
            statusModal.classList.remove('active');
            statusModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const escapeHtml = (value) => {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]));
        };

        const renderStatusOrders = (orders) => {
            if (!orders.length) {
                statusResults.innerHTML = '<div class="status-empty">Pesanan tidak ditemukan untuk nomor tersebut.</div>';
                return;
            }

            statusResults.innerHTML = orders.map(order => {
                const items = order.items.map(item => `${escapeHtml(item.nama || 'Menu')} x${escapeHtml(item.jumlah)}`).join(', ');
                const address = order.alamat ? `<p><strong>Alamat:</strong> ${escapeHtml(order.alamat)}</p>` : '';

                return `
                    <div class="status-card">
                        <div class="status-card-head">
                            <span class="status-code">${escapeHtml(order.kode)}</span>
                            <span class="status-badge ${escapeHtml(order.status)}">${escapeHtml(order.status_label)}</span>
                        </div>
                        <p><strong>Tanggal:</strong> ${escapeHtml(order.tanggal || '-')}</p>
                        <p><strong>Pesanan:</strong> ${items || '-'}</p>
                        <p><strong>Total:</strong> ${escapeHtml(order.total)}</p>
                        ${address}
                    </div>
                `;
            }).join('');
        };

        openStatusModal.addEventListener('click', openCustomerStatusModal);

        document.querySelectorAll('[data-close-status]').forEach(element => {
            element.addEventListener('click', closeCustomerStatusModal);
        });

        statusForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            statusResults.innerHTML = '<div class="status-empty">Mencari pesanan...</div>';

            try {
                const response = await fetch('{{ route('pesanan.status') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        no_hp: document.getElementById('statusNoHp').value,
                        kode_pesanan: document.getElementById('statusKode').value
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal mencari pesanan');
                }

                const data = await response.json();
                renderStatusOrders(data.orders || []);
            } catch (error) {
                statusResults.innerHTML = '<div class="status-empty">Status belum bisa dimuat. Coba beberapa saat lagi.</div>';
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && statusModal.classList.contains('active')) {
                closeCustomerStatusModal();
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
