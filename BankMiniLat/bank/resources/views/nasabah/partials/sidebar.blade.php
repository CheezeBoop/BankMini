{{-- resources/views/nasabah/partials/sidebar.blade.php --}}
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-brand">
      <i class="bi bi-bank2"></i>
      <span>BankKu</span>
    </div>
  </div>

  <div class="sidebar-menu">
    {{-- Dashboard --}}
    <a href="#" class="menu-item active" data-section="dashboard">
      <i class="bi bi-speedometer2"></i>
      <span>Dashboard</span>
    </a>

    {{-- Setor Dana (scroll ke form di dashboard) --}}
    <a href="{{ route('nasabah.deposit.form') }}"
   class="menu-item {{ request()->routeIs('nasabah.deposit.*') ? 'active' : '' }}">
      <i class="bi bi-arrow-down-circle"></i>
      <span>Setor Dana</span>
    </a>

    {{-- Tarik Dana --}}
    <a href="{{ route('nasabah.withdraw.form') }}"
   class="menu-item {{ request()->routeIs('nasabah.withdraw.*') ? 'active' : '' }}">
      <i class="bi bi-arrow-up-circle"></i>
      <span>Tarik Dana</span>
  </a>

    {{-- Riwayat Transaksi (SPA - section di halaman yang sama) --}}
    <a href="#" class="menu-item" data-section="transactions">
      <i class="bi bi-clock-history"></i>
      <span>Riwayat Transaksi</span>
    </a>

    {{-- Profil Saya (SPA - section) --}}
    <a href="#" class="menu-item" data-section="profile">
      <i class="bi bi-person-circle"></i>
      <span>Profil Saya</span>
    </a>

    {{-- Pengaturan (opsional: scroll ke kartu aturan di dashboard) --}}
    <a href="#" class="menu-item" data-section="dashboard" data-scroll="#pengaturan">
      <i class="bi bi-gear"></i>
      <span>Pengaturan</span>
    </a>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}"
          style="margin-top:20px; border-top:1px solid #e5e7eb; padding-top:20px;">
      @csrf
      <button type="submit" class="menu-item"
              style="width:100%; background:none; border:none; text-align:left;">
        <i class="bi bi-box-arrow-right"></i>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</div>
