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

    <style>
        :root {
            --primary-green: #10b981;
            --primary-green-dark: #059669;
            --primary-green-light: #34d399;
            --secondary-blue: #3b82f6;
            --secondary-purple: #8b5cf6;
            --accent-orange: #f59e0b;
            --accent-red: #ef4444;

            --bg-white: #ffffff;
            --bg-light: #f8fafc;
            --bg-lighter: #f1f5f9;

            --text-dark: #1e293b;
            --text-muted: #64748b;

            --border-light: #e2e8f0;

            --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,.1);
            --shadow-xl: 0 20px 25px rgba(0,0,0,.1);

            --gradient-primary: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-secondary: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --gradient-accent: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-light: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            --gradient-blue-light: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        }

        /* reset */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            background: var(--bg-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ================== Sidebar ================== */
        .sidebar {
            position: fixed; left:0; top:0;
            width: 280px; height: 100vh;
            background: var(--gradient-primary);
            padding: 2rem 0; z-index: 1000;
            box-shadow: var(--shadow-xl);
            overflow-y: auto;
            will-change: transform;
            transition: transform .25s ease;
        }
        .sidebar-brand { padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,.15); margin-bottom: 2rem; }
        .sidebar-brand h2 { color:#fff; font-size:1.7rem; font-weight:800; display:flex; gap:.75rem; align-items:center; }
        .sidebar-brand p { color: rgba(255,255,255,.85); margin:.5rem 0 0; font-size:.9rem; }
        .sidebar-menu { list-style:none; padding: 0 1rem; }
        .sidebar-menu li { margin-bottom: .5rem; }
        .sidebar-menu a {
            display:flex; align-items:center; gap:1rem;
            padding: 1rem 1.25rem; color: rgba(255,255,255,.92);
            text-decoration:none; border-radius:12px; position:relative;
            transition: all .2s ease;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,.18); color:#fff; transform: translateX(4px); }
        .sidebar-menu a i { width:24px; text-align:center; font-size:1.2rem; }
        .sidebar-footer { padding: 2rem 1.5rem 1rem; margin-top: 2rem; border-top: 1px solid rgba(255,255,255,.15); color: rgba(255,255,255,.8); font-size:.8rem; text-align:center; }

        /* overlay untuk mobile */
        .sidebar-overlay{
            position:fixed; inset:0; background: rgba(0,0,0,.35);
            z-index: 900; display:none;
        }
        .sidebar-overlay.show { display:block; }
        .sidebar.open { transform: translateX(0) !important; }

        /* ================== Main ================== */
        .main-content { margin-left: 280px; padding: 2rem; min-height: 100vh; }
        .top-header {
            background:#fff; padding: 1rem 1.25rem;
            border-radius: 16px; box-shadow: var(--shadow-md);
            margin-bottom: 1rem; display:flex; justify-content:space-between; align-items:center; gap:1rem;
        }
        .page-title{ display:flex; align-items:center; gap:.75rem; }
        .page-title i{ font-size:2rem; color: var(--primary-green); }
        .page-title h1{ font-size: clamp(1.25rem, 2vw + .7rem, 2rem); font-weight:800; margin:0; }

        .header-actions{ display:flex; align-items:center; gap:.75rem; }
        .live-clock{
            background: var(--gradient-light); padding: .75rem 1rem; border-radius:12px; font-weight:600; color: var(--primary-green-dark);
            display:flex; align-items:center; gap:.6rem; box-shadow: var(--shadow-sm); white-space:nowrap;
        }

        /* ================== Stats ================== */
        .stats-grid{
            display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap: 1rem; margin-bottom: 1rem;
        }
        .stat-card{
            background:#fff; padding: 1.25rem; border-radius:16px; box-shadow: var(--shadow-md); display:flex; gap:1rem; align-items:center;
        }
        .stat-card-icon{
            width:58px; height:58px; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem;
        }
        .stat-card:nth-child(1) .stat-card-icon { background: var(--gradient-primary); }
        .stat-card:nth-child(2) .stat-card-icon { background: var(--gradient-secondary); }
        .stat-card:nth-child(3) .stat-card-icon { background: var(--gradient-accent); }
        .stat-card:nth-child(4) .stat-card-icon { background: var(--gradient-warning); }

        .stat-card-label{ font-size:.85rem; color:var(--text-muted); font-weight:700; text-transform:uppercase; letter-spacing:.5px; }
        .stat-card-value{ font-size:1.6rem; font-weight:800; color:var(--text-dark); }

        /* ================== Cards/Table ================== */
        .card{ background:#fff; border-radius:16px; box-shadow: var(--shadow-md); border:none; }
        .card-header{ background: var(--bg-lighter); border-bottom:1px solid var(--border-light); padding: 1rem 1.25rem; display:flex; justify-content:space-between; align-items:center; }
        .card-header h5{ margin:0; font-weight:800; display:flex; align-items:center; gap:.6rem; }
        .card-body{ padding: 1.25rem; }

        .search-form{ display:flex; gap:.6rem; }
        .search-form input{ flex:1; padding:.8rem 1rem; border:2px solid var(--border-light); border-radius:12px; }
        .search-form input:focus{ outline:none; border-color: var(--primary-green); box-shadow: 0 0 0 4px rgba(16,185,129,.1); }

        .table-responsive{ border-radius:12px; }
        .table{ margin:0; width:100%; border-collapse:separate; border-spacing:0; }
        .table thead{ background: var(--gradient-primary); color:#fff; }
        .table thead th{ padding: .9rem 1rem; border:none; white-space:nowrap; font-size:.85rem; text-transform:uppercase; letter-spacing:.4px; }
        .table tbody tr:nth-child(odd){ background: var(--bg-lighter); }
        .table tbody tr:hover{ background: var(--gradient-light); }
        .table tbody td{ padding: .9rem 1rem; border:none; vertical-align:middle; }
        .table thead th:first-child{ border-top-left-radius:12px; }
        .table thead th:last-child{ border-top-right-radius:12px; }

        .input-group{ display:flex; gap:.5rem; }
        .input-group input{
            flex:1; padding:.55rem .75rem; border:2px solid var(--border-light); border-radius:8px;
        }
        .input-group input:focus{ outline:none; border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(16,185,129,.1); }

        .badge{ padding:.45rem .7rem; border-radius:8px; font-weight:700; letter-spacing:.3px; font-size:.8rem; }
        .badge.bg-success{ background: var(--gradient-primary) !important; }
        .badge.bg-danger{ background: var(--gradient-warning) !important; }
        .amount-display{ font-weight:800; color: var(--primary-green-dark); }

        .status-indicator{ width:10px; height:10px; border-radius:50%; display:inline-block; margin-right:.5rem; }
        .status-indicator.active{ background: var(--primary-green); }
        .status-indicator.inactive{ background: var(--accent-red); }

        /* Pagination */
        .pagination{ display:flex; justify-content:center; gap:.4rem; padding: 1rem 0; }
        .pagination .page-link{ border:2px solid var(--border-light); border-radius:10px; color: var(--primary-green); font-weight:700; }
        .pagination .page-item.active .page-link{ background: var(--gradient-primary); color:#fff; border-color: var(--primary-green); }

        /* Charts */
        .charts-grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap:1rem; margin-bottom:1rem; }
        .chart-card{ background:#fff; padding: 1rem; border-radius:16px; box-shadow: var(--shadow-md); }
        .chart-card h6{ font-weight:800; display:flex; align-items:center; gap:.5rem; margin-bottom:.75rem; }
        .chart-container{ width:100%; height:300px; position:relative; }

        /* Modal */
        .modal-content{ border-radius:16px; border:none; box-shadow: var(--shadow-xl); }
        .modal-header{ background: var(--gradient-primary); color:#fff; border:none; border-radius:16px 16px 0 0; }
        .form-label{ font-weight:700; }

        /* Quick actions */
        .quick-actions{ display:flex; flex-wrap:wrap; gap:.5rem; }

        /* Responsive */
        @media (max-width: 1024px){
            .sidebar{ width:240px; }
            .main-content{ margin-left:240px; }
        }
        @media (max-width: 768px){
            .sidebar{ transform: translateX(-100%); }
            .main-content{ margin-left:0; padding: 1rem; }
            .top-header{ flex-wrap:wrap; }
            .table{ font-size:.9rem; }
            /* wrap kolom nama */
            .table tbody td:nth-child(2){ white-space: normal; }
        }

        @media (prefers-reduced-motion: reduce){
            *{ animation:none !important; transition:none !important; }
        }
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
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Nasabah</a></li>
            <li><a href="#"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Laporan</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="btn btn-link text-start p-0 m-0 w-100" style="border:none;background:none;color:inherit;">
                        <span style="display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;">
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
                <!-- tombol hamburger hanya mobile -->
                <button class="btn btn-sm d-md-none" id="btnSidebar" aria-label="Toggle Sidebar"
                        style="background: var(--gradient-primary); color:#fff;">
                    <i class="fas fa-bars"></i>
                </button>
                <i class="fas fa-chart-line"></i>
                <h1>Teller Dashboard</h1>
            </div>
            <div class="header-actions">
                <div class="live-clock">
                    <i class="fas fa-clock"></i>
                    <span id="current-time">Memuat waktu…</span>
                    <!-- seed waktu server (UTC) + TZ app (WIB default) -->
                    <span id="serverNow"
                          data-now="{{ now()->setTimezone('UTC')->format('c') }}"
                          data-tz="{{ config('app.timezone','Asia/Jakarta') }}"
                          class="d-none"></span>
                </div>
            </div>
        </div>

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
                    <button class="btn btn-info">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                    <button class="btn btn-warning">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                </div>
            </div>
        </div>

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
                </form>
            </div>
        </div>

        <!-- Daftar Nasabah -->
        <div class="card mb-3">
            <div class="card-header">
                <h5><i class="fas fa-users text-primary"></i> Daftar Nasabah</h5>
                <span class="badge bg-primary">{{ $nasabahs->total() }} Nasabah</span>
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
                                            <h5 class="modal-title">Edit Profil Nasabah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('teller.nasabah.update', $n->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"><i class="fas fa-id-card"></i> NIS/NIP</label>
                                                            <input type="text" name="nis_nip" class="form-control" value="{{ $n->nasabah->nis_nip ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"><i class="fas fa-user-check"></i> Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="AKTIF" @if(($n->nasabah->status ?? '') == 'AKTIF') selected @endif>AKTIF</option>
                                                                <option value="NONAKTIF" @if(($n->nasabah->status ?? '') == 'NONAKTIF') selected @endif>NONAKTIF</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" value="{{ $n->nasabah->nama ?? '' }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $n->nasabah->email ?? '' }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-phone"></i> No HP</label>
                                                    <input type="text" name="no_hp" class="form-control" value="{{ $n->nasabah->no_hp ?? '' }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                                    <textarea name="alamat" class="form-control" rows="3">{{ $n->nasabah->alamat ?? '' }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" class="form-select">
                                                        <option value="L" @if(($n->nasabah->jenis_kelamin ?? '') == 'L') selected @endif>Laki-laki</option>
                                                        <option value="P" @if(($n->nasabah->jenis_kelamin ?? '') == 'P') selected @endif>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users-slash" style="font-size:3rem;color:var(--primary-green-light)"></i>
                                        <h5 class="mt-2 mb-1">Belum Ada Nasabah</h5>
                                        <p class="mb-3">Mulai dengan membuat nasabah pertama Anda</p>
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

        <!-- Pending Transactions -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-clock text-warning"></i> Pending Transactions</h5>
                <span class="badge bg-warning">{{ $pending->count() }} Pending</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>No Rekening</th>
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
                                <td>{{ $p->rekening->no_rekening }}</td>
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
                                    <form method="POST" action="{{ route('teller.transaksi.confirm', $p->id) }}">
                                        @csrf
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Confirm</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-check-circle" style="font-size:3rem;color:#9ca3af"></i>
                                        <h5 class="mt-2 mb-1">Tidak Ada Transaksi Pending</h5>
                                        <p>Semua transaksi telah diproses</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- /main-content -->

    <!-- Modal Buat Nasabah Baru -->
    <div class="modal fade" id="buatNasabahModal" tabindex="-1" aria-labelledby="buatNasabahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buatNasabahModalLabel">Buat Nasabah Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('teller.nasabah.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
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
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div> <!-- /row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Nasabah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ======= Sidebar toggle (mobile) =======
        (function sidebarToggle(){
            const sb  = document.getElementById('sidebar');
            const btn = document.getElementById('btnSidebar');
            const ovl = document.getElementById('sidebarOverlay');
            if(!sb || !btn || !ovl) return;

            const open  = () => { sb.classList.add('open'); ovl.classList.add('show'); };
            const close = () => { sb.classList.remove('open'); ovl.classList.remove('show'); };

            btn.addEventListener('click', () => sb.classList.contains('open') ? close() : open());
            ovl.addEventListener('click', close);
            window.addEventListener('resize', () => { if (window.innerWidth > 768) close(); });
        })();

        // ======= WIB Clock seeded from server (accurate) =======
        (function initClock(){
            const seed = document.getElementById('serverNow');
            const target = document.getElementById('current-time');
            if(!seed || !target) return;

            const tz = seed.dataset.tz || 'Asia/Jakarta';
            const baseUTC = new Date(seed.dataset.now); // server ISO (UTC)
            const started = Date.now();

            const fmt = new Intl.DateTimeFormat('id-ID',{
                weekday:'long', day:'2-digit', month:'long', year:'numeric',
                hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false, timeZone: tz
            });

            function tick(){
                const now = new Date(baseUTC.getTime() + (Date.now() - started));
                target.textContent = fmt.format(now); // contoh: Rabu, 01 Oktober 2025 13:37:59
            }
            tick();
            setInterval(tick, 1000);
        })();

        // ======= Auto-dismiss alerts =======
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                try { new bootstrap.Alert(el).close(); } catch(e){}
            });
        }, 5000);

        // ======= Charts =======
        (function charts(){
            const txEl = document.getElementById('transactionChart');
            if (txEl){
                new Chart(txEl.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
                        datasets: [{
                            label: 'Jumlah Transaksi',
                            data: [65,59,80,81,56,55],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16,185,129,.12)',
                            borderWidth: 3,
                            tension: .35,
                            fill: true,
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive:true, maintainAspectRatio:false,
                        plugins: {
                            legend: { display:false },
                            tooltip: { padding:10, bodySpacing:4 }
                        },
                        scales: {
                            x: { grid: { display:false } },
                            y: { beginAtZero:true }
                        }
                    }
                });
            }

            const typeEl = document.getElementById('transactionTypeChart');
            if (typeEl){
                new Chart(typeEl.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Setor Tunai','Tarik Tunai','Transfer'],
                        datasets: [{
                            data: [55,30,15],
                            backgroundColor: ['#10b981','#ef4444','#3b82f6'],
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive:true, maintainAspectRatio:false,
                        plugins: {
                            legend: { position: window.innerWidth < 768 ? 'bottom' : 'top' }
                        },
                        cutout: '60%'
                    }
                });
            }
        })();

        // easter egg
        console.log('%c🏦 Teller Dashboard ready (Responsive + WIB time)',
            'color:#10b981;font-weight:700;font-size:12px');
    </script>
</body>
</html>
