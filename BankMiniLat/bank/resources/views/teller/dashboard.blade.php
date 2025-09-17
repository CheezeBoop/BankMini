@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Teller Dashboard</h3>
  <h5>Pending Transactions</h5>
  <table class="table">
    <thead><tr><th>ID</th><th>Rekening</th><th>Jenis</th><th>Nominal</th><th>Aksi</th></tr></thead>
    <tbody>
      @foreach($pending as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->rekening->no_rekening }}</td>
        <td>{{ $p->jenis }}</td>
        <td>{{ number_format($p->nominal) }}</td>
        <td>
          <form method="POST" action="{{ route('teller.transaksi.confirm',$p->id) }}">
            @csrf
            <button class="btn btn-primary btn-sm">Confirm</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
