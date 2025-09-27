@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Buat Teller Baru</h3>

  {{-- Notifikasi sukses --}}
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  {{-- Notifikasi error --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.teller.store') }}">
    @csrf
    <input name="name" value="{{ old('name') }}" placeholder="Name" class="form-control mb-2" required>
    <input name="email" value="{{ old('email') }}" placeholder="Email" class="form-control mb-2" required>
    <input name="password" placeholder="Password" type="password" class="form-control mb-2" required>
    <button class="btn btn-success">Simpan</button>
  </form>
</div>
@endsection
