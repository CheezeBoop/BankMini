<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-6">
                <h6 class="text-muted">ID Transaksi</h6>
                <p class="fw-bold">#TXN{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Tanggal</h6>
                <p class="fw-bold">{{ $transaction->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-md-6">
                <h6 class="text-muted">No Rekening</h6>
                <p class="fw-bold">{{ $transaction->rekening->no_rekening }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Nama Nasabah</h6>
                <p class="fw-bold">{{ $transaction->rekening->nasabah->nama }}</p>
            </div>
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-md-6">
                <h6 class="text-muted">Jenis Transaksi</h6>
                <span class="badge {{ $transaction->jenis == 'SETOR' ? 'bg-success' : 'bg-danger' }}">
                    {{ $transaction->jenis }}
                </span>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Nominal</h6>
                <p class="fw-bold">Rp {{ number_format($transaction->nominal, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($transaction->keterangan)
        <hr>
        <div class="row">
            <div class="col-12">
                <h6 class="text-muted">Keterangan</h6>
                <p>{{ $transaction->keterangan }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
