@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
  <div class="dashboard-header">
    <div class="container-fluid px-4 py-4">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="header-content">
            <div class="brand-badge mb-3">
              <i class="bi bi-bank2"></i>
              <span>BANK MINI TSAMANIYAH</span>
            </div>
            <h1 class="display-5 fw-bold text-white mb-2">Admin Dashboard</h1>
            <p class="text-white-50 mb-0 fs-5">
              Selamat datang, <span class="text-warning fw-semibold">{{ Auth::user()->name }}</span>!
            </p>
            <p class="text-white-50 small">Kelola sistem perbankan dengan mudah dan efisien</p>
          </div>
        </div>
        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
          <div class="header-time-card">
            <div class="time-display">
              <i class="bi bi-clock-history text-warning"></i>
              <div class="ms-3">
                {{-- ✅ jam & tanggal dibaca dari server (UTC) lalu ditampilkan sesuai timezone app --}}
                <div class="current-time fw-bold" id="currentTime">--:--</div>
                <div class="current-date" id="currentDate">Memuat tanggal…</div>

                {{-- seed waktu dari server (UTC) + hint timezone app --}}
                <span id="serverNow"
                      data-now="{{ now()->setTimezone('UTC')->format('c') }}"
                      data-tz="{{ config('app.timezone', 'Asia/Jakarta') }}"
                      class="d-none"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<button onclick="window.location='{{ route('admin.settings.index') }}'" class="btn btn-success">
    ⚙️ Settings
