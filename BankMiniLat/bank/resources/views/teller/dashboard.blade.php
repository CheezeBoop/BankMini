    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teller Dashboard - Bank Mini</title>

        <!-- Icons & CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Charts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

        <style>
            :root { --primary-green: #2C5F2D; --primary-dark-green: #1a3a1b; --primary-light-green: #97BC62; --accent-gold: #FFD93D; --accent-yellow: #ffc107; --accent-red: #dc3545; --bg-white: #ffffff; --bg-cream: #FFF8E7; --bg-light: #f8f9fa; --text-dark: #212529; --text-grey: #495057; --text-light: #6c757d; --border-light: #dee2e6; --shadow-soft: 0 2px 8px rgba(0,0,0,.05); --shadow-medium: 0 4px 16px rgba(0,0,0,.12); --shadow-strong: 0 8px 32px rgba(0,0,0,.16); --gradient-green: linear-gradient(135deg, #2C5F2D 0%, #97BC62 100%); --gradient-gold: linear-gradient(135deg, #FFD93D 0%, #ffc107 100%); --gradient-cream: linear-gradient(135deg, #ffffff 0%, #FFF8E7 100%); }
            * { margin:0; padding:0; box-sizing:border-box; }
            body { background: var(--bg-cream); font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: var(--text-dark); overflow-x: hidden; }
            .sidebar { position: fixed; left:0; top:0; width: 280px; height: 100vh; background: var(--gradient-green); padding: 2rem 0; z-index: 1000; box-shadow: var(--shadow-strong); overflow-y: auto; will-change: transform; transition: transform .25s ease; }
            .sidebar-brand { padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,.2); margin-bottom: 2rem; }
            .sidebar-brand h2 { color:#fff; font-size:1.7rem; font-weight:800; display:flex; gap:.75rem; align-items:center; }
            .sidebar-brand p { color: rgba(255,255,255,.9); margin:.5rem 0 0; font-size:.9rem; }
            .sidebar-menu { list-style:none; padding: 0 1rem; }
            .sidebar-menu li { margin-bottom: .5rem; }
            .sidebar-menu a, .sidebar-menu button { display:flex; align-items:center; gap:1rem; padding: 1rem 1.25rem; color: rgba(255,255,255,.92); text-decoration:none; border-radius:12px; position:relative; transition: all .2s ease; width:100%; border:none; background:transparent; text-align:left; cursor:pointer; }
            .sidebar-menu a:hover, .sidebar-menu a.active, .sidebar-menu button:hover, .sidebar-menu button.active { background: rgba(255,255,255,.2); color:#fff; transform: translateX(4px); }
            .sidebar-menu a i, .sidebar-menu button i { width:24px; text-align:center; font-size:1.2rem; }
            .sidebar-footer { padding: 2rem 1.5rem 1rem; margin-top: 2rem; border-top: 1px solid rgba(255,255,255,.2); color: rgba(255,255,255,.85); font-size:.8rem; text-align:center; }
            .sidebar-overlay{ position:fixed; inset:0; background: rgba(0,0,0,.4); z-index: 900; display:none; }
            .sidebar-overlay.show { display:block; }
            .sidebar.open { transform: translateX(0) !important; }
            .main-content { margin-left: 280px; padding: 2rem; min-height: 100vh; }
            .top-header { background: var(--gradient-cream); padding: 1.5rem 1.5rem; border-radius: 20px; box-shadow: var(--shadow-medium); margin-bottom: 2rem; display:flex; justify-content:space-between; align-items:center; gap:1rem; border: 2px solid var(--accent-gold); }
            .page-title{ display:flex; align-items:center; gap:.75rem; }
            .page-title i{ font-size:2rem; color: var(--primary-green); }
            .page-title h1{ font-size: clamp(1.25rem, 2vw + .7rem, 2rem); font-weight:800; margin:0; color: var(--primary-dark-green); }
            .header-actions{ display:flex; align-items:center; gap:.75rem; }
            .live-clock{ background: var(--bg-white); padding: .75rem 1.25rem; border-radius:12px; font-weight:600; color: var(--primary-green); display:flex; align-items:center; gap:.6rem; box-shadow: var(--shadow-soft); white-space:nowrap; border: 2px solid var(--primary-light-green); }
            .stats-grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(240px,1fr)); gap: 1.25rem; margin-bottom: 2rem; }
            .stat-card{ background: var(--bg-white); padding: 1.5rem; border-radius:20px; box-shadow: var(--shadow-medium); display:flex; gap:1rem; align-items:center; position:relative; overflow:hidden; border: 2px solid transparent; transition: all .3s ease; }
            .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-strong); }
            .stat-card::before { content:''; position:absolute; top:0; right:0; width:80px; height:80px; background: var(--primary-light-green); opacity:.1; border-radius:50%; transform: translate(30%, -30%); }
            .stat-card-icon{ width:64px; height:64px; border-radius:16px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.5rem; position:relative; z-index:1; }
            .stat-card:nth-child(1) .stat-card-icon { background: var(--gradient-green); }
            .stat-card:nth-child(1) { border-color: var(--primary-light-green); }
            .stat-card:nth-child(2) .stat-card-icon { background: var(--gradient-gold); }
            .stat-card:nth-child(2) { border-color: var(--accent-gold); }
            .stat-card:nth-child(3) .stat-card-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
            .stat-card:nth-child(3) { border-color: var(--accent-yellow); }
            .stat-card:nth-child(4) .stat-card-icon { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
            .stat-card:nth-child(4) { border-color: #3b82f6; }
            .stat-card-label{ font-size:.85rem; color:var(--text-grey); font-weight:700; text-transform:uppercase; letter-spacing:.5px; }
            .stat-card-value{ font-size:1.75rem; font-weight:800; color:var(--primary-dark-green); }
            .content-section { display: none; animation: fadeIn .3s ease; }
            .content-section.active { display: block; }
            @keyframes fadeIn { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform: translateY(0); } }
            .card{ background: var(--bg-white); border-radius:20px; box-shadow: var(--shadow-medium); border:2px solid var(--border-light); }
            .card-header{ background: var(--gradient-cream); border-bottom:2px solid var(--accent-gold); padding: 1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; border-radius: 18px 18px 0 0; }
            .card-header h5{ margin:0; font-weight:800; display:flex; align-items:center; gap:.6rem; color: var(--primary-dark-green); }
            .card-body{ padding: 1.5rem; }
            .search-form{ display:flex; gap:.75rem; }
            .search-form input{ flex:1; padding:1rem 1.25rem; border:2px solid var(--border-light); border-radius:12px; font-size:1rem; transition: all .3s ease; }
            .search-form input:focus{ outline:none; border-color: var(--primary-green); box-shadow: 0 0 0 4px rgba(44,95,45,.1); }
            .table-responsive{ border-radius:12px; }
            .table{ margin:0; width:100%; border-collapse:separate; border-spacing:0; }
            .table thead{ background: var(--gradient-green); color:#fff; }
            .table thead th{ padding: 1rem 1.25rem; border:none; white-space:nowrap; font-size:.85rem; text-transform:uppercase; letter-spacing:.5px; font-weight:700; }
            .table tbody tr{ transition: all .2s ease; }
            .table tbody tr:nth-child(odd){ background: var(--bg-light); }
            .table tbody tr:hover{ background: var(--bg-cream); transform: scale(1.01); box-shadow: var(--shadow-soft); }
            .table tbody td{ padding: 1rem 1.25rem; border:none; vertical-align:middle; }
            .table thead th:first-child{ border-top-left-radius:12px; }
            .table thead th:last-child{ border-top-right-radius:12px; }
            .input-group{ display:flex; gap:.5rem; }
            .input-group input{ flex:1; padding:.6rem .85rem; border:2px solid var(--border-light); border-radius:8px; transition: all .2s ease; }
            .input-group input:focus{ outline:none; border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(44,95,45,.1); }
            .badge{ padding:.5rem .85rem; border-radius:10px; font-weight:700; letter-spacing:.3px; font-size:.8rem; }
            .badge.bg-success{ background: var(--gradient-green) !important; }
            .badge.bg-danger{ background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; }
            .badge.bg-warning{ background: var(--gradient-gold) !important; color: var(--text-dark) !important; }
            .badge.bg-primary{ background: var(--gradient-green) !important; }
            .amount-display{ font-weight:800; color: var(--primary-green); }
            .status-indicator{ width:10px; height:10px; border-radius:50%; display:inline-block; margin-right:.5rem; }
            .status-indicator.active{ background: var(--primary-green); box-shadow: 0 0 8px var(--primary-light-green); }
            .status-indicator.inactive{ background: var(--accent-red); box-shadow: 0 0 8px var(--accent-red); }
            .pagination{ display:flex; justify-content:center; gap:.5rem; padding: 1rem 0; flex-wrap:wrap; }
            .pagination .page-link{ border:2px solid var(--primary-light-green); border-radius:10px; color: var(--primary-green); font-weight:700; padding:.5rem 1rem; transition: all .2s ease; }
            .pagination .page-link:hover { background: var(--bg-cream); }
            .pagination .page-item.active .page-link{ background: var(--gradient-green); color:#fff; border-color: var(--primary-green); }
            .charts-grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(300px,1fr)); gap:1.25rem; margin-bottom:2rem; }
            .chart-card{ background: var(--bg-white); padding: 1.5rem; border-radius:20px; box-shadow: var(--shadow-medium); border: 2px solid var(--border-light); transition: all .3s ease; }
            .chart-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-strong); }
            .chart-card h6{ font-weight:800; display:flex; align-items:center; gap:.6rem; margin-bottom:1rem; color: var(--primary-dark-green); }
            .chart-container{ width:100%; height:320px; position:relative; }
            .modal-content{ border-radius:20px; border:2px solid var(--primary-light-green); box-shadow: var(--shadow-strong); }
            .modal-header{ background: var(--gradient-green); color:#fff; border:none; border-radius:18px 18px 0 0; }
            .modal-header .btn-close { filter: brightness(0) invert(1); }
            .form-label{ font-weight:700; color: var(--text-grey); }
            .form-control, .form-select { border: 2px solid var(--border-light); border-radius:10px; padding:.75rem 1rem; transition: all .2s ease; }
            .form-control:focus, .form-select:focus { border-color: var(--primary-green); box-shadow: 0 0 0 4px rgba(44,95,45,.1); }
            .quick-actions{ display:flex; flex-wrap:wrap; gap:.75rem; }
            .btn { border-radius:12px; font-weight:600; padding:.75rem 1.25rem; transition: all .2s ease; border:none; }
            .btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-medium); }
            .btn-primary { background: var(--gradient-green); color:#fff; }
            .btn-primary:hover { background: var(--primary-dark-green); }
            .btn-success { background: var(--gradient-green); color:#fff; }
            .btn-success:hover { background: var(--primary-dark-green); }
            .btn-danger { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color:#fff; }
            .btn-info { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color:#fff; }
            .btn-warning { background: var(--gradient-gold); color: var(--text-dark); }
            .btn-secondary { background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); color:#fff; }
            .alert { border-radius:12px; border:none; box-shadow: var(--shadow-soft); display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; padding:1rem 1.25rem; }
            .alert i { font-size:1.5rem; }
            .alert-success { background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; border-left:4px solid #28a745; }
            .alert-danger { background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; border-left:4px solid #dc3545; }
            .empty-state { text-align:center; padding:3rem 1rem; color: var(--text-grey); }
            .empty-state i { font-size:4rem; color: var(--primary-light-green); margin-bottom:1rem; }
            .empty-state h5 { color: var(--primary-dark-green); font-weight:700; margin-bottom:.5rem; }
            .activity-feed { list-style:none; padding:0; }
            .activity-item { display:flex; gap:1rem; padding:1rem; background: var(--bg-light); border-radius:12px; margin-bottom:.75rem; border-left:4px solid var(--primary-green); transition: all .2s ease; }
            .activity-item:hover { background: var(--bg-cream); transform: translateX(4px); }
            .activity-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; background: var(--gradient-green); color:#fff; font-size:1.2rem; flex-shrink:0; }
            .activity-content { flex:1; }
            .activity-title { font-weight:700; color: var(--primary-dark-green); margin-bottom:.25rem; }
            .activity-meta { font-size:.85rem; color: var(--text-light); }
            .avatar-preview{width:96px;height:96px;border-radius:50%;overflow:hidden;background:#f8f9fa;border:2px dashed #dee2e6;display:flex;align-items:center;justify-content:center}
            .avatar-preview img{width:100%;height:100%;object-fit:cover;display:none}
            .avatar-initial{font-size:2rem;color:#6c757d}
            @media (max-width: 1024px){ .sidebar{ width:240px; } .main-content{ margin-left:240px; } }
            @media (max-width: 768px){ .sidebar{ transform: translateX(-100%); } .main-content{ margin-left:0; padding: 1rem; } .top-header{ flex-wrap:wrap; padding:1rem; } .table{ font-size:.9rem; } .table tbody td:nth-child(2){ white-space: normal; } .stat-card-value { font-size:1.5rem; } .stats-grid { grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap:1rem; } }
            @media (prefers-reduced-motion: reduce){ *{ animation:none !important; transition:none !important; } }
        </style>
    </head>
    <body>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h2><i class="fas fa-piggy-bank"></i> Bank Mini</h2>
                <p>Teller Dashboard System</p>
            </div>

            <ul class="sidebar-menu">
                <li><button class="nav-btn active" data-section="dashboard"><i class="fas fa-home"></i> Dashboard</button></li>
                <li><button class="nav-btn" data-section="nasabah"><i class="fas fa-users"></i> Nasabah</button></li>
                <li><button class="nav-btn" data-section="transaksi"><i class="fas fa-exchange-alt"></i> Transaksi</button></li>
                <li><button class="nav-btn" data-section="laporan"><i class="fas fa-chart-bar"></i> Laporan</button></li>
                <li><button class="nav-btn" data-section="pengaturan"><i class="fas fa-cog"></i> Pengaturan</button></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="btn btn-link text-start p-0 m-0 w-100" style="border:none;background:none;color:inherit;">
                            <span style="display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;color:rgba(255,255,255,.92);">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </span>
                        </button>
                    </form>
                </li>
            </ul>

            <div class="sidebar-footer">
                <p>&copy; {{ now()->year }} Bank Mini<br>All rights reserved</p>
            </div>
        </div>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Main -->
        <div class="main-content">
            <!-- Header -->
            <div class="top-header">
                <div class="page-title">
                    <button class="btn btn-sm d-md-none" id="btnSidebar" aria-label="Toggle Sidebar"
                            style="background: var(--gradient-green); color:#fff;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <i class="fas fa-chart-line"></i>
                    <h1 id="pageTitle">Dashboard</h1>
                </div>
                <div class="header-actions">
                    <div class="live-clock">
                        <i class="fas fa-clock"></i>
                        <span id="current-time">Memuat waktu…</span>
                        <span id="serverNow"
                            data-now="{{ now()->setTimezone('UTC')->format('c') }}"
                            data-tz="{{ config('app.timezone','Asia/Jakarta') }}"
                            class="d-none"></span>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- ==================== SECTION: DASHBOARD ==================== -->
            <div id="section-dashboard" class="content-section active">
                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="stat-card-label">Total Nasabah</div>
                            <div class="stat-card-value">{{ $nasabahs->total() }}</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div>
                            <div class="stat-card-label">Total Saldo</div>
                            <div class="stat-card-value">Rp {{ number_format($nasabahs->sum('saldo'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon"><i class="fas fa-exchange-alt"></i></div>
                        <div>
                            <div class="stat-card-label">Transaksi Pending</div>
                            <div class="stat-card-value">{{ $pending->count() }}</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon"><i class="fas fa-percentage"></i></div>
                        <div>
                            <div class="stat-card-label">Rata-rata Saldo</div>
                            <div class="stat-card-value">
                                Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <h6><i class="fas fa-chart-line text-primary"></i> Tren Transaksi Bulanan</h6>
                        <div class="chart-container">
                            <canvas id="transactionChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <h6><i class="fas fa-chart-pie text-warning"></i> Distribusi Jenis Transaksi</h6>
                        <div class="chart-container">
                            <canvas id="transactionTypeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-bolt text-warning"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buatNasabahModal">
                                <i class="fas fa-user-plus"></i> Buat Nasabah Baru
                            </button>
                            <button class="btn btn-info" onclick="window.print()">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                            <button class="btn btn-warning" onclick="exportToExcel('dashboard')">
                                <i class="fas fa-download"></i> Export Data
                            </button>
                            <button class="btn btn-success nav-btn" data-section="transaksi">
                                <i class="fas fa-exchange-alt"></i> Lihat Transaksi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                        <span class="badge bg-primary">{{ $pending->count() }} Pending</span>
                    </div>
                    <div class="card-body">
                        @if($pending->count() > 0)
                            <ul class="activity-feed">
                                @foreach($pending->take(5) as $p)
                                    <li class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-{{ $p->jenis === 'SETOR' ? 'arrow-down' : 'arrow-up' }}"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title">
                                                {{ $p->jenis }} - Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                            </div>
                                            <div class="activity-meta">
                                                {{ $p->rekening->no_rekening }} • {{ $p->created_at->timezone(config('app.timezone','Asia/Jakarta'))->diffForHumans() }}
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('teller.transaksi.confirm', $p->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <h5>Tidak Ada Aktivitas Pending</h5>
                                <p>Semua transaksi telah diproses</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION: NASABAH ==================== -->
            <div id="section-nasabah" class="content-section">
                <!-- Search -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" action="{{ route('teller.dashboard') }}" class="search-form">
                            <input type="text" name="search" class="form-control"
                                placeholder="🔍 Cari berdasarkan Nama / NIS / No Rekening"
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Daftar Nasabah -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-users text-primary"></i> Daftar Nasabah</h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">{{ $nasabahs->total() }} Nasabah</span>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#buatNasabahModal">
                                <i class="fas fa-user-plus"></i> Tambah Nasabah
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>No Rekening</th>
                                    <th>Nama</th>
                                    <th>Saldo</th>
                                    <th>Status</th>
                                    <th>Tanggal Buka</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($nasabahs as $n)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-credit-card text-primary"></i>
                                                <strong>{{ $n->no_rekening }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="status-indicator {{ ($n->nasabah->status ?? '') == 'AKTIF' ? 'active' : 'inactive' }}"></span>
                                                {{ $n->nasabah->nama ?? '-' }}
                                            </div>
                                        </td>
                                        <td><div class="amount-display">Rp {{ number_format($n->saldo, 0, ',', '.') }}</div></td>
                                        <td>
                                            <span class="badge {{ ($n->nasabah->status ?? '') == 'AKTIF' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $n->nasabah->status ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $n->tanggal_buka ? \Carbon\Carbon::parse($n->tanggal_buka)->format('d M Y') : '-' }}</td>
                                        <td>
                                            <div class="quick-actions">
                                                <!-- Setor -->
                                                <form method="POST" action="{{ route('teller.setor', $n->id) }}" class="d-inline">
                                                    @csrf
                                                    <div class="input-group mb-1">
                                                        <input type="number" inputmode="numeric" name="nominal" placeholder="Nominal" required class="form-control" min="1">
                                                        <button class="btn btn-success btn-sm"><i class="fas fa-arrow-down"></i> Setor</button>
                                                    </div>
                                                </form>
                                                <!-- Tarik -->
                                                <form method="POST" action="{{ route('teller.tarik', $n->id) }}" class="d-inline">
                                                    @csrf
                                                    <div class="input-group mb-1">
                                                        <input type="number" inputmode="numeric" name="nominal" placeholder="Nominal" required class="form-control" min="1" max="{{ $n->saldo }}">
                                                        <button class="btn btn-danger btn-sm"><i class="fas fa-arrow-up"></i> Tarik</button>
                                                    </div>
                                                </form>
                                                <!-- Edit -->
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNasabahModal{{ $n->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Nasabah -->
                                    <div class="modal fade" id="editNasabahModal{{ $n->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="fas fa-user-edit"></i> Edit Profil Nasabah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="{{ route('teller.nasabah.update', $n->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label"><i class="fas fa-id-card"></i> NIS/NIP</label>
                                                                <input type="text" name="nis_nip" class="form-control" value="{{ $n->nasabah->nis_nip ?? '' }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label"><i class="fas fa-user-check"></i> Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="AKTIF" @if(($n->nasabah->status ?? '') == 'AKTIF') selected @endif>AKTIF</option>
                                                                    <option value="NONAKTIF" @if(($n->nasabah->status ?? '') == 'NONAKTIF') selected @endif>NONAKTIF</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                                                <input type="text" name="nama" class="form-control" value="{{ $n->nasabah->nama ?? '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                                                <input type="email" name="email" class="form-control" value="{{ $n->nasabah->email ?? '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label"><i class="fas fa-phone"></i> No HP</label>
                                                                <input type="text" name="no_hp" class="form-control" value="{{ $n->nasabah->no_hp ?? '' }}">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                                                <textarea name="alamat" class="form-control" rows="3">{{ $n->nasabah->alamat ?? '' }}</textarea>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                                                <select name="jenis_kelamin" class="form-select">
                                                                    <option value="L" @if(($n->nasabah->jenis_kelamin ?? '') == 'L') selected @endif>Laki-laki</option>
                                                                    <option value="P" @if(($n->nasabah->jenis_kelamin ?? '') == 'P') selected @endif>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-users-slash"></i>
                                                <h5>Belum Ada Nasabah</h5>
                                                <p>Mulai dengan membuat nasabah pertama Anda</p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buatNasabahModal">
                                                    <i class="fas fa-user-plus"></i> Buat Nasabah Baru
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($nasabahs->hasPages())
                            <div class="p-3">
                                <nav>
                                    <ul class="pagination">
                                        @if($nasabahs->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fas fa-chevron-left"></i> Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $nasabahs->previousPageUrl() }}"><i class="fas fa-chevron-left"></i> Previous</a>
                                            </li>
                                        @endif

                                        @foreach($nasabahs->getUrlRange(1, $nasabahs->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $nasabahs->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if($nasabahs->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $nasabahs->nextPageUrl() }}">Next <i class="fas fa-chevron-right"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next <i class="fas fa-chevron-right"></i></span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION: TRANSAKSI ==================== -->
            <div id="section-transaksi" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-clock text-warning"></i> Transaksi Pending</h5>
                        <span class="badge bg-warning">{{ $pending->count() }} Pending</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No Rekening</th>
                                    <th>Nasabah</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($pending as $p)
                                    <tr>
                                        <td><strong>#{{ $p->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-credit-card" style="color: var(--primary-green);"></i>
                                                {{ $p->rekening->no_rekening }}
                                            </div>
                                        </td>
                                        <td>{{ $p->rekening->nasabah->nama ?? '-' }}</td>
                                        <td>
                                            @if($p->jenis === 'SETOR')
                                                <span class="badge bg-success"><i class="fas fa-arrow-down"></i> SETOR</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fas fa-arrow-up"></i> TARIK</span>
                                            @endif
                                        </td>
                                        <td class="amount-display">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $p->created_at->timezone(config('app.timezone','Asia/Jakarta'))->format('d M Y H:i') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('teller.transaksi.confirm', $p->id) }}" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Konfirmasi</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle"></i>
                                                <h5>Tidak Ada Transaksi Pending</h5>
                                                <p>Semua transaksi telah diproses dengan baik</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistik Transaksi -->
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-arrow-down" style="font-size:3rem;color:var(--primary-green);"></i>
                                <h3 class="mt-3 mb-1" style="color:var(--primary-dark-green);font-weight:800;">
                                    {{ $pending->where('jenis', 'SETOR')->count() }}
                                </h3>
                                <p class="text-muted mb-0">Setor Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-arrow-up" style="font-size:3rem;color:var(--accent-red);"></i>
                                <h3 class="mt-3 mb-1" style="color:var(--primary-dark-green);font-weight:800;">
                                    {{ $pending->where('jenis', 'TARIK')->count() }}
                                </h3>
                                <p class="text-muted mb-0">Tarik Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-money-bill-wave" style="font-size:3rem;color:var(--accent-gold);"></i>
                                <h3 class="mt-3 mb-1" style="color:var(--primary-dark-green);font-weight:800;">
                                    Rp {{ number_format($pending->sum('nominal'), 0, ',', '.') }}
                                </h3>
                                <p class="text-muted mb-0">Total Nominal Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION: LAPORAN ==================== -->
            <div id="section-laporan" class="content-section">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-chart-bar"></i> Laporan Keuangan</h5>
                            </div>
                            <div class="card-body">
                                <div class="charts-grid">
                                    <div class="chart-card">
                                        <h6><i class="fas fa-chart-line"></i> Tren Transaksi Bulanan</h6>
                                        <div class="chart-container">
                                            <canvas id="transactionChartLaporan"></canvas>
                                        </div>
                                    </div>
                                    <div class="chart-card">
                                        <h6><i class="fas fa-chart-pie"></i> Distribusi Jenis Transaksi</h6>
                                        <div class="chart-container">
                                            <canvas id="transactionTypeChartLaporan"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-users"></i> Statistik Nasabah</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><i class="fas fa-user-check text-success"></i> Nasabah Aktif</td>
                                        <td class="text-end"><strong>{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'AKTIF')->count() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-user-times text-danger"></i> Nasabah Non-Aktif</td>
                                        <td class="text-end"><strong>{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'NONAKTIF')->count() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-percentage text-primary"></i> Rata-rata Saldo</td>
                                        <td class="text-end"><strong>Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-arrow-up text-success"></i> Saldo Tertinggi</td>
                                        <td class="text-end"><strong>Rp {{ number_format($nasabahs->max('saldo') ?? 0, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-arrow-down text-warning"></i> Saldo Terendah</td>
                                        <td class="text-end"><strong>Rp {{ number_format($nasabahs->min('saldo') ?? 0, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-exchange-alt"></i> Statistik Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><i class="fas fa-clock text-warning"></i> Total Pending</td>
                                        <td class="text-end"><strong>{{ $pending->count() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-arrow-down text-success"></i> Setor Pending</td>
                                        <td class="text-end"><strong>{{ $pending->where('jenis', 'SETOR')->count() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-arrow-up text-danger"></i> Tarik Pending</td>
                                        <td class="text-end"><strong>{{ $pending->where('jenis', 'TARIK')->count() }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-money-bill-wave text-success"></i> Total Setor</td>
                                        <td class="text-end"><strong>Rp {{ number_format($pending->where('jenis', 'SETOR')->sum('nominal'), 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-money-bill-wave text-danger"></i> Total Tarik</td>
                                        <td class="text-end"><strong>Rp {{ number_format($pending->where('jenis', 'TARIK')->sum('nominal'), 0, ',', '.') }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-file-export"></i> Export Laporan</h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <button class="btn btn-success" onclick="window.print()">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                            <button class="btn btn-danger" onclick="exportToPDF('laporan')">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                            <button class="btn btn-primary" onclick="exportToExcel('laporan')">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button class="btn btn-warning" onclick="exportToCSV('laporan')">
                                <i class="fas fa-file-csv"></i> Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== SECTION: PENGATURAN ==================== -->
            <div id="section-pengaturan" class="content-section">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-user-cog"></i> Profil Teller</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div style="width:120px;height:120px;margin:0 auto;border-radius:50%;background:var(--gradient-green);display:flex;align-items:center;justify-content:center;color:#fff;font-size:3rem;box-shadow:var(--shadow-medium);">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <h4 class="mt-3 mb-1" style="color:var(--primary-dark-green);">{{ auth()->user()->name }}</h4>
                                    <p class="text-muted">{{ auth()->user()->email }}</p>
                                </div>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><i class="fas fa-user text-primary"></i> Role</td>
                                        <td class="text-end"><span class="badge bg-primary">Teller</span></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-calendar text-success"></i> Bergabung</td>
                                        <td class="text-end"><strong>{{ auth()->user()->created_at->format('d M Y') }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-info-circle"></i> Informasi Sistem</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="text-center p-3" style="background:var(--bg-light);border-radius:12px;">
                                            <i class="fas fa-server" style="font-size:2rem;color:var(--primary-green);"></i>
                                            <h6 class="mt-2 mb-1">Versi Sistem</h6>
                                            <p class="mb-0 text-muted">v1.0.0</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="text-center p-3" style="background:var(--bg-light);border-radius:12px;">
                                            <i class="fas fa-database" style="font-size:2rem;color:var(--accent-gold);"></i>
                                            <h6 class="mt-2 mb-1">Database</h6>
                                            <p class="mb-0 text-muted">MySQL 8.0</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="text-center p-3" style="background:var(--bg-light);border-radius:12px;">
                                            <i class="fas fa-shield-alt" style="font-size:2rem;color:var(--accent-red);"></i>
                                            <h6 class="mt-2 mb-1">Keamanan</h6>
                                            <p class="mb-0 text-muted">SSL Active</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- /main-content -->

        <!-- Modal Buat Nasabah Baru -->
        <div class="modal fade" id="buatNasabahModal" tabindex="-1" aria-labelledby="buatNasabahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buatNasabahModalLabel"><i class="fas fa-user-plus"></i> Buat Nasabah Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('teller.nasabah.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="mb-3">
                                <label class="form-label"><i class="fas fa-image"></i> Foto Nasabah (opsional)</label>
                                <div class="d-flex gap-3 align-items-center flex-wrap">
                                    <div class="avatar-preview">
                                    <img id="previewPhoto" alt="preview" style="display:none">
                                    <span id="previewInitial" class="avatar-initial"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="file" name="photo" id="photoInput" class="form-control"
                                        accept="image/png,image/jpeg,image/jpg,image/webp">
                                    <small class="text-muted d-block">Format: JPG/PNG/WEBP • Maks 2MB • Min 256×256</small>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-money-bill-wave"></i> Saldo Awal</label>
                                    <input type="number" name="saldo" class="form-control" value="0" required min="0" inputmode="numeric">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-id-card"></i> NIS/NIP</label>
                                    <input type="text" name="nis_nip" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-phone"></i> No HP</label>
                                    <input type="text" name="no_hp" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class ="form-select">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Buat Nasabah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // ======= Navigation System =======
            (function initNavigation(){
                const sections = document.querySelectorAll('.content-section');
                const navBtns = document.querySelectorAll('.nav-btn');
                const pageTitle = document.getElementById('pageTitle');

                const titleMap = {
                    'dashboard': 'Dashboard',
                    'nasabah': 'Manajemen Nasabah',
                    'transaksi': 'Transaksi Pending',
                    'laporan': 'Laporan Keuangan',
                    'pengaturan': 'Pengaturan'
                };

                function showSection(sectionId) {
                    sections.forEach(s => s.classList.remove('active'));
                    navBtns.forEach(btn => btn.classList.remove('active'));

                    const targetSection = document.getElementById('section-' + sectionId);
                    if (targetSection) {
                        targetSection.classList.add('active');
                        pageTitle.textContent = titleMap[sectionId] || 'Dashboard';
                        
                        // Update active button
                        navBtns.forEach(btn => {
                            if (btn.dataset.section === sectionId) {
                                btn.classList.add('active');
                            }
                        });

                        // Scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });

                        // Close sidebar on mobile
                        if (window.innerWidth <= 768) {
                            closeSidebar();
                        }

                        // Initialize charts if showing laporan section
                        if (sectionId === 'laporan') {
                            setTimeout(initLaporanCharts, 100);
                        }
                    }
                }

                navBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const section = btn.dataset.section;
                        if (section) {
                            showSection(section);
                        }
                    });
                });

                // Check URL hash on load
                const hash = window.location.hash.substring(1);
                if (hash && titleMap[hash]) {
                    showSection(hash);
                }
            })();

            // ======= Sidebar toggle (mobile) =======
            const sb = document.getElementById('sidebar');
            const btn = document.getElementById('btnSidebar');
            const ovl = document.getElementById('sidebarOverlay');

            function openSidebar() {
                if (sb && ovl) {
                    sb.classList.add('open');
                    ovl.classList.add('show');
                }
            }

            function closeSidebar() {
                if (sb && ovl) {
                    sb.classList.remove('open');
                    ovl.classList.remove('show');
                }
            }

            if (btn) {
                btn.addEventListener('click', () => {
                    sb.classList.contains('open') ? closeSidebar() : openSidebar();
                });
            }

            if (ovl) {
                ovl.addEventListener('click', closeSidebar);
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) closeSidebar();
            });

            // ======= WIB Clock seeded from server =======
            (function initClock(){
                const seed = document.getElementById('serverNow');
                const target = document.getElementById('current-time');
                if(!seed || !target) return;

                const tz = seed.dataset.tz || 'Asia/Jakarta';
                const baseUTC = new Date(seed.dataset.now);
                const started = Date.now();

                const fmt = new Intl.DateTimeFormat('id-ID',{
                    weekday:'long', day:'2-digit', month:'long', year:'numeric',
                    hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false, timeZone: tz
                });

                function tick(){
                    const now = new Date(baseUTC.getTime() + (Date.now() - started));
                    target.textContent = fmt.format(now);
                }
                tick();
                setInterval(tick, 1000);
            })();

            // ======= Auto-dismiss alerts =======
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(el => {
                    try { 
                        const alert = bootstrap.Alert.getOrCreateInstance(el);
                        alert.close();
                    } catch(e){}
                });
            }, 5000);

            // ======= Charts =======
            let transactionChartInstance = null;
            let transactionTypeChartInstance = null;
            let transactionChartLaporanInstance = null;
            let transactionTypeChartLaporanInstance = null;

            (function initDashboardCharts(){
                const txEl = document.getElementById('transactionChart');
                if (txEl && !transactionChartInstance){
                    transactionChartInstance = new Chart(txEl.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: [0,0,0,0,0,{{ $pending->count() }}],
                                borderColor: '#2C5F2D',
                                backgroundColor: 'rgba(44,95,45,.15)',
                                borderWidth: 3,
                                tension: .4,
                                fill: true,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#2C5F2D',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive:true, 
                            maintainAspectRatio:false,
                            plugins: {
                                legend: { display:false },
                                tooltip: { 
                                    padding:12, 
                                    bodySpacing:6,
                                    backgroundColor: 'rgba(44,95,45,.95)',
                                    titleColor: '#FFD93D',
                                    bodyColor: '#fff',
                                    borderColor: '#FFD93D',
                                    borderWidth: 2,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                x: { 
                                    grid: { display:false },
                                    ticks: { color: '#495057', font: { weight: '600' } }
                                },
                                y: { 
                                    beginAtZero:true,
                                    ticks: { color: '#495057', font: { weight: '600' } },
                                    grid: { color: 'rgba(0,0,0,.05)' }
                                }
                            }
                        }
                    });
                }

                const typeEl = document.getElementById('transactionTypeChart');
                if (typeEl && !transactionTypeChartInstance){
                    const setorCount = {{ $pending->where('jenis', 'SETOR')->count() }};
                    const tarikCount = {{ $pending->where('jenis', 'TARIK')->count() }};
                    
                    transactionTypeChartInstance = new Chart(typeEl.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Setor Tunai','Tarik Tunai'],
                            datasets: [{
                                data: [setorCount, tarikCount],
                                backgroundColor: ['#2C5F2D','#dc3545'],
                                borderWidth: 0,
                                hoverOffset: 12
                            }]
                        },
                        options: {
                            responsive:true, 
                            maintainAspectRatio:false,
                            plugins: {
                                legend: { 
                                    position: window.innerWidth < 768 ? 'bottom' : 'top',
                                    labels: {
                                        padding: 15,
                                        font: { size: 13, weight: '600' },
                                        color: '#212529'
                                    }
                                },
                                tooltip: {
                                    padding:12,
                                    backgroundColor: 'rgba(44,95,45,.95)',
                                    titleColor: '#FFD93D',
                                    bodyColor: '#fff',
                                    borderColor: '#FFD93D',
                                    borderWidth: 2,
                                    cornerRadius: 8
                                }
                            },
                            cutout: '65%'
                        }
                    });
                }
            })();

            function initLaporanCharts(){
                const txLapEl = document.getElementById('transactionChartLaporan');
                if (txLapEl && !transactionChartLaporanInstance){
                    transactionChartLaporanInstance = new Chart(txLapEl.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: [0,0,0,0,0,{{ $pending->count() }}],
                                borderColor: '#2C5F2D',
                                backgroundColor: 'rgba(44,95,45,.15)',
                                borderWidth: 3,
                                tension: .4,
                                fill: true,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#2C5F2D',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive:true, 
                            maintainAspectRatio:false,
                            plugins: {
                                legend: { display:false },
                                tooltip: { 
                                    padding:12, 
                                    bodySpacing:6,
                                    backgroundColor: 'rgba(44,95,45,.95)',
                                    titleColor: '#FFD93D',
                                    bodyColor: '#fff',
                                    borderColor: '#FFD93D',
                                    borderWidth: 2,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                x: { 
                                    grid: { display:false },
                                    ticks: { color: '#495057', font: { weight: '600' } }
                                },
                                y: { 
                                    beginAtZero:true,
                                    ticks: { color: '#495057', font: { weight: '600' } },
                                    grid: { color: 'rgba(0,0,0,.05)' }
                                }
                            }
                        }
                    });
                }

                const typeLapEl = document.getElementById('transactionTypeChartLaporan');
                if (typeLapEl && !transactionTypeChartLaporanInstance){
                    const setorCount = {{ $pending->where('jenis', 'SETOR')->count() }};
                    const tarikCount = {{ $pending->where('jenis', 'TARIK')->count() }};
                    
                    transactionTypeChartLaporanInstance = new Chart(typeLapEl.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Setor Tunai','Tarik Tunai'],
                            datasets: [{
                                data: [setorCount, tarikCount],
                                backgroundColor: ['#2C5F2D','#dc3545'],
                                borderWidth: 0,
                                hoverOffset: 12
                            }]
                        },
                        options: {
                            responsive:true, 
                            maintainAspectRatio:false,
                            plugins: {
                                legend: { 
                                    position: window.innerWidth < 768 ? 'bottom' : 'top',
                                    labels: {
                                        padding: 15,
                                        font: { size: 13, weight: '600' },
                                        color: '#212529'
                                    }
                                },
                                tooltip: {
                                    padding:12,
                                    backgroundColor: 'rgba(44,95,45,.95)',
                                    titleColor: '#FFD93D',
                                    bodyColor: '#fff',
                                    borderColor: '#FFD93D',
                                    borderWidth: 2,
                                    cornerRadius: 8
                                }
                            },
                            cutout: '65%'
                        }
                    });
                }
            }

            // ======= Export Functions =======
            function exportToPDF(type) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                // Set judul berdasarkan tipe
                let title = '';
                let headers = [];
                let data = [];
                
                if (type === 'laporan') {
                    title = 'LAPORAN KEUANGAN BANK MINI';
                    doc.setFontSize(16);
                    doc.text(title, 105, 15, { align: 'center' });
                    
                    // Statistik Nasabah
                    doc.setFontSize(12);
                    doc.text('STATISTIK NASABAH', 20, 30);
                    doc.autoTable({
                        startY: 35,
                        head: [['Keterangan', 'Jumlah']],
                        body: [
                            ['Nasabah Aktif', '{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'AKTIF')->count() }}'],
                            ['Nasabah Non-Aktif', '{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'NONAKTIF')->count() }}'],
                            ['Rata-rata Saldo', 'Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}'],
                            ['Saldo Tertinggi', 'Rp {{ number_format($nasabahs->max('saldo') ?? 0, 0, ',', '.') }}'],
                            ['Saldo Terendah', 'Rp {{ number_format($nasabahs->min('saldo') ?? 0, 0, ',', '.') }}']
                        ],
                        theme: 'grid',
                        styles: { fontSize: 10, cellPadding: 3 },
                        headStyles: { fillColor: [44, 95, 45] }
                    });
                    
                    // Statistik Transaksi
                    const lastY = doc.lastAutoTable.finalY + 10;
                    doc.text('STATISTIK TRANSAKSI', 20, lastY);
                    doc.autoTable({
                        startY: lastY + 5,
                        head: [['Keterangan', 'Jumlah']],
                        body: [
                            ['Total Pending', '{{ $pending->count() }}'],
                            ['Setor Pending', '{{ $pending->where('jenis', 'SETOR')->count() }}'],
                            ['Tarik Pending', '{{ $pending->where('jenis', 'TARIK')->count() }}'],
                            ['Total Setor', 'Rp {{ number_format($pending->where('jenis', 'SETOR')->sum('nominal'), 0, ',', '.') }}'],
                            ['Total Tarik', 'Rp {{ number_format($pending->where('jenis', 'TARIK')->sum('nominal'), 0, ',', '.') }}']
                        ],
                        theme: 'grid',
                        styles: { fontSize: 10, cellPadding: 3 },
                        headStyles: { fillColor: [44, 95, 45] }
                    });
                    
                    // Footer
                    const finalY = doc.lastAutoTable.finalY + 15;
                    doc.setFontSize(10);
                    doc.text(`Dicetak pada: ${new Date().toLocaleString('id-ID')}`, 20, finalY);
                    doc.text('Bank Mini - Teller Dashboard System', 105, finalY, { align: 'center' });
                }
                
                doc.save(`Laporan_Bank_Mini_${new Date().toISOString().split('T')[0]}.pdf`);
            }

            function exportToExcel(type) {
                let data = [];
                let filename = '';
                
                if (type === 'laporan') {
                    filename = 'Laporan_Keuangan_Bank_Mini';
                    
                    // Data statistik nasabah
                    const nasabahData = [
                        ['STATISTIK NASABAH', ''],
                        ['Nasabah Aktif', '{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'AKTIF')->count() }}'],
                        ['Nasabah Non-Aktif', '{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'NONAKTIF')->count() }}'],
                        ['Rata-rata Saldo', 'Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}'],
                        ['Saldo Tertinggi', 'Rp {{ number_format($nasabahs->max('saldo') ?? 0, 0, ',', '.') }}'],
                        ['Saldo Terendah', 'Rp {{ number_format($nasabahs->min('saldo') ?? 0, 0, ',', '.') }}'],
                        ['', ''],
                        ['STATISTIK TRANSAKSI', ''],
                        ['Total Pending', '{{ $pending->count() }}'],
                        ['Setor Pending', '{{ $pending->where('jenis', 'SETOR')->count() }}'],
                        ['Tarik Pending', '{{ $pending->where('jenis', 'TARIK')->count() }}'],
                        ['Total Setor', 'Rp {{ number_format($pending->where('jenis', 'SETOR')->sum('nominal'), 0, ',', '.') }}'],
                        ['Total Tarik', 'Rp {{ number_format($pending->where('jenis', 'TARIK')->sum('nominal'), 0, ',', '.') }}']
                    ];
                    
                    data = nasabahData;
                } else if (type === 'dashboard') {
                    filename = 'Data_Dashboard_Bank_Mini';
                    
                    // Data dashboard
                    const dashboardData = [
                        ['STATISTIK DASHBOARD', ''],
                        ['Total Nasabah', '{{ $nasabahs->total() }}'],
                        ['Total Saldo', 'Rp {{ number_format($nasabahs->sum('saldo'), 0, ',', '.') }}'],
                        ['Transaksi Pending', '{{ $pending->count() }}'],
                        ['Rata-rata Saldo', 'Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}'],
                        ['', ''],
                        ['TRANSAKSI TERBARU', ''],
                    ];
                    
                    // Tambahkan data transaksi pending
                    @foreach($pending->take(10) as $p)
                    dashboardData.push(['{{ $p->jenis }} - {{ $p->rekening->no_rekening }}', 'Rp {{ number_format($p->nominal, 0, ',', '.') }}']);
                    @endforeach
                    
                    data = dashboardData;
                }
                
                // Buat worksheet
                const ws = XLSX.utils.aoa_to_sheet(data);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Laporan");
                
                // Export ke file
                XLSX.writeFile(wb, `${filename}_${new Date().toISOString().split('T')[0]}.xlsx`);
            }

            function exportToCSV(type) {
                let csvContent = '';
                let filename = '';
                
                if (type === 'laporan') {
                    filename = 'Laporan_Keuangan_Bank_Mini';
                    
                    csvContent = 'STATISTIK NASABAH\n';
                    csvContent += 'Keterangan,Jumlah\n';
                    csvContent += `Nasabah Aktif,{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'AKTIF')->count() }}\n`;
                    csvContent += `Nasabah Non-Aktif,{{ $nasabahs->filter(fn($n) => ($n->nasabah->status ?? '') == 'NONAKTIF')->count() }}\n`;
                    csvContent += `Rata-rata Saldo,Rp {{ $nasabahs->count() > 0 ? number_format($nasabahs->avg('saldo'), 0, ',', '.') : '0' }}\n`;
                    csvContent += `Saldo Tertinggi,Rp {{ number_format($nasabahs->max('saldo') ?? 0, 0, ',', '.') }}\n`;
                    csvContent += `Saldo Terendah,Rp {{ number_format($nasabahs->min('saldo') ?? 0, 0, ',', '.') }}\n\n`;
                    
                    csvContent += 'STATISTIK TRANSAKSI\n';
                    csvContent += 'Keterangan,Jumlah\n';
                    csvContent += `Total Pending,{{ $pending->count() }}\n`;
                    csvContent += `Setor Pending,{{ $pending->where('jenis', 'SETOR')->count() }}\n`;
                    csvContent += `Tarik Pending,{{ $pending->where('jenis', 'TARIK')->count() }}\n`;
                    csvContent += `Total Setor,Rp {{ number_format($pending->where('jenis', 'SETOR')->sum('nominal'), 0, ',', '.') }}\n`;
                    csvContent += `Total Tarik,Rp {{ number_format($pending->where('jenis', 'TARIK')->sum('nominal'), 0, ',', '.') }}\n`;
                }
                
                // Buat blob dan download
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `${filename}_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            // ======= Form validation helpers =======
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                    }
                });
            });

            // ======= Number input formatting =======
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value && this.value < 0) {
                        this.value = 0;
                    }
                });
            });

            (function(){
            const input=document.getElementById('photoInput');
            const img=document.getElementById('previewPhoto');
            const ph=document.getElementById('previewInitial');
            if(!input||!img||!ph) return;

            input.addEventListener('change',function(){
                const f=this.files&&this.files[0];
                if(!f){img.style.display='none';ph.style.display='flex';return;}
                const ok=['image/jpeg','image/png','image/webp'];
                if(!ok.includes(f.type)){alert('Format tidak didukung. Gunakan JPG/PNG/WEBP.');this.value='';img.style.display='none';ph.style.display='flex';return;}
                if(f.size>2*1024*1024){alert('Ukuran maksimal 2MB');this.value='';img.style.display='none';ph.style.display='flex';return;}
                const r=new FileReader();
                r.onload=e=>{img.src=e.target.result;img.style.display='block';ph.style.display='none';};
                r.readAsDataURL(f);
            });
            })();

            // Console log
            console.log('%c🏦 Bank Mini Teller Dashboard', 'color:#2C5F2D;font-weight:800;font-size:16px;');
            console.log('%c✓ Navigation System Active', 'color:#97BC62;font-weight:600;font-size:12px;');
            console.log('%c✓ Real-time Clock Active', 'color:#97BC62;font-weight:600;font-size:12px;');
            console.log('%c✓ Charts Initialized', 'color:#97BC62;font-weight:600;font-size:12px;');
            console.log('%c✓ Export Functions Ready', 'color:#97BC62;font-weight:600;font-size:12px;');
        </script>
    </body>
    </html>