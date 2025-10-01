@extends('layouts.app')

@section('content')
<style>
  @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
  
  :root {
    --green-primary: #10b981;
    --green-dark: #059669;
    --cream-light: #fef3c7;
    --cream-dark: #fde68a;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
    --shadow-lg: 0 8px 32px rgba(0,0,0,0.16);
    --bg-soft: linear-gradient(135deg, #f0fdf4 0%, #fef3c7 100%);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--bg-soft);
    min-height: 100vh;
  }

  .dashboard-wrapper{ display:flex; min-height:100vh; }

  /* ============ SIDEBAR ============ */
  .sidebar{
    width:280px; background:#fff; box-shadow:var(--shadow-md);
    position:fixed; inset:0 auto 0 0; height:100vh; overflow-y:auto; z-index:1000;
    transition:transform .3s ease; will-change:transform;
  }
  .sidebar-header{ padding:24px; border-bottom:1px solid #e5e7eb;
    background:linear-gradient(135deg, var(--green-primary), var(--green-dark)); color:#fff; }
  .sidebar-brand{ font-size:24px; font-weight:700; display:flex; gap:12px; align-items:center; }
  .sidebar-brand i{ font-size:32px; }

  .sidebar-menu{ padding:16px 0; }
  .menu-item{
    padding:14px 24px; display:flex; align-items:center; gap:12px;
    color:#4b5563; text-decoration:none; transition:all .3s ease;
    border-left:4px solid transparent; cursor:pointer;
  }
  .menu-item i{ font-size:20px; width:24px; }
  .menu-item:hover{ background:#f9fafb; color:var(--green-primary); border-left-color:var(--green-primary); }
  .menu-item.active{ background:#ecfdf5; color:var(--green-primary); border-left-color:var(--green-primary); font-weight:600; }

  /* ============ OVERLAY (mobile) ============ */
  .overlay{
    position:fixed; inset:0; background:rgba(0,0,0,.35); display:none; z-index:900;
  }
  .overlay.show{ display:block; }

  /* ============ MAIN ============ */
  .main-content{ margin-left:280px; flex:1; padding:32px; width:calc(100% - 280px); }
  .top-header{
    background:#fff; padding:20px 32px; border-radius:16px; box-shadow:var(--shadow-sm);
    margin-bottom:32px; display:flex; justify-content:space-between; align-items:center;
  }
  .welcome-text h3{ font-size:28px; font-weight:700; color:#1f2937; margin-bottom:4px; }
  .welcome-text p{ color:#6b7280; font-size:14px; }
  .header-actions{ display:flex; gap:16px; align-items:center; }

  .time-display{
    background:linear-gradient(135deg, var(--green-primary), var(--green-dark));
    color:#fff; padding:10px 16px; border-radius:12px; font-weight:600; display:flex; gap:8px; align-items:center;
    box-shadow:var(--shadow-sm);
  }
  .user-avatar{
    width:44px; height:44px; border-radius:50%;
    background:linear-gradient(135deg, var(--cream-light), var(--cream-dark));
    display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--green-dark); font-size:18px;
    box-shadow:var(--shadow-sm);
  }

  /* ============ NOTIFICATION ============ */
  .notification-card{ padding:16px 20px; border-radius:12px; margin-bottom:20px; display:flex; gap:12px; align-items:center; box-shadow:var(--shadow-sm); }
  .notification-card.success{ background:#d1fae5; border-left:4px solid var(--green-primary); color:#065f46; }
  .notification-card.error{ background:#fee2e2; border-left:4px solid #dc2626; color:#991b1b; }
  .notification-card.info{ background:#dbeafe; border-left:4px solid #3b82f6; color:#1e40af; }
  .notification-card i{ font-size:22px; }

  /* ============ ACCOUNT CARD ============ */
  .account-card{
    background:#fff; border-radius:20px; padding:24px; margin-bottom:24px; position:relative; overflow:hidden; box-shadow:var(--shadow-lg);
  }
  .account-card::before{
    content:''; position:absolute; inset:0 auto auto 0; height:8px; width:100%;
    background:linear-gradient(90deg, var(--green-primary), var(--cream-dark), var(--green-primary));
    background-size:200% 100%; animation:shimmer 3s infinite;
  }
  @keyframes shimmer{ 0%{background-position:-200% 0}100%{background-position:200% 0} }

  .account-header{ display:flex; justify-content:space-between; align-items:start; margin-bottom:16px; flex-wrap:wrap; gap:10px; }
  .account-number{ display:flex; align-items:center; gap:12px; background:#f9fafb; padding:10px 14px; border-radius:10px; }
  .account-number span{ font-family:'Courier New', monospace; font-size:16px; font-weight:700; color:#1f2937; letter-spacing:1.5px; }
  .copy-btn{
    background:var(--green-primary); color:#fff; border:none; padding:8px 10px; border-radius:8px; cursor:pointer; transition:all .2s ease;
  }
  .copy-btn:hover{ background:var(--green-dark); transform:translateY(-1px); }

  .status-badge{
    padding:8px 12px; border-radius:20px; font-weight:600; font-size:13px; display:inline-flex; gap:6px; align-items:center;
  }
  .status-badge.active{ background:#d1fae5; color:#065f46; }
  .status-badge.inactive{ background:#fee2e2; color:#991b1b; }

  .balance-section{
    text-align:center; padding:18px; background:linear-gradient(135deg, #ecfdf5 0%, #fef3c7 100%);
    border-radius:16px; margin-top:8px;
  }
  .balance-label{ font-size:12px; color:#6b7280; margin-bottom:6px; letter-spacing:.5px; text-transform:uppercase; }
  .balance-amount{ font-size:36px; font-weight:800; color:var(--green-dark); margin-bottom:8px; word-break:break-word; }
  .balance-toggle{ background:#fff; border:2px solid var(--green-primary); color:var(--green-primary); padding:8px 14px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; }
  .balance-toggle:hover{ background:var(--green-primary); color:#fff; }

  /* ============ RULES GRID ============ */
  .rules-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
  .rule-card{ background:#fff; padding:18px; border-radius:16px; text-align:center; transition:all .2s ease; box-shadow:var(--shadow-sm); border:2px solid transparent; }
  .rule-card:hover{ transform:translateY(-2px); border-color:var(--green-primary); box-shadow:var(--shadow-md); }
  .rule-icon{ width:52px; height:52px; margin:0 auto 10px; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff;
    background:linear-gradient(135deg, var(--green-primary), var(--green-dark)); font-size:26px; }
  .rule-label{ font-size:12px; color:#6b7280; margin-bottom:4px; letter-spacing:.5px; text-transform:uppercase; }
  .rule-value{ font-size:16px; font-weight:700; color:#1f2937; }

  /* ============ FORMS GRID ============ */
  .forms-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-bottom:24px; }
  .form-card{ background:#fff; border-radius:16px; padding:20px; box-shadow:var(--shadow-md); transition:all .2s ease; }
  .form-card:hover{ box-shadow:var(--shadow-lg); transform:translateY(-1px); }
  .form-header{ display:flex; gap:12px; align-items:center; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #f3f4f6; }
  .form-icon{ width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:22px; }
  .form-icon.deposit{ background:linear-gradient(135deg, #10b981, #059669); }
  .form-icon.withdraw{ background:linear-gradient(135deg, #f59e0b, #d97706); }
  .form-header h4{ font-size:17px; font-weight:700; color:#1f2937; margin:0; }

  .quick-amounts{ display:grid; grid-template-columns:repeat(2,1fr); gap:8px; margin-bottom:12px; }
  .quick-btn{ padding:10px; border:2px solid #e5e7eb; background:#fff; border-radius:8px; cursor:pointer; font-weight:600; color:#4b5563; font-size:13px; transition:all .2s ease; }
  .quick-btn:hover{ border-color:var(--green-primary); color:var(--green-primary); background:#ecfdf5; }

  .form-input-group{ position:relative; margin-bottom:12px; }
  .form-input{ width:100%; padding:12px 14px 12px 48px; border:2px solid #e5e7eb; border-radius:12px; font-size:16px; font-weight:600; transition:all .2s ease; background:#f9fafb; }
  .form-input:focus{ outline:none; border-color:var(--green-primary); background:#fff; box-shadow:0 0 0 4px rgba(16,185,129,.1); }
  .input-prefix{ position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:700; color:#6b7280; }

  .submit-btn{ width:100%; padding:12px; border:none; border-radius:12px; font-weight:700; font-size:15px; cursor:pointer; display:flex; gap:8px; align-items:center; justify-content:center; transition:all .2s ease; }
  .submit-btn.deposit{ background:linear-gradient(135deg, #10b981, #059669); color:#fff; }
  .submit-btn.withdraw{ background:linear-gradient(135deg, #f59e0b, #d97706); color:#fff; }
  .submit-btn:hover{ transform:translateY(-1px); box-shadow:var(--shadow-md); }

  /* ---------- SECTION SWITCHER ---------- */
  .section{ display:none; }
  .section.active{ display:block; }

  /* ============ PROFILE ============ */
  .profile-card{ background:#fff; border-radius:16px; box-shadow:var(--shadow-md); overflow:hidden; }
  .profile-head{
    padding:18px 22px; background:linear-gradient(135deg, var(--green-primary), var(--green-dark));
    color:#fff; display:flex; align-items:center; gap:14px;
  }
  .profile-avatar{
    width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg, var(--cream-light), var(--cream-dark));
    display:flex; align-items:center; justify-content:center; font-weight:800; color:#065f46; font-size:22px; box-shadow:var(--shadow-sm);
  }
  .profile-body{ padding:22px; }
  .profile-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }
  .profile-item{ background:#f9fafb; border:1px solid #eef2f7; border-radius:12px; padding:14px; }
  .profile-item small{ display:block; color:#6b7280; margin-bottom:4px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; font-size:11px; }
  .profile-item .val{ font-weight:700; color:#1f2937; }
  @media (max-width:768px){ .profile-grid{ grid-template-columns:1fr; } }

  /* ============ TRANSACTIONS (TABLE) ============ */
  .history-card { background:#fff; border-radius:16px; box-shadow:var(--shadow-md); overflow:hidden; }
  .history-header { padding:18px 20px; background:linear-gradient(135deg, var(--green-primary), var(--green-dark)); color:#fff; display:flex; gap:10px; align-items:center; }
  .history-header i { font-size:24px; }
  .history-header h4 { font-size:18px; font-weight:700; margin:0; }
  .transaction-table { width:100%; border-collapse:collapse; }
  .transaction-table thead{ background:#f9fafb; }
  .transaction-table th{ padding:14px; text-align:left; font-weight:700; color:#4b5563; font-size:12px; text-transform:uppercase; letter-spacing:.5px; border-bottom:2px solid #e5e7eb; white-space:nowrap; }
  .transaction-table td{ padding:14px; border-bottom:1px solid #f3f4f6; color:#1f2937; }
  .table-wrap{ width:100%; overflow-x:auto; }
  .transaction-type{ display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:8px; font-weight:600; font-size:13px; }
  .transaction-type.setor{ background:#d1fae5; color:#065f46; }
  .transaction-type.tarik{ background:#fef3c7; color:#92400e; }
  .transaction-status{ display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:8px; font-weight:600; font-size:12px; }
  .transaction-status.pending{ background:#fef3c7; color:#92400e; }
  .transaction-status.approved{ background:#d1fae5; color:#065f46; }
  .transaction-status.rejected{ background:#fee2e2; color:#991b1b; }
  .empty-state{ padding:48px 20px; text-align:center; color:#6b7280; }
  .empty-icon{ width:110px; height:110px; margin:0 auto 18px; background:linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:54px; color:#9ca3af; }

  /* ============ MOBILE ============ */
  .hamburger{ display:none; border:none; background:#fff; padding:8px 12px; border-radius:10px; box-shadow:var(--shadow-sm); }

  @media (max-width: 1024px){
    .rules-grid{ grid-template-columns:repeat(2,1fr); }
  }
  @media (max-width: 768px){
    .sidebar{ transform:translateX(-100%); }
    .sidebar.active{ transform:translateX(0); }
    .main-content{ margin-left:0; width:100%; padding:16px; }
    .top-header{ padding:14px 16px; gap:12px; align-items:center; }
    .welcome-text h3{ font-size:22px; }
    .header-actions{ gap:10px; }
    .time-display{ padding:8px 12px; font-size:13px; }
    .user-avatar{ width:40px; height:40px; font-size:16px; }
    .hamburger{ display:inline-flex; align-items:center; gap:8px; }
    .rules-grid{ grid-template-columns:1fr; gap:12px; }
    .forms-grid{ grid-template-columns:1fr; gap:16px; }
    .balance-amount{ font-size:30px; }
    .account-number span{ font-size:14px; letter-spacing:1px; }
    .account-card{ padding:18px; }
    .transaction-table{ font-size:13px; }
    .transaction-table th, .transaction-table td{ padding:10px 8px; }
  }
  @media (max-width: 420px){
    .rules-grid{ grid-template-columns:1fr; }
    .quick-amounts{ grid-template-columns:1fr 1fr; }
    .balance-amount{ font-size:26px; }
  }
</style>

<div class="dashboard-wrapper">
  @include('nasabah.partials.sidebar')

  <div class="main-content">
    <!-- Top Header -->
    <div class="top-header">
      <button class="hamburger d-md-none" id="btnOpen">
        <i class="bi bi-list" style="font-size:20px;color:#111827"></i>
        <span style="font-weight:700;color:#111827">Menu</span>
      </button>
      <div class="welcome-text">
        <h3 id="pageTitle">Dashboard Nasabah</h3>
        <p id="pageSubtitle">Halo, {{ Auth::user()->name }}! Selamat datang kembali.</p>
      </div>
      <div class="header-actions">
        <div class="time-display">
          <i class="bi bi-clock"></i>
          <span id="currentTime">--:--:--</span>
        </div>
        <div class="user-avatar">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
      </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
      <div class="notification-card success">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if(session('error'))
      <div class="notification-card error">
        <i class="bi bi-x-circle-fill"></i>
        <span>{{ session('error') }}</span>
      </div>
    @endif
    @if(session('info'))
      <div class="notification-card info">
        <i class="bi bi-info-circle-fill"></i>
        <span>{{ session('info') }}</span>
      </div>
    @endif

    {{-- =================== SECTION: DASHBOARD =================== --}}
    <section id="section-dashboard" class="section active">
      @if(isset($rekening))
        <!-- Account Card -->
        <div class="account-card">
          <div class="account-header">
            <div class="account-number">
              <i class="bi bi-credit-card-2-front" style="font-size: 22px; color: var(--green-primary);"></i>
              <span>{{ $rekening->no_rekening }}</span>
              <button class="copy-btn" onclick="copyAccountNumber('{{ $rekening->no_rekening }}')">
                <i class="bi bi-clipboard"></i>
              </button>
            </div>
            <div>
              @if($nasabah->status === 'AKTIF')
                <span class="status-badge active"><i class="bi bi-check-circle-fill"></i> AKTIF</span>
              @else
                <span class="status-badge inactive"><i class="bi bi-x-circle-fill"></i> NONAKTIF</span>
              @endif
            </div>
          </div>
          <div class="balance-section">
            <div class="balance-label">Saldo Tersedia</div>
            <div class="balance-amount">Rp {{ number_format($rekening->saldo, 0, ',', '.') }}</div>
            <button class="balance-toggle" onclick="toggleBalance()">
              <i class="bi bi-eye"></i> Sembunyikan Saldo
            </button>
          </div>
        </div>

        {{-- Aturan Setor & Tarik --}}
        @if($setting)
          <div class="rules-grid" id="pengaturan">
            <div class="rule-card">
              <div class="rule-icon"><i class="bi bi-arrow-down-circle"></i></div>
              <div class="rule-label">Minimal Setor</div>
              <div class="rule-value">Rp {{ number_format($setting->minimal_setor, 0, ',', '.') }}</div>
            </div>
            <div class="rule-card">
              <div class="rule-icon"><i class="bi bi-arrow-up-circle"></i></div>
              <div class="rule-label">Maksimal Setor</div>
              <div class="rule-value">Rp {{ number_format($setting->maksimal_setor, 0, ',', '.') }}</div>
            </div>
            <div class="rule-card">
              <div class="rule-icon"><i class="bi bi-arrow-down-square"></i></div>
              <div class="rule-label">Minimal Tarik</div>
              <div class="rule-value">Rp {{ number_format($setting->minimal_tarik, 0, ',', '.') }}</div>
            </div>
            <div class="rule-card">
              <div class="rule-icon"><i class="bi bi-arrow-up-square"></i></div>
              <div class="rule-label">Maksimal Tarik</div>
              <div class="rule-value">Rp {{ number_format($setting->maksimal_tarik, 0, ',', '.') }}</div>
            </div>
          </div>
        @endif

        @if($nasabah->status === 'AKTIF')
          <!-- Transaction Forms -->
          <div class="forms-grid">
            <!-- Form Request Setor -->
            <div class="form-card" id="setor-form">
              <div class="form-header">
                <div class="form-icon deposit"><i class="bi bi-arrow-down-circle"></i></div>
                <h4>Request Setor</h4>
              </div>
              <div class="quick-amounts">
                <button class="quick-btn" onclick="setAmount('nominal_setor', 50000)">Rp 50.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_setor', 100000)">Rp 100.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_setor', 500000)">Rp 500.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_setor', 1000000)">Rp 1.000.000</button>
              </div>
              <form method="POST" action="{{ route('nasabah.deposit.request') }}">
                @csrf
                <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                <div class="form-input-group">
                  <span class="input-prefix">Rp</span>
                  <input type="number" name="nominal" id="nominal_setor" placeholder="Masukkan nominal" class="form-input" required min="1">
                </div>
                <button type="submit" class="submit-btn deposit"><i class="bi bi-arrow-down-circle"></i>Kirim Request Setor</button>
              </form>
            </div>

            <!-- Form Request Tarik -->
            <div class="form-card" id="tarik-form">
              <div class="form-header">
                <div class="form-icon withdraw"><i class="bi bi-arrow-up-circle"></i></div>
                <h4>Request Tarik</h4>
              </div>
              <div class="quick-amounts">
                <button class="quick-btn" onclick="setAmount('nominal_tarik', 50000)">Rp 50.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_tarik', 100000)">Rp 100.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_tarik', 500000)">Rp 500.000</button>
                <button class="quick-btn" onclick="setAmount('nominal_tarik', 1000000)">Rp 1.000.000</button>
              </div>
              <form method="POST" action="{{ route('nasabah.withdraw.request') }}">
                @csrf
                <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
                <div class="form-input-group">
                  <span class="input-prefix">Rp</span>
                  <input type="number" name="nominal" id="nominal_tarik" placeholder="Masukkan nominal" class="form-input" required min="1">
                </div>
                <button type="submit" class="submit-btn withdraw"><i class="bi bi-arrow-up-circle"></i>Kirim Request Tarik</button>
              </form>
            </div>
          </div>
        @else
          <div class="warning-alert">
            <div class="warning-alert-content">
              <i class="bi bi-exclamation-triangle-fill warning-icon"></i>
              <p>
                Akun Anda sedang <strong>NONAKTIF</strong>. Anda tidak dapat melakukan setor atau tarik. 
                <strong>Hubungi teller</strong> untuk mengaktifkan kembali akun Anda.
              </p>
            </div>
          </div>
        @endif

        {{-- 🔥 RIWAYAT DIHAPUS dari section dashboard (pindah ke section-transactions) --}}
      @else
        <div class="warning-alert">
          <div class="warning-alert-content">
            <i class="bi bi-exclamation-triangle-fill warning-icon"></i>
            <p>
              Anda belum memiliki rekening aktif. <strong>Silakan hubungi teller</strong> untuk membuat rekening baru.
            </p>
          </div>
        </div>
      @endif
    </section>

    {{-- =================== SECTION: RIWAYAT TRANSAKSI =================== --}}
    <section id="section-transactions" class="section">
      <div class="history-card">
        <div class="history-header">
          <i class="bi bi-clock-history"></i>
          <h4>Riwayat Transaksi</h4>
        </div>

        <div class="table-wrap">
          <table class="transaction-table">
            <thead>
              <tr>
                <th>ID Transaksi</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @php
                $riwayat = optional($rekening)->transaksi ?? collect();
              @endphp

              @forelse($riwayat as $trx)
                <tr>
                  <td><strong>#{{ $trx->id }}</strong></td>
                  <td>
                    <span class="transaction-type {{ strtolower($trx->jenis) }}">
                      @if($trx->jenis === 'SETOR')
                        <i class="bi bi-arrow-down-circle"></i>
                      @else
                        <i class="bi bi-arrow-up-circle"></i>
                      @endif
                      {{ $trx->jenis }}
                    </span>
                  </td>
                  <td><strong>Rp {{ number_format($trx->nominal, 0, ',', '.') }}</strong></td>
                  <td>
                    <span class="transaction-status {{ strtolower($trx->status) }}">
                      @if($trx->status === 'PENDING')
                        <i class="bi bi-clock"></i>
                      @elseif($trx->status === 'APPROVED')
                        <i class="bi bi-check-circle"></i>
                      @else
                        <i class="bi bi-x-circle"></i>
                      @endif
                      {{ $trx->status }}
                    </span>
                  </td>
                  <td>{{ $trx->created_at->timezone(config('app.timezone','Asia/Jakarta'))->format('d M Y H:i') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">
                    <div class="empty-state">
                      <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                      <div class="empty-text">Belum ada transaksi</div>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </section>

    {{-- =================== SECTION: PROFIL SAYA =================== --}}
    <section id="section-profile" class="section">
      <div class="profile-card">
        <div class="profile-head">
          <div class="profile-avatar">{{ strtoupper(substr($nasabah->nama,0,1)) }}</div>
          <div>
            <div class="fw-bold" style="font-size:18px;">{{ $nasabah->nama }}</div>
            <div style="opacity:.9">{{ $nasabah->email }}</div>
          </div>
          <div class="ms-auto">
            @if($nasabah->status === 'AKTIF')
              <span class="badge bg-light text-dark"><i class="bi bi-check-circle-fill text-success me-1"></i>AKTIF</span>
            @else
              <span class="badge bg-secondary">{{ $nasabah->status }}</span>
            @endif
          </div>
        </div>
        <div class="profile-body">
          <div class="profile-grid">
            <div class="profile-item">
              <small>NIS/NIP</small>
              <div class="val">{{ $nasabah->nis_nip ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small>Jenis Kelamin</small>
              <div class="val">
                @if($nasabah->jenis_kelamin === 'L') Laki-laki
                @elseif($nasabah->jenis_kelamin === 'P') Perempuan
                @else - @endif
              </div>
            </div>
            <div class="profile-item">
              <small>No. HP</small>
              <div class="val">{{ $nasabah->no_hp ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small>Alamat</small>
              <div class="val">{{ $nasabah->alamat ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small>No. Rekening</small>
              <div class="val">{{ optional($rekening)->no_rekening ?? '-' }}</div>
            </div>
            <div class="profile-item">
              <small>Saldo</small>
              <div class="val">
                Rp {{ number_format(optional($rekening)->saldo ?? 0, 0, ',', '.') }}
              </div>
            </div>
            @if(optional($rekening)->tanggal_buka)
              <div class="profile-item">
                <small>Tanggal Buka Rekening</small>
                <div class="val">{{ \Carbon\Carbon::parse($rekening->tanggal_buka)->format('d M Y') }}</div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
    {{-- ============================================================ --}}
  </div>
</div>

<!-- Mobile Menu Button -->
<button class="mobile-menu-btn d-md-none" id="btnFloat" style="
  position: fixed; bottom: 20px; right: 20px; width: 56px; height: 56px;
  border-radius: 50%; background: linear-gradient(135deg, var(--green-primary), var(--green-dark));
  color: #fff; border: none; box-shadow: var(--shadow-lg); z-index: 950; display:none;
">
  <i class="bi bi-list" style="font-size:24px;"></i>
</button>

<script>
  // Live Clock
  function updateTime(){
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    const el = document.getElementById('currentTime');
    if(el) el.textContent = `${h}:${m}:${s}`;
  }
  updateTime(); setInterval(updateTime,1000);

  // Sidebar mobile toggle
  (function(){
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btnOpen = document.getElementById('btnOpen');
    const btnFloat = document.getElementById('btnFloat');

    const open = ()=>{ sidebar.classList.add('active'); overlay.classList.add('show'); };
    const close = ()=>{ sidebar.classList.remove('active'); overlay.classList.remove('show'); };

    if(btnOpen) btnOpen.addEventListener('click', open);
    if(btnFloat) btnFloat.addEventListener('click', open);
    if(overlay) overlay.addEventListener('click', close);
    window.addEventListener('resize', ()=>{
      if(window.innerWidth >= 769){ close(); btnFloat.style.display='none'; }
      else { btnFloat.style.display='block'; }
    });
    if(window.innerWidth < 769) btnFloat.style.display='block';
  })();

  // Copy account number
  function copyAccountNumber(accountNumber){
    navigator.clipboard.writeText(accountNumber).then(()=>{ alert('Nomor rekening berhasil disalin!'); });
  }

  // Toggle balance
  let balanceVisible = true;
  function toggleBalance(){
    const el = document.querySelector('.balance-amount');
    const btn = document.querySelector('.balance-toggle');
    if(!el || !btn) return;
    if(!el.dataset.original){ el.dataset.original = el.textContent.trim(); }
    if(balanceVisible){
      el.textContent = 'Rp ••••••••';
      btn.innerHTML = '<i class="bi bi-eye-slash"></i> Tampilkan Saldo';
    }else{
      el.textContent = el.dataset.original;
      btn.innerHTML = '<i class="bi bi-eye"></i> Sembunyikan Saldo';
    }
    balanceVisible = !balanceVisible;
  }

  // Quick set amount
  function setAmount(id, amount){ const i = document.getElementById(id); if(i) i.value = amount; }

  // Guard number non-negative
  document.addEventListener('input', (e)=>{
    if(e.target.matches('.form-input[type="number"]')){
      if(e.target.value < 0) e.target.value = 0;
    }
  });

  // Close sidebar when clicking outside (mobile)
  document.addEventListener('click', function(e){
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const inSidebar = sidebar.contains(e.target);
    const isBtn = e.target.closest('#btnOpen') || e.target.closest('#btnFloat');
    if(window.innerWidth <= 768 && !inSidebar && !isBtn){
      overlay.classList.remove('show'); sidebar.classList.remove('active');
    }
  });

  // ======= SECTION SWITCHER: dashboard <-> transactions <-> profile =======
  const menuItems = document.querySelectorAll('.menu-item[data-section]');
  const sections = {
    dashboard: document.getElementById('section-dashboard'),
    transactions: document.getElementById('section-transactions'),
    profile: document.getElementById('section-profile')
  };
  const titleMap = {
    dashboard: { title: 'Dashboard Nasabah', sub: 'Halo, {{ addslashes(Auth::user()->name) }}! Selamat datang kembali.' },
    transactions: { title: 'Riwayat Transaksi', sub: 'Lihat semua transaksi Anda di sini.' },
    profile: { title: 'Profil Saya', sub: 'Detail data nasabah & rekening.' }
  };

  function switchSection(name){
    // sections
    Object.values(sections).forEach(s => s.classList.remove('active'));
    (sections[name] || sections.dashboard).classList.add('active');

    // header text
    const cfg = titleMap[name] || titleMap.dashboard;
    document.getElementById('pageTitle').textContent = cfg.title;
    document.getElementById('pageSubtitle').textContent = cfg.sub;

    // close sidebar on mobile
    document.getElementById('overlay').classList.remove('show');
    document.getElementById('sidebar').classList.remove('active');

    // active state menu
    menuItems.forEach(mi => {
      const isSame = mi.dataset.section === name && !mi.dataset.scroll;
      mi.classList.toggle('active', isSame);
    });
  }

  menuItems.forEach(mi=>{
    mi.addEventListener('click', e=>{
      e.preventDefault();
      const target = mi.dataset.section || 'dashboard';
      switchSection(target);

      // optional: scroll ke bagian tertentu di dashboard
      const sel = mi.dataset.scroll;
      if (sel && sections.dashboard.classList.contains('active')) {
        const el = document.querySelector(sel);
        if(el){ setTimeout(()=>el.scrollIntoView({behavior:'smooth', block:'start'}), 50); }
      }
    });
  });

  // Live clock
  function tick(){
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    const el = document.getElementById('currentTime');
    if(el) el.textContent = `${h}:${m}:${s}`;
  }
  tick(); setInterval(tick, 1000);
</script>
@endsection