</button>

  <div class="container-fluid px-4 py-4">
    @if(session('success'))
      <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
        <div class="alert-icon">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="alert-content">
          <strong>Berhasil!</strong>
          <p class="mb-0">{{ session('success') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
        <div class="alert-icon">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="alert-content">
          <strong>Error!</strong>
          <p class="mb-0">{{ session('error') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="row g-4 mb-4">
      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-primary">
          <div class="stat-card-body">
            <div class="stat-icon-wrapper">
              <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
              </div>
              <div class="stat-badge">
                <i class="bi bi-arrow-up"></i>
              </div>
            </div>
            <div class="stat-content">
              <div class="stat-label">Total Teller</div>
              <div class="stat-value">{{ $tellers->count() }}</div>
              <div class="stat-desc">
                <span class="stat-trend positive">
                  <i class="bi bi-graph-up-arrow"></i> Aktif
                </span>
              </div>
            </div>
          </div>
          <div class="stat-footer">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
            </div>
          </div>
        </div>
      </div>

     <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-success">
          <div class="stat-card-body">
            <div class="stat-icon-wrapper">
              <div class="stat-icon">
                <i class="bi bi-arrow-down-circle-fill"></i>
              </div>
              <div class="stat-badge">
                <i class="bi bi-check"></i>
              </div>
            </div>
            <div class="stat-content">
              <div class="stat-label">Log Setoran</div>
              <div class="stat-value">{{ $logSetor->count() }}</div>
              <div class="stat-desc">
                <span class="stat-trend positive">
                  <i class="bi bi-arrow-up"></i> Transaksi Masuk
                </span>
              </div>
            </div>
          </div>
          <div class="stat-footer">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-danger">
          <div class="stat-card-body">
            <div class="stat-icon-wrapper">
              <div class="stat-icon">
                <i class="bi bi-arrow-up-circle-fill"></i>
              </div>
              <div class="stat-badge">
                <i class="bi bi-exclamation"></i>
              </div>
            </div>
            <div class="stat-content">
              <div class="stat-label">Log Penarikan</div>
              <div class="stat-value">{{ $logTarik->count() }}</div>
              <div class="stat-desc">
                <span class="stat-trend negative">
                  <i class="bi bi-arrow-down"></i> Transaksi Keluar
                </span>
              </div>
            </div>
          </div>
          <div class="stat-footer">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 65%"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-warning">
          <div class="stat-card-body">
            <div class="stat-icon-wrapper">
              <div class="stat-icon">
                <i class="bi bi-shield-check"></i>
              </div>
              <div class="stat-badge">
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
            <div class="stat-content">
              <div class="stat-label">Log Akun</div>
              <div class="stat-value">{{ $logAkun->count() }}</div>
              <div class="stat-desc">
                <span class="stat-trend positive">
                  <i class="bi bi-shield-fill-check"></i> Aman
                </span>
              </div>
            </div>
          </div>
          <div class="stat-footer">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-xl-8">
        <div class="modern-card card-gradient-primary">
          <div class="modern-card-header">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title mb-1">
                  <i class="bi bi-graph-up text-success me-2"></i>Aktivitas Sistem
                </h5>
                <p class="card-subtitle mb-0">Overview aktivitas 7 hari terakhir</p>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-primary active">7 Hari</button>
                <button type="button" class="btn btn-sm btn-outline-primary">30 Hari</button>
              </div>
            </div>
          </div>
          <div class="modern-card-body">
            <div style="position: relative; height: 300px; width: 100%;">
              <canvas id="activityChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4">
        <div class="modern-card card-gradient-success">
          <div class="modern-card-header">
            <h5 class="card-title mb-1">
              <i class="bi bi-pie-chart-fill text-warning me-2"></i>Distribusi Aktivitas
            </h5>
            <p class="card-subtitle mb-0">Persentase jenis aktivitas</p>
          </div>
          <div class="modern-card-body text-center">
            <div style="position: relative; height: 250px; width: 100%;">
              <canvas id="pieChart"></canvas>
            </div>
            <div class="legend-custom mt-3">
              <div class="legend-item">
                <span class="legend-dot" style="background: #2C5F2D;"></span>
                <span>Akun ({{ round(($logAkun->count() / max(($logAkun->count() + $logSetor->count() + $logTarik->count()), 1)) * 100) }}%)</span>
              </div>
              <div class="legend-item">
                <span class="legend-dot" style="background: #97BC62;"></span>
                <span>Setoran ({{ round(($logSetor->count() / max(($logAkun->count() + $logSetor->count() + $logTarik->count()), 1)) * 100) }}%)</span>
              </div>
              <div class="legend-item">
                <span class="legend-dot" style="background: #FFD93D;"></span>
                <span>Penarikan ({{ round(($logTarik->count() / max(($logAkun->count() + $logSetor->count() + $logTarik->count()), 1)) * 100) }}%)</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br><div class="row g-4 mb-4">
      <div class="col-xl-12">
        <div class="modern-card card-gradient-teller">
          <div class="modern-card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <div>
                <h5 class="card-title mb-1">
                  <i class="bi bi-person-badge-fill text-primary me-2"></i>Manajemen Teller
                </h5>
                <p class="card-subtitle mb-0">Kelola akun teller sistem perbankan</p>
              </div>
              <div class="d-flex gap-2">
                <div class="search-box">
                  <i class="bi bi-search"></i>
                  <input type="text" class="form-control" placeholder="Cari teller..." id="searchTeller">
                </div>
                <a href="{{ route('admin.teller.create') }}" class="btn btn-primary btn-modern">
                  <i class="bi bi-plus-circle me-2"></i>Tambah Teller
                </a>
              </div>
            </div>
          </div>
          <div class="modern-card-body p-2">
            <div class="table-scroll-container">
              <table class="table table-modern mb-2">
                <thead>
                  <tr>
                    <th>
                      <div class="th-content">
                        <i class="bi bi-person me-2"></i>Teller
                      </div>
                    </th>
                    <th>
                      <div class="th-content">
                        <i class="bi bi-envelope me-2"></i>Email
                      </div>
                    </th>
                    <th>
                      <div class="th-content">
                        <i class="bi bi-calendar me-2"></i>Terdaftar
                      </div>
                    </th>
                    <th>
                      <div class="th-content">
                        <i class="bi bi-activity me-2"></i>Status
                      </div>
                    </th>
                    <th class="text-center">
                      <div class="th-content">
                        <i class="bi bi-gear me-2"></i>Aksi
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="tellerTableBody">
                  @forelse($tellers as $t)
                    <tr class="table-row-hover teller-row">
                      <td>
                        <div class="user-info">
                          <div class="avatar-gradient">
                            {{ strtoupper(substr($t->name, 0, 2)) }}
                          </div>
                          <div class="user-details">
                            <div class="user-name">{{ $t->name }}</div>
                            <div class="user-id">ID: #{{ $t->id }}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="email-wrapper">
                          <i class="bi bi-envelope-fill text-muted me-2"></i>
                          <span>{{ $t->email }}</span>
                        </div>
                      </td>
                      <td>
                        <div class="date-badge">
                          <i class="bi bi-calendar3 me-1"></i>
                          {{ $t->created_at->format('d M Y') }}
                          <span class="time-badge">{{ $t->created_at->format('H:i') }}</span>
                        </div>
                      </td>
                      <td>
                        <span class="status-badge status-active">
                          <i class="bi bi-check-circle-fill"></i> Aktif
                        </span>
                      </td>
                      <td>
                        <div class="action-buttons">
                          <button class="btn-action btn-action-view" title="Lihat Detail" onclick="viewTellerDetail({{ $t->id }}, '{{ $t->name }}', '{{ $t->email }}', '{{ $t->created_at->format('d M Y H:i') }}')">
                            <i class="bi bi-eye"></i>
                          </button>
                          <a class="btn-action btn-action-edit" title="Edit"
                            href="{{ route('admin.teller.edit', $t->id) }}">
                            <i class="bi bi-pencil"></i>
                          </a>
                          </button>
                          <button class="btn-action btn-action-delete" onclick="confirmDelete('{{ route('admin.teller.remove',$t->id) }}', '{{ $t->name }}')" title="Hapus">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5">
                        <div class="empty-state">
                          <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                          </div>
                          <h6>Belum Ada Teller</h6>
                          <p>Silakan tambahkan teller baru untuk memulai</p>
                          <a href="{{ route('admin.teller.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Teller
                          </a>
                        </div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          @if ($tellers->hasPages())
    <div class="modern-card-footer">
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $tellers->firstItem() }} - {{ $tellers->lastItem() }} dari {{ $tellers->total() }} teller
            </div>
            <div class="pagination-modern">
                {{ $tellers->links() }}
            </div>
        </div>
    </div>
@endif

   {{-- Activity Logs Section --}}
<div class="row g-4 mb-4">
  {{-- Log Akun --}}
  <div class="col-lg-4">
    <div class="modern-card activity-card activity-card-primary">
      <div class="modern-card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-shield-lock-fill me-2"></i>Log Akun
        </h6>
        <span class="activity-count">{{ $logAkun->count() }}</span>
      </div>
      <div class="modern-card-body p-0">
        <div class="activity-scroll">
          @forelse($logAkun->take(5) as $log)
            <div class="activity-item">
              <div class="activity-indicator activity-indicator-primary"></div>
              <div class="activity-content">
                <div class="activity-title">{{ $log->aksi }}</div>
                <div class="activity-meta">
                  <span class="activity-user">
                    <i class="bi bi-person-circle"></i> {{ $log->user->name ?? 'System' }}
                  </span>
                  <span class="activity-time">
                    <i class="bi bi-clock"></i> {{ $log->created_at->diffForHumans() }}
                  </span>
                </div>
              </div>
              <button class="btn-mini-detail" onclick="showLogDetail({{ $log->id }}, 'akun')" title="Detail">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          @empty
            <div class="activity-empty">
              <i class="bi bi-inbox"></i>
              <p>Belum ada aktivitas</p>
            </div>
          @endforelse
        </div>
      </div>
      @if($logAkun->count() > 5)
        <div class="modern-card-footer">
          <a href="#" class="view-all-link" onclick="showAllLogs('akun')">
            Lihat semua {{ $logAkun->count() }} aktivitas <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      @endif
    </div>
  </div>

  {{-- Log Setoran --}}
  <div class="col-lg-4">
    <div class="modern-card activity-card activity-card-success">
      <div class="modern-card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-arrow-down-circle-fill me-2"></i>Log Setoran
        </h6>
        <span class="activity-count">{{ $logSetor->count() }}</span>
      </div>
      <div class="modern-card-body p-0">
        <div class="activity-scroll">
          @forelse($logSetor->take(5) as $log)
            <div class="activity-item">
              <div class="activity-indicator activity-indicator-success"></div>
              <div class="activity-content">
                <div class="activity-title">{{ $log->aksi }}</div>
                <div class="activity-meta">
                  <span class="activity-user">
                    <i class="bi bi-person-circle"></i> {{ $log->user->name ?? 'System' }}
                  </span>
                  <span class="activity-time">
                    <i class="bi bi-clock"></i> {{ $log->created_at->diffForHumans() }}
                  </span>
                </div>
              </div>
              <button class="btn-mini-detail" onclick="showLogDetail({{ $log->id }}, 'setoran')" title="Detail">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          @empty
            <div class="activity-empty">
              <i class="bi bi-inbox"></i>
              <p>Belum ada aktivitas</p>
            </div>
          @endforelse
        </div>
      </div>
      @if($logSetor->count() > 5)
        <div class="modern-card-footer">
          <a href="#" class="view-all-link" onclick="showAllLogs('setoran')">
            Lihat semua {{ $logSetor->count() }} aktivitas <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      @endif
    </div>
  </div>

  {{-- Log Tarik --}}
  <div class="col-lg-4">
    <div class="modern-card activity-card activity-card-warning">
      <div class="modern-card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-arrow-up-circle-fill me-2"></i>Log Penarikan
        </h6>
        <span class="activity-count">{{ $logTarik->count() }}</span>
      </div>
      <div class="modern-card-body p-0">
        <div class="activity-scroll">
          @forelse($logTarik->take(5) as $log)
            <div class="activity-item">
              <div class="activity-indicator activity-indicator-warning"></div>
              <div class="activity-content">
                <div class="activity-title">{{ $log->aksi }}</div>
                <div class="activity-meta">
                  <span class="activity-user">
                    <i class="bi bi-person-circle"></i> {{ $log->user->name ?? 'System' }}
                  </span>
                  <span class="activity-time">
                    <i class="bi bi-clock"></i> {{ $log->created_at->diffForHumans() }}
                  </span>
                </div>
              </div>
              <button class="btn-mini-detail" onclick="showLogDetail({{ $log->id }}, 'penarikan')" title="Detail">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          @empty
            <div class="activity-empty">
              <i class="bi bi-inbox"></i>
              <p>Belum ada aktivitas</p>
            </div>
          @endforelse
        </div>
      </div>
      @if($logTarik->count() > 5)
        <div class="modern-card-footer">
          <a href="#" class="view-all-link" onclick="showAllLogs('penarikan')">
            Lihat semua {{ $logTarik->count() }} aktivitas <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

    <div class="row g-4 mb-4">
      <div class="col-12">
        <div class="modern-card card-gradient-log">
          <div class="modern-card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <div>
                <h5 class="card-title mb-1">
                  <i class="bi bi-activity text-danger me-2"></i>Log Aktivitas Teller Detail
                </h5>
                <p class="card-subtitle mb-0">Riwayat lengkap aktivitas sistem</p>
              </div>
              <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;" id="tellerFilter">
                  <option value="">Semua Teller</option>
                  @foreach($tellers as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                  @endforeach
                </select>
                <button class="btn btn-outline-primary btn-sm" onclick="exportLogs()">
                  <i class="bi bi-download me-1"></i>Export
                </button>
              </div>
            </div>
          </div>
          <div class="modern-card-body p-0">
            <div class="table-responsive">
              <table class="table table-modern table-detailed mb-0">
                <thead>
                  <tr>
                    <th><i class="bi bi-clock-history me-2"></i>Waktu</th>
                    <th><i class="bi bi-person me-2"></i>Teller</th>
                    <th><i class="bi bi-lightning me-2"></i>Aksi</th>
                    <th><i class="bi bi-tag me-2"></i>Entitas</th>
                    <th><i class="bi bi-pc-display me-2"></i>IP Address</th>
                    <th class="text-center"><i class="bi bi-info-circle me-2"></i>Detail</th>
                  </tr>
                </thead>
                <tbody id="logTableBody">
                  @forelse($logs as $log)
                    <tr class="table-row-hover log-row" data-teller-id="{{ $log->user_id }}">
                      <td>
                        <div class="timestamp-badge">
                          <div class="timestamp-date">{{ $log->created_at->format('d M Y') }}</div>
                          <div class="timestamp-time">{{ $log->created_at->format('H:i:s') }}</div>
                        </div>
                      </td>
                      <td>
                        <div class="user-info">
                          <div class="avatar-gradient-small">
                            {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}
                          </div>
                          <div class="user-details">
                            <div class="user-name-small">{{ $log->user->name ?? 'Unknown' }}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="action-badge action-badge-info">
                          <i class="bi bi-lightning-charge-fill"></i> {{ $log->aksi }}
                        </span>
                      </td>
                      <td>
                        <div class="entity-badge">
                          <span class="entity-type">{{ $log->entitas }}</span>
                          <span class="entity-id">#{{ $log->entitas_id }}</span>
                        </div>
                      </td>
                      <td>
                        <code class="ip-code">{{ $log->ip_addr ?? '-' }}</code>
                      </td>
                      <td class="text-center">
                        <button class="btn-detail" onclick="showLogDetail({{ $log->id }})">
                          <i class="bi bi-eye-fill"></i> Lihat Detail
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6">
                        <div class="empty-state">
                          <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                          </div>
                          <h6>Belum Ada Aktivitas</h6>
                          <p>Log aktivitas akan muncul di sini</p>
                        </div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          @if(method_exists($logs, 'hasPages') && $logs->hasPages())
            <div class="modern-card-footer">
              <div class="pagination-wrapper">
                <div class="pagination-info">
                  Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} data
                </div>
                <div class="pagination-modern">
                  {{ $logs->links() }}
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Detail Log --}}
<div class="modal fade" id="logDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content modal-modern">
      <div class="modal-header modal-header-modern">
        <div>
          <h5 class="modal-title">
            <i class="bi bi-file-earmark-text me-2"></i>Detail Aktivitas Log
          </h5>
          <p class="modal-subtitle mb-0" id="logDetailSubtitle">Loading...</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="logDetailContent">
        <div class="text-center py-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-2">Memuat detail...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tellerDetailModal" tabindex="-1" aria-labelledby="tellerDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-modern">
      <div class="modal-header modal-header-modern">
        <div>
          <h5 class="modal-title" id="tellerDetailModalLabel">
            <i class="bi bi-person-badge me-2"></i>Detail Teller
          </h5>
          <p class="modal-subtitle mb-0" id="tellerDetailSubtitle">Informasi lengkap teller</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-modern" id="tellerDetailContent">
        <div class="text-center py-4">
          <p>Memuat detail...</p>
        </div>
      </div>
      <div class="modal-footer modal-footer-modern">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-modern">
      <div class="modal-header modal-header-danger">
        <div>
          <h5 class="modal-title" id="deleteConfirmModalLabel">
            <i class="bi bi-trash-fill me-2"></i>Konfirmasi Hapus
          </h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3">
          <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 4rem;"></i>
        </div>
        <h6>Apakah Anda yakin?</h6>
        <p class="mb-0" id="deleteMessage">Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Batal
        </button>
        <form id="deleteForm" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const activityCtx = document.getElementById('activityChart');
  if (activityCtx) {
    new Chart(activityCtx, {
      type: 'line',
      data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [
          {
            label: 'Setoran',
            data: [12, 19, 15, 25, 22, 30, 28],
            borderColor: '#97BC62',
            backgroundColor: 'rgba(151, 188, 98, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#97BC62',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'Penarikan',
            data: [8, 12, 10, 15, 13, 18, 16],
            borderColor: '#FFD93D',
            backgroundColor: 'rgba(255, 217, 61, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#FFD93D',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'Akun',
            data: [5, 8, 6, 10, 8, 12, 10],
            borderColor: '#2C5F2D',
            backgroundColor: 'rgba(44, 95, 45, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#2C5F2D',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 12,
                family: "'Segoe UI', sans-serif"
              }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            },
            cornerRadius: 8
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: {
                size: 11
              }
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 11
              }
            }
          }
        },
        layout: {
          padding: 10
        }
      }
    });
  }

  const pieCtx = document.getElementById('pieChart');
  if (pieCtx) {
    new Chart(pieCtx, {
      type: 'doughnut',
      data: {
        labels: ['Log Akun', 'Log Setoran', 'Log Penarikan'],
        datasets: [{
          data: [{{ $logAkun->count() }}, {{ $logSetor->count() }}, {{ $logTarik->count() }}],
          backgroundColor: [
            '#2C5F2D',
            '#97BC62',
            '#FFD93D'
          ],
          borderWidth: 0,
          hoverOffset: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 1,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            cornerRadius: 8,
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            }
          }
        },
        cutout: '65%',
        layout: {
          padding: 10
        }
      }
    });
  }

  const searchTeller = document.getElementById('searchTeller');
  if (searchTeller) {
    searchTeller.addEventListener('input', function() {
      const query = this.value.toLowerCase();
      const rows = document.querySelectorAll('.teller-row');
      
      rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const email = row.querySelector('.email-wrapper span').textContent.toLowerCase();
        
        if (name.includes(query) || email.includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  }

  const tellerFilter = document.getElementById('tellerFilter');
  if (tellerFilter) {
    tellerFilter.addEventListener('change', function() {
      const tellerId = this.value;
      const rows = document.querySelectorAll('.log-row');
      
      rows.forEach(row => {
        if (tellerId === '' || row.getAttribute('data-teller-id') === tellerId) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  }
});

function viewTellerDetail(id, name, email, createdAt) {
  const content = `
    <div class="detail-grid">
      <div class="detail-item">
        <div class="detail-label">
          <i class="bi bi-person-circle"></i> Nama Teller
        </div>
        <div class="detail-value">
          ${name}
          <span class="detail-badge">ID: ${id}</span>
        </div>
      </div>

      <div class="detail-item">
        <div class="detail-label">
          <i class="bi bi-envelope"></i> Email
        </div>
        <div class="detail-value">
          ${email}
        </div>
      </div>

      <div class="detail-item">
        <div class="detail-label">
          <i class="bi bi-calendar"></i> Tanggal Bergabung
        </div>
        <div class="detail-value">
          ${createdAt}
        </div>
      </div>

      <div class="detail-item">
        <div class="detail-label">
          <i class="bi bi-shield-check"></i> Status
        </div>
        <div class="detail-value">
          <span class="status-badge status-active">
            <i class="bi bi-check-circle-fill"></i> Aktif
          </span>
        </div>
      </div>
    </div>
  `;

  document.getElementById('tellerDetailContent').innerHTML = content;
  new bootstrap.Modal(document.getElementById('tellerDetailModal')).show();
}

function confirmDelete(url, name) {
  document.getElementById('deleteMessage').textContent = `Anda akan menghapus teller "${name}". Tindakan ini tidak dapat dibatalkan.`;
  document.getElementById('deleteForm').action = url;
  new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
}

function showLogDetail(logId, type) {
  // Set subtitle
  document.getElementById('logDetailSubtitle').textContent = `ID Log: #${logId} - ${type}`;
  
  // Show modal immediately
  const modal = new bootstrap.Modal(document.getElementById('logDetailModal'));
  modal.show();
  
  // Simulate data loading (replace with your actual data)
  setTimeout(() => {
    const logData = @json($logs->keyBy('id'));
    const log = logData[logId];
    
    if (log) {
      const content = `
        <div class="detail-grid">
          <div class="detail-item">
            <div class="detail-label">
              <i class="bi bi-person-circle"></i> Teller
            </div>
            <div class="detail-value">
              ${log.user ? log.user.name : 'Unknown'}
              <span class="detail-badge">ID: ${log.user_id}</span>
            </div>
          </div>
          
          <div class="detail-item">
            <div class="detail-label">
              <i class="bi bi-lightning"></i> Aksi
            </div>
            <div class="detail-value">
              <span class="action-badge action-badge-primary">${log.aksi}</span>
            </div>
          </div>
          
          <div class="detail-item">
            <div class="detail-label">
              <i class="bi bi-tag"></i> Entitas
            </div>
            <div class="detail-value">
              ${log.entitas} <span class="detail-badge">#${log.entitas_id}</span>
            </div>
          </div>
          
          <div class="detail-item">
            <div class="detail-label">
              <i class="bi bi-pc-display"></i> IP Address
            </div>
            <div class="detail-value">
              <code>${log.ip_addr || '-'}</code>
            </div>
          </div>
          
          <div class="detail-item detail-item-full">
            <div class="detail-label">
              <i class="bi bi-clock"></i> Waktu Aktivitas
            </div>
            <div class="detail-value">
              ${new Date(log.created_at).toLocaleString('id-ID', {
                weekday: 'long',
                year: 'numeric', 
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
              })}
            </div>
          </div>
        </div>
      `;
      
      document.getElementById('logDetailContent').innerHTML = content;
    } else {
      document.getElementById('logDetailContent').innerHTML = `
        <div class="text-center py-4">
          <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
          <h6 class="mt-3">Data Tidak Ditemukan</h6>
          <p class="text-muted">Log dengan ID ${logId} tidak ditemukan</p>
        </div>
      `;
    }
  }, 500);
}

function getStatusBadge(status) {
  switch(status) {
    case 'pending':
      return '<span class="status-badge status-pending"><i class="bi bi-hourglass-split"></i> Pending</span>';
    case 'sukses':
      return '<span class="status-badge status-success"><i class="bi bi-check-circle"></i> Sukses</span>';
    default:
      return '<span class="status-badge status-failed"><i class="bi bi-x-circle"></i> Gagal</span>';
  }
}

function showAllLogs(type) {
  window.location.href = `/admin/logs?type=${type}`;
}

function exportLogs() {
  const tellerId = document.getElementById('tellerFilter').value;
  const url = tellerId ? `/admin/logs/export?teller=${tellerId}` : '/admin/logs/export';
  window.open(url, '_blank');
  const params = new URLSearchParams({
  teller: tellerId || '',
  date_from: '2025-09-01',
  date_to: '2025-09-30',
  type: 'update_teller'
});
window.open(`/admin/logs/export?${params.toString()}`, '_blank');
}

function printLogDetail() {
  const content = document.getElementById('logDetailContent').innerHTML;
  const printWindow = window.open('', '_blank');
  printWindow.document.write(`
    <html>
      <head>
        <title>Detail Log Aktivitas</title>
        <style>
          body { font-family: Arial, sans-serif; padding: 20px; }
          .detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
          .detail-item { margin-bottom: 15px; }
          .detail-label { font-weight: bold; margin-bottom: 5px; }
          .detail-value { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
          .detail-item-full { grid-column: 1 / -1; }
          @media print { body { margin: 0; padding: 10px; } }
        </style>
      </head>
      <body>
        <h2>Detail Log Aktivitas - Bank Mini Tsamaniyah</h2>
        ${content}
      </body>
    </html>
  `);
  printWindow.document.close();
  printWindow.print();
}

(function initClock(){
  const seedEl = document.getElementById('serverNow');
  if (!seedEl) return;

  const tz   = seedEl.dataset.tz || 'Asia/Jakarta';
  // Waktu server (UTC) → Date
  const base = new Date(seedEl.dataset.now); // ISO UTC dari server
  const start = Date.now();

  const fmtTime = new Intl.DateTimeFormat('id-ID', {
    hour: '2-digit', minute: '2-digit', second: '2-digit',
    hour12: false, timeZone: tz
  });
  const fmtDate = new Intl.DateTimeFormat('id-ID', {
    weekday: 'long', day: '2-digit', month: 'long', year: 'numeric',
    timeZone: tz
  });

  const elTime = document.getElementById('currentTime');
  const elDate = document.getElementById('currentDate');

  function tick(){
    // tambah selisih waktu real sejak halaman dimuat
    const elapsed = Date.now() - start;
    const nowTz = new Date(base.getTime() + elapsed);

    elTime.textContent = fmtTime.format(nowTz);
    elDate.textContent = fmtDate.format(nowTz);
  }

  tick();
  setInterval(tick, 1000);
})();
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
  --primary-green: #2C5F2D;
  --success-green: #97BC62;
  --warning-yellow: #FFD93D;
  --cream: #FFF8E7;
  --dark-green: #1a3a1b;
  --light-green: #e8f5e9;
  --gradient-primary: linear-gradient(135deg, #2C5F2D 0%, #1a3a1b 100%);
  --gradient-success: linear-gradient(135deg, #97BC62 0%, #7ba04e 100%);
  --gradient-warning: linear-gradient(135deg, #FFD93D 0%, #ffc107 100%);
  --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
  --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
  --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.16);
}

.btn-mini-detail {
  width: 28px;
  height: 28px;
  border-radius: 6px;
  border: none;
  background: rgba(23, 162, 184, 0.1);
  color: #17a2b8;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  transition: all 0.3s ease;
  cursor: pointer;
  flex-shrink: 0;
}

.btn-mini-detail:hover {
  background: #17a2b8;
  color: white;
  transform: scale(1.1);
}

.activity-item {
  display: flex;
  gap: 12px;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  align-items: center;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.detail-item-full {
  grid-column: 1 / -1;
}

.detail-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c757d;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 8px;
}

.detail-value {
  font-size: 0.875rem;
  color: #212529;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.detail-badge {
  padding: 2px 8px;
  background: #e9ecef;
  border-radius: 4px;
  font-size: 0.7rem;
  font-weight: 600;
  color: #6c757d;
}

.action-badge-primary {
  background: rgba(44, 95, 45, 0.1);
  color: #2C5F2D;
  border: 1px solid rgba(44, 95, 45, 0.2);
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
}

* {
  font-family: 'Inter', 'Segoe UI', sans-serif;
}

body {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
}

.admin-dashboard {
  background: transparent;
}

.dashboard-header {
  background: var(--gradient-primary);
  position: relative;
  overflow: hidden;
  margin-bottom: 2rem;
  border-radius: 0 0 24px 24px;
  box-shadow: var(--shadow-lg);
}

.dashboard-header::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h100v100H0z' fill='%23ffffff' fill-opacity='0.03'/%3E%3Cpath d='M50 0L0 50 0 100 50 50 100 100 100 50z' fill='%23ffffff' fill-opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.3;
}

.brand-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  padding: 8px 16px;
  border-radius: 50px;
  color: #FFD93D;
  font-weight: 600;
  font-size: 0.875rem;
  letter-spacing: 0.5px;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.brand-badge i {
  font-size: 1.2rem;
}

.header-time-card {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  padding: 1.25rem 1.5rem;
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.time-display {
  display: flex;
  align-items: center;
  color: white;
}

.current-time {
  font-size: 1.5rem;
  color: white;
  letter-spacing: 1px;
}

.current-date {
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.8);
  margin-top: 2px;
}

.alert-modern {
  display: flex;
  align-items: center;
  gap: 1rem;
  border: none;
  border-radius: 12px;
  padding: 1rem 1.25rem;
  box-shadow: var(--shadow-sm);
}

.alert-icon {
  flex-shrink: 0;
  font-size: 1.5rem;
}

.alert-content strong {
  display: block;
  margin-bottom: 0.25rem;
}

.stat-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}

.stat-card-body {
  padding: 1.5rem;
  position: relative;
}

.stat-icon-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
  position: relative;
}

.stat-card-primary .stat-icon {
  background: linear-gradient(135deg, rgba(44, 95, 45, 0.1) 0%, rgba(44, 95, 45, 0.2) 100%);
  color: var(--primary-green);
}

.stat-card-success .stat-icon {
  background: linear-gradient(135deg, rgba(151, 188, 98, 0.1) 0%, rgba(151, 188, 98, 0.2) 100%);
  color: var(--success-green);
}

.stat-card-danger .stat-icon {
  background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.2) 100%);
  color: #dc3545;
}

.stat-card-warning .stat-icon {
  background: linear-gradient(135deg, rgba(255, 217, 61, 0.1) 0%, rgba(255, 217, 61, 0.2) 100%);
  color: #f39c12;
}

.stat-badge {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.875rem;
  color: white;
}

.stat-card-primary .stat-badge {
  background: var(--primary-green);
}

.stat-card-success .stat-badge {
  background: var(--success-green);
}

.stat-card-danger .stat-badge {
  background: #dc3545;
}

.stat-card-warning .stat-badge {
  background: #f39c12;
}

.stat-card:hover .stat-badge {
  animation: pulse-hover 1s ease-out;
}

@keyframes pulse-hover {
  0%, 100% { 
    box-shadow: 0 0 0 0 rgba(44, 95, 45, 0.7); 
    transform: scale(1);
  }
  50% { 
    box-shadow: 0 0 0 10px rgba(44, 95, 45, 0); 
    transform: scale(1.1);
  }
}

.stat-content {
  flex: 1;
}

.stat-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c757d;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.stat-value {
  font-size: 2.25rem;
  font-weight: 800;
  color: #212529;
  line-height: 1;
  margin-bottom: 0.5rem;
}

.stat-desc {
  font-size: 0.875rem;
}

.stat-trend {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 4px 8px;
  border-radius: 6px;
  font-weight: 500;
  font-size: 0.75rem;
}

.stat-trend.positive {
  background: rgba(151, 188, 98, 0.1);
  color: var(--success-green);
}

.stat-trend.negative {
  background: rgba(220, 53, 69, 0.1);
  color: #dc3545;
}

.stat-footer {
  padding: 0;
}

.modern-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  border: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.modern-card:hover {
  box-shadow: var(--shadow-md);
}

.card-gradient-primary {
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.card-gradient-success {
  background: linear-gradient(135deg, #ffffff 0%, #f1f8f4 100%);
}

.card-gradient-teller {
  background: linear-gradient(135deg, #ffffff 0%, #fff8e7 100%);
}

.card-gradient-log {
  background: linear-gradient(135deg, #ffffff 0%, #fef5e7 100%);
}

.modern-card-header {
  padding: 1.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
}

.card-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 0;
}

.card-subtitle {
  font-size: 0.875rem;
  color: #6c757d;
}

.modern-card-body {
  padding: 1.5rem;
}

.modern-card-footer {
  padding: 1rem 1.5rem;
  background: rgba(248, 249, 250, 0.5);
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.search-box {
  position: relative;
  display: inline-block;
}

.search-box i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
  font-size: 0.875rem;
}

.search-box .form-control {
  padding-left: 36px;
  border-radius: 10px;
  border: 1px solid #dee2e6;
  font-size: 0.875rem;
  width: 250px;
  transition: all 0.3s ease;
}

.search-box .form-control:focus {
  border-color: var(--primary-green);
  box-shadow: 0 0 0 3px rgba(44, 95, 45, 0.1);
  width: 300px;
}

.btn-modern {
  border-radius: 10px;
  padding: 0.625rem 1.25rem;
  font-weight: 600;
  font-size: 0.875rem;
  transition: all 0.3s ease;
  border: none;
  box-shadow: var(--shadow-sm);
}

.btn-modern:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.btn-primary {
  background: var(--gradient-primary);
}

.btn-primary:hover {
  background: var(--dark-green);
}

.table-scroll-container {
  max-height: 500px;
  overflow-y: auto;
  overflow-x: auto;
}

.table-scroll-container::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

.table-scroll-container::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.table-scroll-container::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--success-green) 100%);
  border-radius: 10px;
}

.table-scroll-container::-webkit-scrollbar-thumb:hover {
  background: var(--dark-green);
}

.table-modern {
  font-size: 0.9rem;
}

.table-modern thead tr {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.table-modern thead th {
  padding: 1rem 1.25rem;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.5px;
  color: #495057;
  border: none;
}

.th-content {
  display: flex;
  align-items: center;
}

.table-modern tbody td {
  padding: 1.25rem 1.25rem;
  vertical-align: middle;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.table-row-hover {
  transition: all 0.3s ease;
  cursor: pointer;
}

.table-row-hover:hover {
  background: rgba(44, 95, 45, 0.03);
  transform: scale(1.005);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.avatar-gradient {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: var(--gradient-primary);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1rem;
  box-shadow: 0 4px 12px rgba(44, 95, 45, 0.3);
}

.avatar-gradient-small {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: var(--gradient-success);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.875rem;
  box-shadow: 0 2px 8px rgba(151, 188, 98, 0.3);
}

.user-details {
  flex: 1;
}

.user-name {
  font-weight: 600;
  color: #212529;
  margin-bottom: 2px;
}

.user-name-small {
  font-weight: 600;
  color: #212529;
  font-size: 0.875rem;
}

.user-id {
  font-size: 0.75rem;
  color: #6c757d;
}

.email-wrapper {
  display: flex;
  align-items: center;
  color: #495057;
}

.date-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 12px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  color: #495057;
}

.time-badge {
  margin-left: 8px;
  padding: 2px 8px;
  background: white;
  border-radius: 4px;
  font-size: 0.75rem;
  color: #6c757d;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 20px;
  font-weight: 600;
  font-size: 0.8125rem;
}

.status-active {
  background: linear-gradient(135deg, rgba(151, 188, 98, 0.15) 0%, rgba(151, 188, 98, 0.25) 100%);
  color: var(--success-green);
  border: 1px solid rgba(151, 188, 98, 0.3);
}

.status-pending {
  background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 193, 7, 0.25) 100%);
  color: #f39c12;
  border: 1px solid rgba(255, 193, 7, 0.3);
}

.status-success {
  background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.25) 100%);
  color: #28a745;
  border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-failed {
  background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(220, 53, 69, 0.25) 100%);
  color: #dc3545;
  border: 1px solid rgba(220, 53, 69, 0.3);
}

