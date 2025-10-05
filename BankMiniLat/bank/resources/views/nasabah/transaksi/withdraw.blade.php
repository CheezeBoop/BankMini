{{-- resources/views/nasabah/transaksi/withdraw.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
  @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
  
  :root {
    --green-primary: #10b981;
    --green-dark: #059669;
    --orange-primary: #f59e0b;
    --orange-dark: #d97706;
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
  .notification-card i{ font-size:22px; }

  /* ============ MAIN CARD (Orange theme for withdraw) ============ */
  .main-card{
    background:#fff; border-radius:20px; padding:24px; position:relative; overflow:hidden; box-shadow:var(--shadow-lg);
  }
  .main-card::before{
    content:''; position:absolute; inset:0 auto auto 0; height:8px; width:100%;
    background:linear-gradient(90deg, var(--orange-primary), var(--cream-dark), var(--orange-primary));
    background-size:200% 100%; animation:shimmer 3s infinite;
  }
  @keyframes shimmer{ 0%{background-position:-200% 0}100%{background-position:200% 0} }

  .balance-section{
    display:flex; gap:20px; align-items:center; margin-bottom:18px; padding:18px;
    background:linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%); border-radius:16px;
  }
  .balance-item{ flex:1; }
  .balance-item.right{ text-align:right; margin-left:auto; }
  
  .label{ font-size:12px; color:#6b7280; margin-bottom:6px; letter-spacing:.5px; text-transform:uppercase; font-weight:600; display:block; }
  .money{ font-size:28px; font-weight:800; color:#92400e; }

  .rules-info{
    background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; padding:14px; margin-bottom:18px;
  }
  .rules-text{ color:#92400e; font-weight:600; }

  /* ============ FORMS ============ */
  .form-group{ margin-bottom:12px; }
  
  .quick-amounts{ display:grid; grid-template-columns:repeat(2,1fr); gap:8px; margin-bottom:12px; }
  .quick-btn{ padding:10px; border:2px solid #e5e7eb; background:#fff; border-radius:8px; cursor:pointer; font-weight:600; color:#4b5563; font-size:13px; transition:all .2s ease; }
  .quick-btn:hover{ border-color:var(--orange-primary); color:var(--orange-primary); background:#fff7ed; }

  .form-input{ width:100%; padding:12px 14px; border:2px solid #e5e7eb; border-radius:12px; font-size:16px; font-weight:600; transition:all .2s ease; background:#f9fafb; }
  .form-input:focus{ outline:none; border-color:var(--orange-primary); background:#fff; box-shadow:0 0 0 4px rgba(245,158,11,.1); }

  .btn-warning{ 
    width:100%; padding:12px; border:none; border-radius:12px; font-weight:700; font-size:15px; cursor:pointer; 
    display:flex; gap:8px; align-items:center; justify-content:center; transition:all .2s ease;
    background:linear-gradient(135deg, var(--orange-primary), var(--orange-dark)); color:#fff;
  }
  .btn-warning:hover{ transform:translateY(-1px); box-shadow:var(--shadow-md); }

  .error-msg{ color:#b91c1c; margin-top:6px; font-size:13px; font-weight:600; }

  .alert-warning{
    background:#fef3c7; border-left:4px solid #f59e0b; color:#92400e; 
    padding:16px 20px; border-radius:12px; display:flex; gap:12px; align-items:center; font-weight:600;
  }

  /* ============ MOBILE ============ */
  .hamburger{ display:none; border:none; background:#fff; padding:8px 12px; border-radius:10px; box-shadow:var(--shadow-sm); }

  @media (max-width: 768px){
    .sidebar{ transform:translateX(-100%); }
    .sidebar.active{ transform:translateX(0); }
    .main-content{ margin-left:0; width:100%; padding:16px; }
    .top-header{ padding:14px 16px; gap:12px; }
    .welcome-text h3{ font-size:22px; }
    .header-actions{ gap:10px; }
    .time-display{ padding:8px 12px; font-size:13px; }
    .user-avatar{ width:40px; height:40px; font-size:16px; }
    .hamburger{ display:inline-flex; align-items:center; gap:8px; }
    .balance-section{ flex-direction:column; gap:12px; }
    .balance-item.right{ text-align:left; margin-left:0; }
    .money{ font-size:24px; }
  }
</style>

<div class="dashboard-wrapper">
  @include('nasabah.partials.sidebar')

  <div class="main-content">
    <div class="top-header">
      <button class="hamburger d-md-none" id="btnOpen">
        <i class="bi bi-list" style="font-size:20px;color:#111827"></i>
        <span style="font-weight:700;color:#111827">Menu</span>
      </button>
      <div class="welcome-text">
        <h3>Tarik Dana</h3>
        <p>Buat permintaan tarik, teller akan memproses setelah verifikasi.</p>
      </div>
      <div class="header-actions">
        <div class="time-display">
          <i class="bi bi-clock"></i>
          <span id="currentTime">--:--:--</span>
        </div>
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
      </div>
    </div>

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

    <div class="main-card">
      @if(!$rekening)
        <div class="alert-warning">
          <i class="bi bi-exclamation-triangle-fill" style="font-size:22px;"></i>
          <span>Anda belum memiliki rekening aktif. Silakan hubungi teller.</span>
        </div>
      @else
        <div class="balance-section">
          <div class="balance-item">
            <span class="label">No. Rekening</span>
            <div class="money">{{ $rekening->no_rekening }}</div>
          </div>
          <div class="balance-item right">
            <span class="label">Saldo</span>
            <div class="money">Rp {{ number_format($rekening->saldo,0,',','.') }}</div>
          </div>
        </div>

        <div class="rules-info">
          <span class="label">Aturan Tarik</span>
          <div class="rules-text">
            Minimal: Rp {{ number_format($setting->minimal_tarik,0,',','.') }} &nbsp;|&nbsp;
            Maksimal: Rp {{ number_format($setting->maksimal_tarik,0,',','.') }}
          </div>
        </div>

        <form method="POST" action="{{ route('nasabah.withdraw.request') }}">
          @csrf
          <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">

          <div class="form-group">
            <label class="label">Nominal</label>
            <div class="quick-amounts">
              <button type="button" class="quick-btn" onclick="setAmount('nominal',50000)">Rp 50.000</button>
              <button type="button" class="quick-btn" onclick="setAmount('nominal',100000)">Rp 100.000</button>
              <button type="button" class="quick-btn" onclick="setAmount('nominal',200000)">Rp 200.000</button>
              <button type="button" class="quick-btn" onclick="setAmount('nominal',500000)">Rp 500.000</button>
            </div>
            <input id="nominal" name="nominal" type="number" min="1" class="form-input" value="{{ old('nominal') }}" placeholder="Masukkan nominal">
            @error('nominal') <div class="error-msg">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label class="label">Keterangan (opsional)</label>
            <input name="keterangan" type="text" value="{{ old('keterangan') }}" placeholder="Contoh: tarik tunai di teller" class="form-input">
            @error('keterangan') <div class="error-msg">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn-warning">
            <i class="bi bi-arrow-up-circle"></i> Kirim Request Tarik
          </button>
        </form>
      @endif
    </div>
  </div>
</div>

<div class="overlay" id="overlay"></div>

<!-- Mobile Menu Button -->
<button class="mobile-menu-btn d-md-none" id="btnFloat" style="
  position: fixed; bottom: 20px; right: 20px; width: 56px; height: 56px;
  border-radius: 50%; background: linear-gradient(135deg, var(--orange-primary), var(--orange-dark));
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

  // Handle sidebar menu clicks - redirect ke dashboard dengan hash
  document.querySelectorAll('.menu-item[data-section]').forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      const section = this.dataset.section;
      // Redirect ke dashboard dengan hash section
      window.location.href = "{{ route('nasabah.dashboard') }}" + (section ? '#' + section : '');
    });
  });
</script>
@endsection