<div class="table-scroll-container">
  <table class="table table-modern mb-0">
    <thead>
      <tr>
        <th>Teller</th>
        <th>Email</th>
        <th>Terdaftar</th>
        <th>Status</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tellers as $t)
        <tr class="table-row-hover teller-row">
          <td>
            <div class="user-info">
              <div class="avatar-gradient">
                {{ strtoupper(substr($t->name, 0, 2)) }}
              </div>
              <div class="user-details">
                <div class="user-name">{{ $t->name }}</div>
                <div class="user-id">ID: #{{ $t->id }}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="email-wrapper">
              <i class="bi bi-envelope-fill text-muted me-2"></i>
              <span>{{ $t->email }}</span>
            </div>
          </td>
          <td>
            <div class="date-badge">
              <i class="bi bi-calendar3 me-1"></i>
              {{ $t->created_at->format('d M Y') }}
              <span class="time-badge">{{ $t->created_at->format('H:i') }}</span>
            </div>
          </td>
          <td>
            <span class="status-badge status-active">
              <i class="bi bi-check-circle-fill"></i> Aktif
            </span>
          </td>
          <td class="text-center">
            <div class="action-buttons">
              <button class="btn-action btn-action-view" title="Lihat Detail">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn-action btn-action-edit" title="Edit">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn-action btn-action-delete" title="Hapus">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if ($tellers->hasPages())
    <div class="modern-card-footer">
      <div class="pagination-wrapper">
        <div class="pagination-info">
          Menampilkan {{ $tellers->firstItem() }} - {{ $tellers->lastItem() }} dari {{ $tellers->total() }} teller
        </div>
        <div class="pagination-modern">
          {{ $tellers->links() }}
        </div>
      </div>
    </div>
  @endif
</div>