.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: center;
}

.btn-action {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  cursor: pointer;
  font-size: 0.875rem;
}

.btn-action-view {
  background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
  color: white;
}

.btn-action-view:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
}

.btn-action-edit {
  background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
  color: white;
}

.btn-action-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

.btn-action-delete {
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: white;
}

.btn-action-delete:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.activity-card {
  height: 100%;
}

.activity-card .modern-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
}

.activity-card-primary .modern-card-header {
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
  color: white;
}

.activity-card-success .modern-card-header {
  background: linear-gradient(135deg, var(--success-green) 0%, #7ba04e 100%);
  color: white;
}

.activity-card-warning .modern-card-header {
  background: linear-gradient(135deg, var(--warning-yellow) 0%, #ffc107 100%);
  color: #212529;
}

.activity-count {
  width: 36px;
  height: 36px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.875rem;
}

.activity-scroll {
  max-height: 400px;
  overflow-y: auto;
  overflow-x: hidden;
}

.activity-scroll::-webkit-scrollbar {
  width: 6px;
}

.activity-scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.activity-scroll::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--success-green) 100%);
  border-radius: 10px;
}

.activity-scroll::-webkit-scrollbar-thumb:hover {
  background: var(--primary-green);
}

.activity-item {
  display: flex;
  gap: 12px;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.activity-item:hover {
  background: rgba(44, 95, 45, 0.03);
  transform: translateX(4px);
}

.activity-item:last-child {
  border-bottom: none;
}

.activity-indicator {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin-top: 6px;
  flex-shrink: 0;
  position: relative;
}

.activity-item:hover .activity-indicator::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  animation: ripple 1.5s ease-out;
}

