@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-4">📊 Teller Dashboard</h3>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Tombol Buat Nasabah Baru --}}
  <div class="mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buatNasabahModal">
      + Buat Nasabah Baru
    </button>
  </div>

{{-- Search --}}
<div class="card mb-3 shadow-sm">
  <div class="card-body">
    <form method="GET" action="{{ route('teller.dashboard') }}" class="d-flex">
      <input type="text" name="search" class="form-control me-2" 
             placeholder="Cari berdasarkan Nama / NIS / No Rekening"
             value="{{ request('search') }}">
      <button class="btn btn-outline-primary" type="submit">Cari</button>
    </form>
  </div>
</div>


  {{-- Daftar Nasabah --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="mb-0">👥 Daftar Nasabah</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered mb-0 align-middle">
          <thead class="table-secondary">
            <tr>
              <th>No Rekening</th>
              <th>Nama</th>
              <th>Saldo</th>
              <th>Tanggal Buka</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($nasabahs as $n)
              <tr>
                <td>{{ $n->no_rekening }}</td>
                <td>{{ $n->nasabah->nama ?? '-' }}</td>
                <td>Rp {{ number_format($n->saldo, 0, ',', '.') }}</td>
                <td>{{ $n->tanggal_buka ? \Carbon\Carbon::parse($n->tanggal_buka)->format('d M Y') : '-' }}</td>
                <td>
                  {{-- Form setor --}}
                  <form method="POST" action="{{ route('teller.setor',$n->id) }}" class="d-inline">
                    @csrf
                    <div class="input-group input-group-sm mb-1" style="max-width: 250px;">
                      <input type="number" name="nominal" placeholder="Nominal" required class="form-control">
                      <button class="btn btn-success">Setor</button>
                    </div>
                  </form>

                  {{-- Form tarik --}}
                  <form method="POST" action="{{ route('teller.tarik',$n->id) }}" class="d-inline">
                    @csrf
                    <div class="input-group input-group-sm mb-1" style="max-width: 250px;">
                      <input type="number" name="nominal" placeholder="Nominal" required class="form-control">
                      <button class="btn btn-danger">Tarik</button>
                    </div>
                  </form>

                  {{-- Tombol edit --}}
                  <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNasabahModal{{ $n->id }}">
                    Edit
                  </button>
                </td>
              </tr>

              {{-- Modal Edit Nasabah --}}
              <div class="modal fade" id="editNasabahModal{{ $n->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="POST" action="{{ route('teller.nasabah.update', $n->id) }}">
                      @csrf
                      @method('PUT')
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Profil Nasabah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
  <label>NIS/NIP</label>
  <input type="text" name="nis_nip" class="form-control" value="{{ $n->nasabah->nis_nip ?? '' }}">
</div>
<div class="mb-3">
  <label>Status</label>
  <select name="status" class="form-control">
    <option value="AKTIF" @if($n->nasabah->status == 'AKTIF') selected @endif>AKTIF</option>
    <option value="NONAKTIF" @if($n->nasabah->status == 'NONAKTIF') selected @endif>NONAKTIF</option>
  </select>
</div>
                        <div class="mb-3">
                          <label>Nama</label>
                          <input type="text" name="nama" class="form-control" value="{{ $n->nasabah->nama ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="{{ $n->nasabah->email ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                          <label>No HP</label>
                          <input type="text" name="no_hp" class="form-control" value="{{ $n->nasabah->no_hp ?? '' }}">
                        </div>
                        <div class="mb-3">
                          <label>Alamat</label>
                          <textarea name="alamat" class="form-control">{{ $n->nasabah->alamat ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                          <label>Jenis Kelamin</label>
                          <select name="jenis_kelamin" class="form-control">
                            <option value="L" @if($n->nasabah->jenis_kelamin == 'L') selected @endif>Laki-laki</option>
                            <option value="P" @if($n->nasabah->jenis_kelamin == 'P') selected @endif>Perempuan</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada nasabah</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- ⬇️ Tambahin ini persis setelah tabel --}}
<div class="mt-3 px-3">
  {{ $nasabahs->links('pagination::bootstrap-5') }}
</div>
    </div>
  </div>

  {{-- Pending Transaksi --}}
  <div class="card shadow-sm">
    <div class="card-header bg-light">
      <h5 class="mb-0">⏳ Pending Transactions</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0 align-middle">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>No Rekening</th>
              <th>Jenis</th>
              <th>Nominal</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pending as $p)
              <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->rekening->no_rekening }}</td>
                <td>
                  @if($p->jenis === 'SETOR')
                    <span class="badge bg-success">SETOR</span>
                  @else
                    <span class="badge bg-danger">TARIK</span>
                  @endif
                </td>
                <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                <td>
                  <form method="POST" action="{{ route('teller.transaksi.confirm',$p->id) }}">
                    @csrf
                    <button class="btn btn-primary btn-sm">Confirm</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi pending</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Buat Nasabah Baru --}}
<div class="modal fade" id="buatNasabahModal" tabindex="-1" aria-labelledby="buatNasabahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('teller.nasabah.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="buatNasabahModalLabel">Buat Nasabah Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Saldo Awal</label>
            <input type="number" name="saldo" class="form-control" value="0" required>
          </div>
          <div class="mb-3">
            <label>NIS/NIP</label>
            <input type="text" name="nis_nip" class="form-control">
          </div>
          <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control">
          </div>
          <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control">
              <option value="">-- pilih --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
