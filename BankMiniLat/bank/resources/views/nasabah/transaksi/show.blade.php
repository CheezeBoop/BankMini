@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Detail Transaksi</h3>

  <div class="card mt-3">
    <div class="card-body">
      <p><strong>ID Transaksi:</strong> #{{ $trx->id }}</p>
      <p><strong>Jenis:</strong> {{ $trx->jenis }}</p>
      <p><strong>Nominal:</strong> Rp {{ number_format($trx->nominal, 0, ',', '.') }}</p>
      <p><strong>Status:</strong> {{ $trx->status }}</p>
      <p><strong>Tanggal:</strong> {{ $trx->created_at->format('d M Y H:i') }}</p>
      <p><strong>Keterangan:</strong> {{ $trx->keterangan ?? '-' }}</p>
    </div>
  </div>

  <a href="{{ route('nasabah.transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