.activity-indicator-primary {
  background: var(--primary-green);
}

.activity-indicator-primary::after {
  background: var(--primary-green);
}

.activity-indicator-success {
  background: var(--success-green);
}

.activity-indicator-success::after {
  background: var(--success-green);
}

.activity-indicator-warning {
  background: var(--warning-yellow);
}

.activity-indicator-warning::after {
  background: var(--warning-yellow);
}

@keyframes ripple {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  100% {
    transform: scale(3);
    opacity: 0;
  }
}

.activity-content {
  flex: 1;
}

.activity-title {
  font-weight: 600;
  color: #212529;
  font-size: 0.875rem;
  margin-bottom: 4px;
}

.activity-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  font-size: 0.75rem;
  color: #6c757d;
}

.activity-user,
.activity-time {
  display: flex;
  align-items: center;
  gap: 4px;
}

.activity-empty {
  padding: 3rem 1rem;
  text-align: center;
  color: #adb5bd;
}

.activity-empty i {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: block;
}

.activity-empty p {
  margin: 0;
  font-size: 0.875rem;
}

.view-all-link {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--primary-green);
  font-weight: 600;
  font-size: 0.875rem;
  text-decoration: none;
  transition: all 0.3s ease;
}

.view-all-link:hover {
  color: var(--dark-green);
  gap: 12px;
}

