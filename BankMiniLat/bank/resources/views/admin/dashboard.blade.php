@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-3">Admin Dashboard</h3>
  <p>Halo, {{ Auth::user()->name }}!</p>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Daftar Teller --}}
  <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Daftar Teller</h5>
      <a href="{{ route('admin.teller.create') }}" class="btn btn-primary btn-sm">
        + Buat Teller Baru
      </a>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tellers as $t)
            <tr>
              <td>{{ $t->name }}</td>
              <td>{{ $t->email }}</td>
              <td>{{ $t->created_at->format('d M Y H:i') }}</td>
              <td>
                <form action="{{ route('admin.teller.remove',$t->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus teller ini?')">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Belum ada teller terdaftar</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- 3 Card Ringkas --}}
  <div class="row mt-4">
    {{-- Log Akun --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header bg-primary text-white">Log Akun</div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <tbody>
              @forelse($logAkun as $log)
                <tr>
                  <td>{{ $log->created_at->format('d M H:i') }}</td>
                  <td>{{ $log->aksi }} ({{ $log->user->name ?? '-' }})</td>
                </tr>
              @empty
                <tr><td class="text-center">Kosong</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Log Setoran --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header bg-success text-white">Log Setoran</div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <tbody>
              @forelse($logSetor as $log)
                <tr>
                  <td>{{ $log->created_at->format('d M H:i') }}</td>
                  <td>{{ $log->aksi }} ({{ $log->user->name ?? '-' }})</td>
                </tr>
              @empty
                <tr><td class="text-center">Kosong</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Log Tarik --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header bg-danger text-white">Log Tarik</div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <tbody>
              @forelse($logTarik as $log)
                <tr>
                  <td>{{ $log->created_at->format('d M H:i') }}</td>
                  <td>{{ $log->aksi }} ({{ $log->user->name ?? '-' }})</td>
                </tr>
              @empty
                <tr><td class="text-center">Kosong</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Log Aktivitas Teller Detail --}}
  <div class="card mt-4">
    <div class="card-header">
      <h5 class="mb-0">Log Aktivitas Teller (20 terakhir)</h5>
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered mb-0">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>Teller</th>
            <th>Aksi</th>
            <th>Entitas</th>
            <th>IP</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
            <tr>
              <td>{{ $log->created_at->format('d M Y H:i') }}</td>
              <td>{{ $log->user->name ?? '-' }}</td>
              <td>{{ $log->aksi }}</td>
              <td>{{ $log->entitas }} #{{ $log->entitas_id }}</td>
              <td>{{ $log->ip_addr ?? '-' }}</td>
              <td>
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#logDetail{{ $log->id }}">
                  Detail
                </button>
              </td>
            </tr>

            <!-- Modal detail -->
            <div class="modal fade" id="logDetail{{ $log->id }}" tabindex="-1" aria-labelledby="logDetailLabel{{ $log->id }}" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="logDetailLabel{{ $log->id }}">Detail Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p><strong>Teller:</strong> {{ $log->user->name ?? '-' }} (ID: {{ $log->user_id }})</p>
                    <p><strong>Aksi:</strong> {{ $log->aksi }}</p>
                    <p><strong>Entitas:</strong> {{ $log->entitas }} #{{ $log->entitas_id }}</p>
                    <p><strong>IP Address:</strong> {{ $log->ip_addr ?? '-' }}</p>
                    <p><strong>Waktu:</strong> {{ $log->created_at->format('d M Y H:i:s') }}</p>

                    @if($log->entitas === 'transaksi')
                      @php
                        $trx = \App\Models\Transaksi::find($log->entitas_id);
                      @endphp
                      @if($trx)
                        <hr>
                        <h6>Detail Transaksi</h6>
                        <p><strong>Jenis:</strong> {{ $trx->jenis }}</p>
                        <p><strong>Nominal:</strong> Rp {{ number_format($trx->nominal) }}</p>
                        <p><strong>Status:</strong> {{ $trx->status }}</p>
                        <p><strong>Saldo Setelah:</strong> {{ $trx->saldo_setelah ?? '-' }}</p>
                        <p><strong>Keterangan:</strong> {{ $trx->keterangan ?? '-' }}</p>
                      @endif
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <tr>
              <td colspan="6" class="text-center">Belum ada aktivitas teller</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
