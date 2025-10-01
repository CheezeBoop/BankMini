@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="modern-card">
    <div class="modern-card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Teller</h5>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="modern-card-body">
      <form class="row g-3" method="POST" action="{{ route('admin.teller.update', $teller->id) }}">
        @csrf @method('PUT')

        <div class="col-12 col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" value="{{ old('name',$teller->name) }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email',$teller->email) }}" required>
          @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Kalau kamu punya kolom status di users, aktifkan blok ini --}}
        {{-- 
        <div class="col-12 col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="active" {{ old('status',$teller->status ?? 'active')==='active'?'selected':'' }}>Aktif</option>
            <option value="suspended" {{ old('status',$teller->status ?? '')==='suspended'?'selected':'' }}>Suspended</option>
          </select>
          @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        --}}

        <div class="col-12 col-md-6">
          <label class="form-label">Password Baru (opsional)</label>
          <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
          @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12">
          <button class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