.timestamp-badge {
  display: inline-block;
}

.timestamp-date {
  font-weight: 600;
  color: #495057;
  font-size: 0.875rem;
  margin-bottom: 2px;
}

.timestamp-time {
  font-size: 0.75rem;
  color: #6c757d;
  font-family: 'Courier New', monospace;
}

.action-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.8125rem;
}

.action-badge-info {
  background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(23, 162, 184, 0.25) 100%);
  color: #17a2b8;
  border: 1px solid rgba(23, 162, 184, 0.3);
}

.action-badge-primary {
  background: linear-gradient(135deg, rgba(44, 95, 45, 0.15) 0%, rgba(44, 95, 45, 0.25) 100%);
  color: var(--primary-green);
  border: 1px solid rgba(44, 95, 45, 0.3);
}

.entity-badge {
  display: flex;
  align-items: center;
  gap: 8px;
}

.entity-type {
  font-weight: 500;
  color: #495057;
  font-size: 0.875rem;
}

.entity-id {
  padding: 2px 8px;
  background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.75rem;
  color: #495057;
  font-family: 'Courier New', monospace;
}

.ip-code {
  padding: 4px 10px;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 6px;
  font-size: 0.8125rem;
  color: #495057;
  font-family: 'Courier New', monospace;
}

.btn-detail {
  padding: 8px 16px;
  background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.8125rem;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.btn-detail:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
}

