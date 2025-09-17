@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Laporan Transaksi Nasabah</h3>
  <p><strong>{{ $nas->nama }}</strong> ({{ $nas->nis_nip }})</p>
  <table class="table">
    <thead><tr><th>ID</th><th>Jenis</th><th>Nominal</th><th>Status</th><th>Tanggal</th></tr></thead>
    <tbody>
      @foreach($nas->rekening->transaksi as $trx)
      <tr>
        <td>{{ $trx->id }}</td>
        <td>{{ $trx->jenis }}</td>
        <td>{{ number_format($trx->nominal) }}</td>
        <td>{{ $trx->status }}</td>
        <td>{{ $trx->created_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
