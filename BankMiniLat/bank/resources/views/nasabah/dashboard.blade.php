@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-3">Dashboard Nasabah</h3>
  <p>Halo, {{ Auth::user()->name }}!</p>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
  @endif

  @if(isset($rekening))
    <div class="card mb-4">
      <div class="card-body">
        <p><strong>No Rekening:</strong> {{ $rekening->no_rekening }}</p>
        <p><strong>Saldo:</strong> Rp {{ number_format($rekening->saldo, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> 
          @if($nasabah->status === 'AKTIF')
            <span class="badge bg-success">AKTIF</span>
          @else
            <span class="badge bg-danger">NONAKTIF</span>
          @endif
        </p>
      </div>
    </div>

    @if($nasabah->status === 'AKTIF')
      {{-- Form Request Setor --}}
      <div class="card mb-4">
        <div class="card-header">Request Setor</div>
        <div class="card-body">
          <form method="POST" action="{{ route('nasabah.deposit.request') }}">
            @csrf
            <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
            <div class="input-group">
              <input type="number" name="nominal" placeholder="Nominal" class="form-control" required min="1">
              <button class="btn btn-success">Setor</button>
            </div>
          </form>
        </div>
      </div>

      {{-- Form Request Tarik --}}
      <div class="card mb-4">
        <div class="card-header">Request Tarik</div>
        <div class="card-body">
          <form method="POST" action="{{ route('nasabah.withdraw.request') }}">
            @csrf
            <input type="hidden" name="rekening_id" value="{{ $rekening->id }}">
            <div class="input-group">
              <input type="number" name="nominal" placeholder="Nominal" class="form-control" required min="1">
              <button class="btn btn-warning">Tarik</button>
            </div>
          </form>
        </div>
      </div>
    @else
      <div class="alert alert-danger">
        Akun Anda sedang <strong>NONAKTIF</strong>. Anda tidak dapat melakukan setor atau tarik. <strong>Hubungi teller</strong> untuk mengaktifkan kembali akun Anda.
      </div>
    @endif

    {{-- Riwayat Transaksi --}}
    <div class="card">
      <div class="card-header">Riwayat Transaksi</div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Jenis</th>
              <th>Nominal</th>
              <th>Status</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rekening->transaksi as $trx)
              <tr>
                <td>{{ $trx->id }}</td>
                <td>{{ $trx->jenis }}</td>
                <td>Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                <td>{{ $trx->status }}</td>
                <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada transaksi</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  @else
    <div class="alert alert-warning">
      Anda belum memiliki rekening aktif. Silakan hubungi teller.
    </div>
  @endif
</div>
@endsection