.modal-modern {
  border-radius: 20px;
  border: none;
  overflow: hidden;
}

.modal-header-modern {
  background: var(--gradient-primary);
  color: white;
  padding: 1.5rem;
  border: none;
}

.modal-header-danger {
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: white;
  padding: 1.5rem;
  border: none;
}

.modal-header-modern .modal-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 4px;
}

.modal-subtitle {
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.8);
}

.modal-body-modern {
  padding: 2rem;
}

.modal-footer-modern {
  padding: 1.25rem 1.5rem;
  background: #f8f9fa;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.detail-item-full {
  grid-column: 1 / -1;
}

.detail-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c757d;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
}

.detail-value {
  font-size: 0.9375rem;
  color: #212529;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.detail-badge {
  padding: 4px 10px;
  background: #e9ecef;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6c757d;
}

.transaction-detail-section {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 2px dashed rgba(0, 0, 0, 0.1);
}

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.125rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 1.5rem;
}

.transaction-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 0.875rem;
}

.transaction-deposit {
  background: linear-gradient(135deg, rgba(151, 188, 98, 0.15) 0%, rgba(151, 188, 98, 0.25) 100%);
  color: var(--success-green);
  border: 1px solid rgba(151, 188, 98, 0.3);
}

.transaction-withdraw {
  background: linear-gradient(135deg, rgba(255, 217, 61, 0.15) 0%, rgba(255, 217, 61, 0.25) 100%);
  color: #f39c12;
  border: 1px solid rgba(255, 217, 61, 0.3);
}

