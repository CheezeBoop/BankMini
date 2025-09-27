@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-3">Laporan Transaksi Nasabah</h3>

  {{-- Info Nasabah --}}
  <p>
    <strong>{{ $nas->nama }}</strong> 
    @if($nas->nis_nip)
      ({{ $nas->nis_nip }})
    @endif
    <br>
    Email: {{ $nas->email ?? '-' }} <br>
    No HP: {{ $nas->no_hp ?? '-' }}
  </p>

  {{-- Tabel Transaksi --}}
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>No Rekening</th>
        <th>Jenis</th>
        <th>Nominal</th>
        <th>Status</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @php $total = 0; @endphp
      @foreach($nas->rekenings as $rek)
        @foreach($rek->transaksi as $trx)
          <tr>
            <td>{{ $trx->id }}</td>
            <td>{{ $rek->no_rekening }}</td>
            <td>{{ $trx->jenis }}</td>
            <td>Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
            <td>{{ $trx->status }}</td>
            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
          </tr>
          @php $total += $trx->nominal; @endphp
        @endforeach
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total Transaksi</th>
        <th colspan="3">Rp {{ number_format($total, 0, ',', '.') }}</th>
      </tr>
    </tfoot>
  </table>

  <div class="mt-3">
    <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">Kembali</a>
    <button class="btn btn-primary" onclick="window.print()">Cetak</button>
  </div>
</div>
@endsection
