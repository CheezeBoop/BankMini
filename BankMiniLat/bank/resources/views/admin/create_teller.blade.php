@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Buat Teller Baru</h3>
  <form method="POST" action="{{ route('admin.teller.store') }}">
    @csrf
    <input name="name" placeholder="Name" class="form-control mb-2" required>
    <input name="email" placeholder="Email" class="form-control mb-2" required>
    <input name="password" placeholder="Password" type="password" class="form-control mb-2" required>
    <button class="btn btn-success">Simpan</button>
  </form>
</div>
@endsection