.nominal-amount {
  font-size: 1.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--success-green) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.empty-state {
  padding: 4rem 2rem;
  text-align: center;
}

.empty-icon {
  font-size: 4rem;
  color: #dee2e6;
  margin-bottom: 1.5rem;
}

.empty-state h6 {
  font-weight: 700;
  color: #495057;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #6c757d;
  font-size: 0.875rem;
  margin-bottom: 1.5rem;
}

.pagination-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.pagination-info {
  font-size: 0.875rem;
  color: #6c757d;
  font-weight: 500;
}

.pagination-modern .pagination {
  margin: 0;
  gap: 6px;
}

.pagination-modern .page-link {
  border-radius: 8px;
  border: 1px solid #dee2e6;
  color: var(--primary-green);
  font-weight: 600;
  padding: 0.5rem 0.875rem;
  transition: all 0.3s ease;
}

.pagination-modern .page-link:hover {
  background: var(--light-green);
  border-color: var(--primary-green);
  transform: translateY(-2px);
}

.pagination-modern .page-item.active .page-link {
  background: var(--gradient-primary);
  border-color: var(--primary-green);
  box-shadow: 0 4px 12px rgba(44, 95, 45, 0.3);
}

.legend-custom {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 1rem;
  background: rgba(248, 249, 250, 0.5);
  border-radius: 12px;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.875rem;
  font-weight: 500;
  color: #495057;
}

