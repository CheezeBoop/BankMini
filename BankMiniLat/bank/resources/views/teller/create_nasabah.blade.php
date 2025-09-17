@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Buat Nasabah</h3>
  <form method="POST" action="{{ route('teller.nasabah.store') }}">
    @csrf
    <input name="nama" placeholder="Nama" class="form-control mb-2" required>
    <input name="nis_nip" placeholder="NIS/NIP" class="form-control mb-2">
    <input name="no_hp" placeholder="No HP" class="form-control mb-2">
    <textarea name="alamat" class="form-control mb-2" placeholder="Alamat"></textarea>
    <button class="btn btn-success">Buat Nasabah</button>
  </form>
</div>
@endsection
