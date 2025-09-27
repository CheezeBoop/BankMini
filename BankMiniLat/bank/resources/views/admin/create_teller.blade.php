@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-3">Buat Teller Baru</h3>

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

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.teller.store') }}">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input id="name" name="name" value="{{ old('name') }}" 
                 type="text" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" name="email" value="{{ old('email') }}" 
                 type="email" class="form-control @error('email') is-invalid @enderror" required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" name="password" type="password" 
                 class="form-control @error('password') is-invalid @enderror" required>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