.legend-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  flex-shrink: 0;
}

@media (max-width: 1200px) {
  .stat-value {
    font-size: 1.75rem;
  }
  
  .search-box .form-control {
    width: 200px;
  }
  
  .search-box .form-control:focus {
    width: 250px;
  }
}

@media (max-width: 992px) {
  .header-time-card {
    margin-top: 1rem;
  }
  
  .dashboard-header .col-lg-4 {
    text-align: left !important;
  }
  
  .detail-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .container-fluid {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .stat-icon {
    width: 50px;
    height: 50px;
    font-size: 1.5rem;
  }
  
  .stat-value {
    font-size: 1.5rem;
  }
  
  .modern-card-header {
    padding: 1rem;
  }
  
  .modern-card-body {
    padding: 1rem;
  }
  
  .table-modern {
    font-size: 0.8125rem;
  }
  
  .table-modern thead th,
  .table-modern tbody td {
    padding: 0.75rem 0.5rem;
  }
  
  .user-info {
    gap: 8px;
  }
  
  .avatar-gradient {
    width: 40px;
    height: 40px;
    font-size: 0.875rem;
  }
  
  .search-box .form-control {
    width: 100%;
  }
  
  .btn-modern {
    width: 100%;
    margin-top: 0.5rem;
  }
  
  .action-buttons {
    flex-wrap: wrap;
  }
  
  .pagination-wrapper {
    flex-direction: column;
    text-align: center;
  }
}

@media (max-width: 576px) {
  .dashboard-header {
    border-radius: 0;
  }
  
  .brand-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
  }
  
  .stat-card-body {
    padding: 1rem;
  }
  
  .stat-icon-wrapper {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .activity-scroll {
    max-height: 300px;
  }
  
  .table-responsive {
    font-size: 0.75rem;
  }
  
  .modern-card-header .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 1rem;
  }
  
  .btn-group {
    width: 100%;
  }
  
  .btn-group .btn {
    flex: 1;
  }
}

@media print {
  .dashboard-header,
  .btn,
  .btn-action,
  .pagination,
  .search-box {
    display: none !important;
  }
  
  .modern-card {
    break-inside: avoid;
    box-shadow: none;
    border: 1px solid #dee2e6;
  }
}

.modern-card,
.stat-card {
  opacity: 1;
  transform: translateY(0);
}

.stat-card:hover {
  animation: cardBounce 0.6s ease-out;
}

@keyframes cardBounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-8px);
  }
}

::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--success-green) 100%);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: var(--dark-green);
}

.table-row-hover:hover {
  animation: rowShimmer 0.6s ease-out;
}

@keyframes rowShimmer {
  0% {
    background: rgba(44, 95, 45, 0);
  }
  50% {
    background: rgba(44, 95, 45, 0.05);
  }
  100% {
    background: rgba(44, 95, 45, 0.03);
  }
}

.btn-modern:hover,
.btn-action:hover,
.btn-detail:hover {
  animation: buttonPop 0.3s ease-out;
}

@keyframes buttonPop {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-4px);
  }
}

.view-all-link:hover {
  animation: linkSlide 0.4s ease-out;
}

@keyframes linkSlide {
  0%, 100% {
    transform: translateX(0);
  }
  50% {
    transform: translateX(4px);
  }
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection