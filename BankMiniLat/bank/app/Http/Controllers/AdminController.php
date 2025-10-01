<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use App\Models\Transaksi;
use App\Models\Rekening;
use App\Models\Nasabah;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard(Request $request)
    {
        // Tellers dengan paginate
        $tellers = User::whereHas('role', fn($q) => $q->where('name', 'teller'))
                        ->paginate(10);

        // Statistik
        $totalTeller = User::whereHas('role', fn($q) => $q->where('name', 'teller'))->count();
        $totalNasabah = Nasabah::count();
        $totalSaldo = Rekening::sum('saldo');
        $transaksiHariIni = Transaksi::whereDate('created_at', now())->count();
        $pendingCount = Transaksi::where('status', 'PENDING')->count();

        // Logs per tipe
        $logAkun = AuditLog::with('user')
                    ->whereIn('aksi', [
                        'create_teller','update_teller','delete_teller',
                        'create_nasabah','update_nasabah','delete_nasabah'
                    ])
                    ->latest()
                    ->paginate(10);

        $logSetor  = AuditLog::with('user')
                        ->where('aksi','setor')
                        ->latest()->paginate(10);

        $logTarik  = AuditLog::with('user')
                        ->where('aksi','tarik')
                        ->latest()->paginate(10);

        // Merge semua logs menjadi 1 collection & sort desc
        $allLogs = collect($logAkun->items())
                    ->merge($logSetor->items())
                    ->merge($logTarik->items())
                    ->sortByDesc('created_at');

        // Manual pagination untuk merged logs
        $page = $request->get('page', 1);
        $perPage = 10;
        $logs = new \Illuminate\Pagination\LengthAwarePaginator(
            $allLogs->forPage($page, $perPage),
            $allLogs->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.dashboard', compact(
            'tellers',
            'totalTeller',
            'totalNasabah',
            'totalSaldo',
            'transaksiHariIni',
            'pendingCount',
            'logAkun',
            'logSetor',
            'logTarik',
            'logs'
        ));
    }

    public function createTellerForm()
    {
        return view('admin.create_teller');
    }

    public function storeTeller(Request $r)
    {
        $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::firstOrCreate(['name' => 'teller']);

        $teller = User::create([
            'name'     => $r->name,
            'email'    => $r->email,
            'password' => bcrypt($r->password),
            'role_id'  => $role->id,
        ]);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'create_teller',
            'entitas'    => 'users',
            'entitas_id' => $teller->id,
            'ip_addr'    => $r->ip(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Teller berhasil dibuat.');
    }

    public function removeTeller($id)
    {
        $teller = User::findOrFail($id);
        $teller->delete();

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'delete_teller',
            'entitas'    => 'users',
            'entitas_id' => $id,
            'ip_addr'    => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Teller berhasil dihapus.');
    }

    public function approveTransaction(Request $r, $id)
    {
        DB::transaction(function () use ($r, $id) {
            $trx = Transaksi::with('rekening')->lockForUpdate()->findOrFail($id);
            $rek = $trx->rekening;

            if ($trx->status !== 'PENDING') throw new \Exception('Transaksi sudah diproses.');
            if ($trx->jenis === 'TARIK' && $rek->saldo < $trx->nominal)
                throw new \Exception('Saldo tidak cukup untuk penarikan.');

            $rek->saldo += ($trx->jenis === 'SETOR') ? $trx->nominal : -$trx->nominal;
            $rek->save();

            $trx->update([
                'admin_approved' => true,
                'status'         => 'CONFIRMED',
                'saldo_setelah'  => $rek->saldo,
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'approve_transaksi',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil di-approve.');
    }

    public function editTeller($id)
{
    // pastikan user dengan role teller
    $teller = User::with('role')->findOrFail($id);
    abort_unless(optional($teller->role)->name === 'teller', 404);

    return view('admin.edit', compact('teller'));
}

public function updateTeller(Request $r, $id)
{
    $teller = User::with('role')->findOrFail($id);
    abort_unless(optional($teller->role)->name === 'teller', 404);

    $data = $r->validate([
        'name'     => ['required','string','max:100'],
        'email'    => ['required','email','max:150', Rule::unique('users','email')->ignore($teller->id)],
        // kalau kamu punya kolom status di table users (active/suspended), aktifkan baris ini:
        // 'status'   => ['required', Rule::in(['active','suspended'])],
        'password' => ['nullable','string','min:8'], // opsional
    ]);

    if (filled($data['password'] ?? null)) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    // kalau kamu pakai kolom status di users dan route-menunjukkan input status, pastikan fieldnya ada:
    // if (!array_key_exists('status', $data)) { $data['status'] = $teller->status ?? 'active'; }

    $teller->update($data);

    // Audit
    AuditLog::create([
        'user_id'    => Auth::id(),
        'aksi'       => 'update_teller',
        'entitas'    => 'users',
        'entitas_id' => (int)$teller->id,
        'ip_addr'    => $r->ip(),
    ]);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Teller berhasil diperbarui.');
}

public function exportLogs(Request $request): StreamedResponse
{
    // <- opsional: validasi ringan parameter
    $request->validate([
        'teller'     => ['nullable','integer','exists:users,id'],
        'type'       => ['nullable','string','max:100'],      // contoh: 'update_teller', 'setor' dll
        'date_from'  => ['nullable','date'],
        'date_to'    => ['nullable','date'],
    ]);

    $tz = config('app.timezone', 'Asia/Jakarta');
    $stamp = now()->setTimezone($tz)->format('Ymd_His');
    $filename = "audit_logs_{$stamp}.csv";

    $callback = function () use ($request) {
        $out = fopen('php://output', 'w');

        // Header CSV
        fputcsv($out, [
            'ID', 'WAKTU', 'USER_ID', 'USER_NAME', 'AKSI', 'ENTITAS', 'ENTITAS_ID', 'IP_ADDRESS'
        ]);

        // Query efisien (cursor = stream, hemat RAM)
        $query = AuditLog::with(['user:id,name'])
            ->when($request->filled('teller'), fn($q) => $q->where('user_id', $request->integer('teller')))
            ->when($request->filled('type'),   fn($q) => $q->where('aksi', $request->string('type')))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'),   fn($q) => $q->whereDate('created_at', '<=', $request->date('date_to')))
            ->orderByDesc('created_at')
            ->select(['id','user_id','aksi','entitas','entitas_id','ip_addr','created_at']);

        foreach ($query->cursor() as $log) {
            fputcsv($out, [
                $log->id,
                // Format waktu lokal biar enak dibaca di sheet
                $log->created_at?->timezone(config('app.timezone', 'Asia/Jakarta'))?->format('Y-m-d H:i:s'),
                $log->user_id,
                optional($log->user)->name,
                $log->aksi,
                $log->entitas,
                $log->entitas_id,
                $log->ip_addr,
            ]);
        }

        fclose($out);
    };

    return response()->streamDownload($callback, $filename, [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Cache-Control'       => 'no-store, no-cache, must-revalidate',
        'Pragma'              => 'no-cache',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ]);
}
}