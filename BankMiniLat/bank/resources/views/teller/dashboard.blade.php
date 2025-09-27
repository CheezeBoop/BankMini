@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Teller Dashboard</h3>

  {{-- Notifikasi sukses/error --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Daftar Nasabah --}}
  <h5>Daftar Nasabah</h5>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No Rekening</th>
        <th>Nama</th>
        <th>Saldo</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($nasabahs as $n)
      <tr>
        <td>{{ $n->no_rekening }}</td>
        <td>{{ $n->user->name }}</td>
        <td>{{ number_format($n->saldo) }}</td>
        <td>
          {{-- Form setor --}}
          <form method="POST" action="{{ route('teller.setor',$n->id) }}" class="d-inline">
            @csrf
            <input type="number" name="nominal" placeholder="Nominal" required class="form-control form-control-sm d-inline w-50">
            <button class="btn btn-success btn-sm">Setor</button>
          </form>

          {{-- Form tarik --}}
          <form method="POST" action="{{ route('teller.tarik',$n->id) }}" class="d-inline">
            @csrf
            <input type="number" name="nominal" placeholder="Nominal" required class="form-control form-control-sm d-inline w-50">
            <button class="btn btn-danger btn-sm">Tarik</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Pending Transaksi --}}
  <h5>Pending Transactions</h5>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>No Rekening</th>
        <th>Jenis</th>
        <th>Nominal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pending as $p)
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
      @empty
      <tr>
        <td colspan="5" class="text-center">Tidak ada transaksi pending</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
