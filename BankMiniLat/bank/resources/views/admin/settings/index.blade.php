@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <h3 class="mb-4">Pengaturan Limit Transaksi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Minimal Setor</label>
            <input type="number" name="minimal_setor" class="form-control"
                value="{{ old('minimal_setor', $setting->minimal_setor) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Maksimal Setor</label>
            <input type="number" name="maksimal_setor" class="form-control"
                value="{{ old('maksimal_setor', $setting->maksimal_setor) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Minimal Tarik</label>
            <input type="number" name="minimal_tarik" class="form-control"
                value="{{ old('minimal_tarik', $setting->minimal_tarik) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Maksimal Tarik</label>
            <input type="number" name="maksimal_tarik" class="form-control"
                value="{{ old('maksimal_tarik', $setting->maksimal_tarik) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Simpan Pengaturan
        </button>
    </form>
</div>
@endsection
