@extends('nasabah.layout')

@section('nasabah_content')
<div class="card shadow-sm border-0">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0"><i class="bi bi-person-badge me-2 text-success"></i> Profil Saya</h4>
      @if($nasabah->status === 'AKTIF')
        <span class="badge bg-success">AKTIF</span>
      @else
        <span class="badge bg-secondary">{{ $nasabah->status }}</span>
      @endif
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="list-group list-group-flush">
          <div class="list-group-item px-0">
            <small class="text-muted d-block">Nama</small>
            <div class="fw-semibold">{{ $nasabah->nama }}</div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">Email</small>
            <div class="fw-semibold">{{ $nasabah->email }}</div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">No. HP</small>
            <div class="fw-semibold">{{ $nasabah->no_hp ?? '-' }}</div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">Alamat</small>
            <div class="fw-semibold">{{ $nasabah->alamat ?? '-' }}</div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="list-group list-group-flush">
          <div class="list-group-item px-0">
            <small class="text-muted d-block">NIS/NIP</small>
            <div class="fw-semibold">{{ $nasabah->nis_nip ?? '-' }}</div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">Jenis Kelamin</small>
            <div class="fw-semibold">
              @if($nasabah->jenis_kelamin === 'L') Laki-laki
              @elseif($nasabah->jenis_kelamin === 'P') Perempuan
              @else - @endif
            </div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">No. Rekening</small>
            <div class="fw-semibold">{{ $nasabah->rekening->no_rekening ?? '-' }}</div>
          </div>
          <div class="list-group-item px-0">
            <small class="text-muted d-block">Saldo Saat Ini</small>
            <div class="fw-bold text-success">
              @php
                $saldo = optional($nasabah->rekening)->saldo ?? 0;
              @endphp
              Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Info pembuka rekening --}}
    @if(optional($nasabah->rekening)->tanggal_buka)
      <div class="mt-4">
        <small class="text-muted">Tanggal Buka Rekening</small>
        <div class="fw-semibold">
          {{ \Carbon\Carbon::parse($nasabah->rekening->tanggal_buka)->format('d M Y') }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
