@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-green: #2C5F2D;
        --primary-dark-green: #1a3a1b;
        --primary-light-green: #97BC62;
        --accent-gold: #FFD93D;
        --accent-yellow: #ffc107;
        --accent-red: #dc3545;
        --bg-white: #ffffff;
        --bg-cream: #FFF8E7;
        --bg-light: #f8f9fa;
        --text-dark: #212529;
        --text-grey: #495057;
        --text-light: #6c757d;
        --border-light: #dee2e6;
        --shadow-soft: 0 2px 8px rgba(0,0,0,.05);
        --shadow-medium: 0 4px 16px rgba(0,0,0,.12);
        --shadow-strong: 0 8px 32px rgba(0,0,0,.16);
        --gradient-green: linear-gradient(135deg, #2C5F2D 0%, #97BC62 100%);
        --gradient-gold: linear-gradient(135deg, #FFD93D 0%, #ffc107 100%);
        --gradient-cream: linear-gradient(135deg, #ffffff 0%, #FFF8E7 100%);
    }

    .settings-wrapper {
        background: var(--bg-cream);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .settings-container {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: var(--gradient-green);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-strong);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .page-header p {
        margin: 0.5rem 0 0;
        opacity: 0.95;
        position: relative;
        z-index: 1;
    }

    .alert-success {
        background: var(--gradient-cream);
        border: 2px solid var(--primary-light-green);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.5s ease-out;
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .settings-card {
        background: var(--bg-white);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: var(--shadow-medium);
        transition: all 0.3s ease;
    }

    .settings-card:hover {
        box-shadow: var(--shadow-strong);
        transform: translateY(-4px);
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .limit-group {
        background: var(--gradient-cream);
        border-radius: 20px;
        padding: 2rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .limit-group:hover {
        border-color: var(--primary-light-green);
        transform: scale(1.02);
    }

    .limit-group::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
        background: var(--gradient-green);
    }

    .limit-group.deposit::before {
        background: var(--gradient-green);
    }

    .limit-group.withdraw::before {
        background: var(--gradient-gold);
    }

    .limit-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.25rem;
    }

    .limit-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow-soft);
    }

    .deposit .limit-icon {
        background: var(--gradient-green);
        color: white;
    }

    .withdraw .limit-icon {
        background: var(--gradient-gold);
        color: var(--text-dark);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-grey);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        border: 2px solid var(--border-light);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        border-color: var(--primary-light-green);
        box-shadow: 0 0 0 4px rgba(151, 188, 98, 0.1);
        transform: translateY(-2px);
    }

    .input-group-custom {
        position: relative;
    }

    .currency-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-weight: 600;
        z-index: 10;
        pointer-events: none;
    }

    .form-control.with-prefix {
        padding-left: 3rem;
    }

    .btn-save {
        background: var(--gradient-green);
        border: none;
        border-radius: 16px;
        padding: 1rem 3rem;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        box-shadow: var(--shadow-medium);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-strong);
        background: var(--primary-dark-green);
        color: white;
    }

    .btn-save:active {
        transform: translateY(-1px);
    }

    .info-card {
        background: linear-gradient(135deg, rgba(255, 217, 61, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
        border: 2px solid var(--accent-gold);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .info-card-icon {
        width: 32px;
        height: 32px;
        background: var(--gradient-gold);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dark);
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 0.5rem 0;
        color: var(--text-grey);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-list li::before {
        content: '✓';
        color: var(--primary-green);
        font-weight: bold;
        font-size: 1.2rem;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 2px solid var(--border-light);
    }

    .btn-reset {
        background: white;
        border: 2px solid var(--border-light);
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: var(--text-grey);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-reset:hover {
        border-color: var(--text-grey);
        color: var(--text-dark);
        background: var(--bg-light);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            padding: 2rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .settings-card {
            padding: 1.5rem;
        }

        .action-bar {
            flex-direction: column-reverse;
            gap: 1rem;
        }

        .btn-save, .btn-reset {
            width: 100%;
            justify-content: center;
        }
    }

    .pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>

<div class="settings-wrapper">
    <div class="settings-container px-3">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="bi bi-gear-fill me-2"></i>Pengaturan Limit Transaksi</h1>
            <p>Kelola batasan minimal dan maksimal untuk transaksi setor dan tarik</p>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-title">
                <div class="info-card-icon">
                    <i class="bi bi-info-lg"></i>
                </div>
                <span>Informasi Penting</span>
            </div>
            <ul class="info-list">
                <li>Limit akan berlaku untuk semua transaksi nasabah</li>
                <li>Perubahan akan diterapkan secara real-time</li>
                <li>Pastikan nilai maksimal lebih besar dari minimal</li>
            </ul>
        </div>

        <!-- Settings Form -->
        <div class="settings-card">
            <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
                @csrf
                
                <div class="settings-grid">
                    <!-- Deposit Limits -->
                    <div class="limit-group deposit">
                        <div class="limit-title">
                            <div class="limit-icon">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </div>
                            <span>Limit Setor</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-dash-circle"></i>
                                Minimal Setor
                            </label>
                            <div class="input-group-custom">
                                <span class="currency-prefix">Rp</span>
                                <input type="number" 
                                       name="minimal_setor" 
                                       class="form-control with-prefix" 
                                       value="{{ old('minimal_setor', $setting->minimal_setor) }}"
                                       required
                                       min="0">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">
                                <i class="bi bi-plus-circle"></i>
                                Maksimal Setor
                            </label>
                            <div class="input-group-custom">
                                <span class="currency-prefix">Rp</span>
                                <input type="number" 
                                       name="maksimal_setor" 
                                       class="form-control with-prefix" 
                                       value="{{ old('maksimal_setor', $setting->maksimal_setor) }}"
                                       required
                                       min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Limits -->
                    <div class="limit-group withdraw">
                        <div class="limit-title">
                            <div class="limit-icon">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </div>
                            <span>Limit Tarik</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-dash-circle"></i>
                                Minimal Tarik
                            </label>
                            <div class="input-group-custom">
                                <span class="currency-prefix">Rp</span>
                                <input type="number" 
                                       name="minimal_tarik" 
                                       class="form-control with-prefix" 
                                       value="{{ old('minimal_tarik', $setting->minimal_tarik) }}"
                                       required
                                       min="0">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">
                                <i class="bi bi-plus-circle"></i>
                                Maksimal Tarik
                            </label>
                            <div class="input-group-custom">
                                <span class="currency-prefix">Rp</span>
                                <input type="number" 
                                       name="maksimal_tarik" 
                                       class="form-control with-prefix" 
                                       value="{{ old('maksimal_tarik', $setting->maksimal_tarik) }}"
                                       required
                                       min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.dashboard') }}" class="btn-reset">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Dashboard
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-save-fill"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Format currency display
    function formatCurrencyDisplay(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Add visual feedback on input focus
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Form submission with loading state
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-save');
        const originalContent = btn.innerHTML;
        
        // Validate max > min
        const minSetor = parseInt(document.querySelector('[name="minimal_setor"]').value);
        const maxSetor = parseInt(document.querySelector('[name="maksimal_setor"]').value);
        const minTarik = parseInt(document.querySelector('[name="minimal_tarik"]').value);
        const maxTarik = parseInt(document.querySelector('[name="maksimal_tarik"]').value);

        if (maxSetor <= minSetor) {
            e.preventDefault();
            alert('Maksimal Setor harus lebih besar dari Minimal Setor!');
            return;
        }

        if (maxTarik <= minTarik) {
            e.preventDefault();
            alert('Maksimal Tarik harus lebih besar dari Minimal Tarik!');
            return;
        }
        
        // Loading state
        btn.innerHTML = '<i class="bi bi-hourglass-split pulse"></i> Menyimpan...';
        btn.disabled = true;
    });
</script>

@endsection