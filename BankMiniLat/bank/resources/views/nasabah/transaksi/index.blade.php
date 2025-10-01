@extends('layouts.app')

@section('content')
<style>
  .history-card {
    background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,0,0,.1); overflow:hidden;
  }
  .history-header {
    padding:18px 20px;
    background:linear-gradient(135deg, #10b981, #059669);
    color:#fff; display:flex; align-items:center; gap:10px;
  }
  .history-header i { font-size:22px; }
  .history-header h4 { font-size:18px; font-weight:700; margin:0; }

  .transaction-table { width:100%; border-collapse:collapse; }
  .transaction-table thead { background:#f9fafb; }
  .transaction-table th {
    padding:14px; font-size:12px; font-weight:700;
    color:#4b5563; text-transform:uppercase;
    border-bottom:2px solid #e5e7eb;
  }
  .transaction-table td {
    padding:12px; border-bottom:1px solid #f3f4f6; color:#1f2937;
  }
  .table-wrap { overflow-x:auto; }

  .transaction-type { padding:6px 10px; border-radius:8px; font-weight:600; font-size:13px; display:inline-flex; gap:6px; align-items:center; }
  .transaction-type.setor { background:#d1fae5; color:#065f46; }
  .transaction-type.tarik { background:#fef3c7; color:#92400e; }

  .transaction-status { padding:6px 10px; border-radius:8px; font-weight:600; font-size:12px; display:inline-flex; gap:6px; align-items:center; }
  .transaction-status.pending { background:#fef3c7; color:#92400e; }
  .transaction-status.approved { background:#d1fae5; color:#065f46; }
  .transaction-status.rejected { background:#fee2e2; color:#991b1b; }

  .empty-state { text-align:center; padding:40px 20px; color:#6b7280; }
  .empty-icon {
    width:100px; height:100px; margin:0 auto 12px;
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    background:#f3f4f6; font-size:40px; color:#9ca3af;
  }
</style>

<div class="dashboard-wrapper">
  @include('nasabah.partials.sidebar')

  <div class="main-content">
    <div class="top-header">
      <div class="welcome-text">
        <h3>Riwayat Transaksi</h3>
        <p>Lihat semua transaksi Anda di sini.</p>
      </div>
      <div class="header-actions">
        <div class="time-display">
          <i class="bi bi-clock"></i>
          <span id="currentTime">--:--:--</span>
        </div>
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
      </div>
    </div>

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
            @forelse($transaksi as $trx)
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
                <td><strong>Rp {{ number_format($trx->nominal,0,',','.') }}</strong></td>
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
                    <div>Belum ada transaksi</div>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  // Live Clock
  function updateTime(){
    const now=new Date();
    document.getElementById('currentTime').textContent=
      now.toLocaleTimeString('id-ID',{hour12:false});
  }
  updateTime(); setInterval(updateTime,1000);
</script>
@endsection
