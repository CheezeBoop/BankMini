<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Nasabah - Bank Mini Tsamaniyah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --success-green: #10b981;
            --warning-amber: #f59e0b;
            --danger-red: #ef4444;
            --light-bg: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.95);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 25px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" patternUnits="userSpaceOnUse" width="40" height="40"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>') repeat;
            z-index: -1;
            pointer-events: none;
        }

        /* Navigation */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-md);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary-blue) !important;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
        }

        .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.6rem;
            color: var(--warning-amber);
        }

        .nav-link {
            color: var(--text-primary) !important;
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
            margin: 0 0.2rem;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--primary-blue);
            color: white !important;
            transform: translateY(-1px);
        }

        /* Dashboard Header */
        .dashboard-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue), var(--success-green));
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
            box-shadow: var(--shadow-md);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Balance Card */
        .balance-card {
            background: linear-gradient(135deg, var(--success-green), #059669);
            color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .balance-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .balance-card:hover {
            transform: scale(1.02);
        }

        .balance-amount {
            font-size: 2.5rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
            font-family: 'Courier New', monospace;
        }

        .balance-label {
            opacity: 0.9;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .account-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .action-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            position: relative;
            z-index: 2;
        }

        .action-setor .action-icon {
            background: linear-gradient(135deg, var(--success-green), #059669);
        }

        .action-tarik .action-icon {
            background: linear-gradient(135deg, var(--danger-red), #dc2626);
        }

        .action-history .action-icon {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        }

        .action-profile .action-icon {
            background: linear-gradient(135deg, var(--warning-amber), #f97316);
        }

        /* Transaction History */
        .history-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .transaction-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .transaction-item:hover {
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.2);
            transform: translateX(4px);
        }

        .transaction-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-size: 1.1rem;
        }

        .transaction-setor .transaction-icon {
            background: var(--success-green);
        }

        .transaction-tarik .transaction-icon {
            background: var(--danger-red);
        }

        .transaction-pending .transaction-icon {
            background: var(--warning-amber);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .transaction-amount {
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }

        .transaction-amount.positive {
            color: var(--success-green);
        }

        .transaction-amount.negative {
            color: var(--danger-red);
        }

        .transaction-amount.pending {
            color: var(--warning-amber);
        }

        .transaction-date {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Status Badge */
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-aktif {
            background: var(--success-green);
            color: white;
        }

        .status-pending {
            background: var(--warning-amber);
            color: white;
            animation: pulse 2s infinite;
        }

        .status-nonaktif {
            background: var(--text-secondary);
            color: white;
        }

        /* Modals */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border: none;
            padding: 1.5rem 2rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            background: var(--light-bg);
            border: none;
        }

        /* Form Elements */
        .form-control {
            border-radius: 10px;
            border: 2px solid rgba(229, 231, 235, 0.8);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            background: var(--glass-bg);
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
            background: white;
            transform: scale(1.01);
        }

        .input-group-text {
            background: var(--light-bg);
            border: 2px solid rgba(229, 231, 235, 0.8);
            color: var(--primary-blue);
            font-weight: 600;
            border-radius: 10px 0 0 10px;
        }

        /* Buttons */
        .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-green), #059669);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-red), #dc2626);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-amber), #f97316);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Alerts */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border-left: 4px solid var(--success-green);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #991b1b;
            border-left: 4px solid var(--danger-red);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: #1e3a8a;
            border-left: 4px solid var(--primary-blue);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Loading Animation */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: var(--glass-bg);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(20px);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.2);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            font-family: 'Courier New', monospace;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .balance-amount {
                font-size: 2rem;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .action-card {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .transaction-item {
                padding: 0.75rem;
            }

            .user-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .balance-amount {
                font-size: 1.8rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .modal-body, .modal-header, .modal-footer {
                padding: 1rem;
            }
        }

        /* Animation Classes */
        .slide-in-up {
            animation: slideInUp 0.6s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
            }

            .navbar, .quick-actions, .modal {
                display: none !important;
            }

            .dashboard-header, .balance-card, .history-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('nasabah.dashboard') }}">
                <i class="fas fa-university"></i>
                Bank Mini Tsamaniyah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('nasabah.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showTransactionHistory()">
                            <i class="fas fa-history me-1"></i>Riwayat
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ $nasabah->nama ?? Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="showProfile()">
                                <i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showSettings()">
                                <i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Alerts -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show slide-in-up" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show slide-in-up" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show slide-in-up" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Dashboard Header -->
        <div class="dashboard-header slide-in-up">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="mb-2 fw-bold">Selamat Datang, {{ $nasabah ? $nasabah->nama : (Auth::user()->name ?? 'Nasabah') }}!</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar me-2"></i>{{ now()->format('l, d F Y') }}
                    </p>
                    @if($nasabah && $nasabah->status)
                    <div class="mt-2">
                        <span class="status-badge status-{{ strtolower($nasabah->status) }}">
                            {{ $nasabah->status }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-none d-md-block">
                        <i class="fas fa-clock me-1"></i>
                        <span id="currentTime">{{ now()->format('H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($rekening)
        <!-- Balance Card -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="balance-card slide-in-left">
                    <div class="balance-label">
                        <i class="fas fa-wallet me-2"></i>Saldo Rekening
                    </div>
                    <div class="balance-amount">
                        Rp {{ number_format($rekening->saldo, 0, ',', '.') }}
                    </div>
                    <div class="account-number mt-3">
                        <i class="fas fa-credit-card me-2"></i>{{ $rekening->no_rekening }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-grid">
                    <div class="stat-card slide-in-right">
                        <div class="stat-value">{{ $rekening && $rekening->transaksi ? $rekening->transaksi->where('status', 'CONFIRMED')->count() : 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-exchange-alt me-1"></i>Total Transaksi
                        </div>
                    </div>
                    <div class="stat-card slide-in-right" style="animation-delay: 0.1s;">
                        <div class="stat-value">{{ $rekening && $rekening->transaksi ? $rekening->transaksi->where('status', 'PENDING')->count() : 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions fade-in">
            <div class="action-card action-setor" data-bs-toggle="modal" data-bs-target="#setorModal">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <h5 class="fw-bold mb-2">Setor Tunai</h5>
                <p class="text-muted mb-0">Ajukan permintaan setor tunai</p>
            </div>
            
            <div class="action-card action-tarik" data-bs-toggle="modal" data-bs-target="#tarikModal">
                <div class="action-icon">
                    <i class="fas fa-minus"></i>
                </div>
                <h5 class="fw-bold mb-2">Tarik Tunai</h5>
                <p class="text-muted mb-0">Ajukan permintaan tarik tunai</p>
            </div>
            
            <div class="action-card action-history" onclick="showTransactionHistory()">
                <div class="action-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h5 class="fw-bold mb-2">Riwayat Transaksi</h5>
                <p class="text-muted mb-0">Lihat semua transaksi</p>
            </div>
            
            <div class="action-card action-profile" onclick="showProfile()">
                <div class="action-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h5 class="fw-bold mb-2">Profil Saya</h5>
                <p class="text-muted mb-0">Kelola informasi akun</p>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="history-card slide-in-up">
            <h4 class="mb-4">
                <i class="fas fa-history me-2"></i>Transaksi Terbaru
            </h4>
            
            @if($rekening && $rekening->transaksi && $rekening->transaksi->count() > 0)
                @foreach($rekening->transaksi->take(5) as $transaksi)
                <div class="transaction-item transaction-{{ strtolower($transaksi->jenis) }} 
                     {{ $transaksi->status == 'PENDING' ? 'transaction-pending' : '' }}">
                    <div class="transaction-icon">
                        @if($transaksi->jenis == 'SETOR')
                            <i class="fas fa-arrow-up"></i>
                        @else
                            <i class="fas fa-arrow-down"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    {{ $transaksi->jenis == 'SETOR' ? 'Setor Tunai' : 'Tarik Tunai' }}
                                    @if($transaksi->status == 'PENDING')
                                        <span class="status-badge status-pending ms-2">Pending</span>
                                    @endif
                                </h6>
                                <div class="transaction-date">
                                    {{ $transaksi->created_at->format('d M Y, H:i') }}
                                </div>
                                @if($transaksi->keterangan)
                                <small class="text-muted">{{ $transaksi->keterangan }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="transaction-amount 
                                     {{ $transaksi->jenis == 'SETOR' ? 'positive' : 'negative' }}
                                     {{ $transaksi->status == 'PENDING' ? 'pending' : '' }}">
                                    {{ $transaksi->jenis == 'SETOR' ? '+' : '-' }}Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                                </div>
                                @if($transaksi->status == 'CONFIRMED')
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Terkonfirmasi
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @if($rekening->transaksi->count() > 5)
                <div class="text-center mt-3">
                    <button class="btn btn-primary" onclick="showAllTransactions()">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Transaksi
                    </button>
                </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Transaksi</h5>
                    <p class="text-muted">Mulai dengan melakukan setor atau tarik tunai pertama Anda</p>
                </div>
            @endif
        </div>
        @else
        <!-- No Rekening Card -->
        <div class="empty-state">
            <i class="fas fa-credit-card" style="font-size: 4rem; margin-bottom: 2rem;"></i>
            <h3 class="mb-3">Rekening Belum Tersedia</h3>
            <p class="text-muted mb-4">Silakan hubungi teller untuk membuat rekening baru</p>
            <button class="btn btn-primary" onclick="contactTeller()">
                <i class="fas fa-phone me-2"></i>Hubungi Teller
            </button>
        </div>
        @endif
    </div>

    <!-- Modal Setor Tunai -->
    @if($rekening)
    <div class="modal fade" id="setorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Permintaan Setor Tunai
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('nasabah.deposit.request') }}" method="POST" id="setorForm">
                    @csrf
                    <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rekening Tujuan</label>
                            <input type="text" class="form-control" value="{{ $rekening->no_rekening }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Setor</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="nominal" id="setorNominal" 
                                       min="{{ $setting->minimal_setor ?? 1000 }}" 
                                       max="{{ $setting->maksimal_setor ?? 10000000 }}" 
                                       step="1000" required>
                            </div>
                            @if($setting)
                            <small class="form-text text-muted">
                                Min: Rp {{ number_format($setting->minimal_setor, 0, ',', '.') }} - 
                                Max: Rp {{ number_format($setting->maksimal_setor, 0, ',', '.') }}
                            </small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan (Opsional)</label>
                            <textarea class="form-control" name="keterangan" rows="3" 
                                      placeholder="Tambahkan keterangan untuk transaksi ini..."></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Permintaan setor tunai perlu dikonfirmasi oleh teller. 
                            Silakan datang ke kantor dengan uang tunai sesuai nominal yang diminta.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tarik Tunai -->
    <div class="modal fade" id="tarikModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-minus me-2"></i>Permintaan Tarik Tunai
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('nasabah.withdraw.request') }}" method="POST" id="tarikForm">
                    @csrf
                    <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rekening Sumber</label>
                            <input type="text" class="form-control" value="{{ $rekening->no_rekening }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Saldo Tersedia</label>
                            <input type="text" class="form-control" 
                                   value="Rp {{ number_format($rekening->saldo, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Tarik</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="nominal" id="tarikNominal"
                                       min="{{ $setting->minimal_tarik ?? 1000 }}" 
                                       max="{{ min($setting->maksimal_tarik ?? 5000000, $rekening->saldo) }}" 
                                       step="1000" required>
                            </div>
                            @if($setting)
                            <small class="form-text text-muted">
                                Min: Rp {{ number_format($setting->minimal_tarik, 0, ',', '.') }} - 
                                Max: Rp {{ number_format(min($setting->maksimal_tarik, $rekening->saldo), 0, ',', '.') }}
                            </small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan (Opsional)</label>
                            <textarea class="form-control" name="keterangan" rows="3" 
                                      placeholder="Tambahkan keterangan untuk transaksi ini..."></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Permintaan tarik tunai perlu dikonfirmasi oleh teller. 
                            Silakan datang ke kantor untuk mengambil uang tunai.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Profile -->
    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>Profil Nasabah
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($nasabah)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $nasabah->nama }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIS/NIP</label>
                                <input type="text" class="form-control" value="{{ $nasabah->nis_nip ?? '-' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" value="{{ $nasabah->email }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">No HP</label>
                                <input type="text" class="form-control" value="{{ $nasabah->no_hp ?? '-' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <input type="text" class="form-control" 
                                       value="{{ $nasabah->jenis_kelamin == 'L' ? 'Laki-laki' : ($nasabah->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <input type="text" class="form-control" value="{{ $nasabah->status }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control" rows="2" readonly>{{ $nasabah->alamat ?? '-' }}</textarea>
                            </div>
                        </div>
                        @if($rekening)
                        <div class="col-12">
                            <hr>
                            <h6 class="fw-bold mb-3">Informasi Rekening</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">No Rekening</label>
                                        <input type="text" class="form-control" value="{{ $rekening->no_rekening }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Buka</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $rekening->tanggal_buka ? \Carbon\Carbon::parse($rekening->tanggal_buka)->format('d M Y') : '-' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2 fw-bold">Memproses permintaan...</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Real-time clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const clockElement = document.getElementById('currentTime');
            if (clockElement) {
                clockElement.textContent = timeString;
            }
        }
        
        setInterval(updateClock, 1000);
        updateClock();

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Form submission with loading
            const forms = ['setorForm', 'tarikForm'];
            forms.forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    form.addEventListener('submit', function(e) {
                        showLoading();
                        
                        // Validate amounts
                        const nominal = parseInt(this.querySelector('input[name="nominal"]').value);
                        if (formId === 'tarikForm' && nominal > {{ $rekening->saldo ?? 0 }}) {
                            e.preventDefault();
                            hideLoading();
                            alert('Jumlah tarik melebihi saldo tersedia');
                            return;
                        }
                    });
                }
            });

            // Real-time validation for withdrawal amount
            const tarikNominal = document.getElementById('tarikNominal');
            if (tarikNominal) {
                tarikNominal.addEventListener('input', function() {
                    const amount = parseInt(this.value) || 0;
                    const maxAmount = {{ $rekening->saldo ?? 0 }};
                    const submitBtn = document.querySelector('#tarikForm button[type="submit"]');
                    
                    if (amount > maxAmount) {
                        this.classList.add('is-invalid');
                        if (submitBtn) submitBtn.disabled = true;
                    } else {
                        this.classList.remove('is-invalid');
                        if (submitBtn) submitBtn.disabled = false;
                    }
                });
            }
        });

        // Utility functions
        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        function showProfile() {
            new bootstrap.Modal(document.getElementById('profileModal')).show();
        }

        function showTransactionHistory() {
            @if($rekening)
            window.location.href = '#transaction-history';
            // Scroll to transaction history
            document.querySelector('.history-card').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            @else
            alert('Rekening belum tersedia');
            @endif
        }

        function showAllTransactions() {
            // This would typically redirect to a full transaction history page
            alert('Fitur riwayat lengkap akan segera tersedia');
        }

        function showSettings() {
            alert('Pengaturan akan segera tersedia');
        }

        function contactTeller() {
            alert('Silakan hubungi teller di nomor: 081234567890 atau datang langsung ke kantor');
        }

        // Format currency inputs
        function formatNumber(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // Add format listeners to number inputs
        document.addEventListener('DOMContentLoaded', function() {
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('input', function() {
                    formatNumber(this);
                });
            });
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation trigger on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.transaction-item, .stat-card');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Add tooltips for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Handle offline/online status
        function updateOnlineStatus() {
            const status = navigator.onLine ? 'online' : 'offline';
            if (status === 'offline') {
                const offlineAlert = document.createElement('div');
                offlineAlert.className = 'alert alert-warning position-fixed';
                offlineAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                offlineAlert.innerHTML = '<i class="fas fa-wifi me-2"></i>Koneksi terputus. Beberapa fitur mungkin tidak tersedia.';
                document.body.appendChild(offlineAlert);
                
                setTimeout(() => {
                    offlineAlert.remove();
                }, 5000);
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Security: Clear sensitive data on page unload
        window.addEventListener('beforeunload', function() {
            // Clear any sensitive form data
            const sensitiveInputs = document.querySelectorAll('input[type="password"], input[name="nominal"]');
            sensitiveInputs.forEach(input => {
                input.value = '';
            });
        });
    </script>
</body>
</html>