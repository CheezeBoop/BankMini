@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-3">Buat Nasabah Baru</h3>

  {{-- Notifikasi sukses/error --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('teller.nasabah.store') }}">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" name="name" id="name" 
                 value="{{ old('name') }}" 
                 class="form-control @error('name') is-invalid @enderror" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" 
                 value="{{ old('email') }}" 
                 class="form-control @error('email') is-invalid @enderror" required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" 
                 class="form-control @error('password') is-invalid @enderror" required>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="saldo" class="form-label">Saldo Awal</label>
          <input type="number" name="saldo" id="saldo" 
                 value="{{ old('saldo', 0) }}" 
                 class="form-control @error('saldo') is-invalid @enderror" required>
          @error('saldo')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="nis_nip" class="form-label">NIS/NIP</label>
          <input type="text" name="nis_nip" id="nis_nip" 
                 value="{{ old('nis_nip') }}" class="form-control">
        </div>

        <div class="mb-3">
          <label for="no_hp" class="form-label">No HP</label>
          <input type="text" name="no_hp" id="no_hp" 
                 value="{{ old('no_hp') }}" class="form-control">
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
            <option value="">-- pilih --</option>
            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
