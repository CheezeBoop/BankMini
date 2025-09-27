<div class="table-responsive">
  <table class="table table-bordered table-striped mb-0">
    <thead class="table-light">
      <tr>
        <th>Waktu</th>
        <th>User</th>
        <th>Aksi</th>
        <th>Entitas</th>
        <th>IP</th>
        <th>Detail</th>
      </tr>
    </thead>
    <tbody>
      @forelse($logs as $log)
        <tr>
          <td>{{ $log->created_at->format('d M Y H:i') }}</td>
          <td>{{ $log->user->name ?? '-' }}</td>
          <td>{{ $log->aksi }}</td>
          <td>{{ $log->entitas }} #{{ $log->entitas_id }}</td>
          <td>{{ $log->ip_addr ?? '-' }}</td>
          <td>
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#logDetail{{ $log->id }}">
              Detail
            </button>
          </td>
        </tr>

        {{-- Modal Detail --}}
        <div class="modal fade" id="logDetail{{ $log->id }}" tabindex="-1" aria-labelledby="logDetailLabel{{ $log->id }}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="logDetailLabel{{ $log->id }}">Detail Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>User:</strong> {{ $log->user->name ?? '-' }} (ID: {{ $log->user_id }})</p>
                <p><strong>Aksi:</strong> {{ $log->aksi }}</p>
                <p><strong>Entitas:</strong> {{ $log->entitas }} #{{ $log->entitas_id }}</p>
                <p><strong>IP Address:</strong> {{ $log->ip_addr ?? '-' }}</p>
                <p><strong>Waktu:</strong> {{ $log->created_at->format('d M Y H:i:s') }}</p>

                @if($log->entitas === 'transaksi')
                  @php
                    $trx = \App\Models\Transaksi::find($log->entitas_id);
                  @endphp
                  @if($trx)
                    <hr>
                    <h6>Detail Transaksi</h6>
                    <p><strong>Jenis:</strong> {{ $trx->jenis }}</p>
                    <p><strong>Nominal:</strong> Rp {{ number_format($trx->nominal) }}</p>
                    <p><strong>Status:</strong> {{ $trx->status }}</p>
                    <p><strong>Saldo Setelah:</strong> {{ $trx->saldo_setelah ?? '-' }}</p>
                    <p><strong>Keterangan:</strong> {{ $trx->keterangan ?? '-' }}</p>
                  @endif
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <tr>
          <td colspan="6" class="text-center">Belum ada data log</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Pagination --}}
<div class="mt-3">
  {{ $logs->links() }}
</div>
