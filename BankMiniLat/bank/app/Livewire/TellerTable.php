<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class TellerTable extends Component
{
    use WithPagination;

    // Livewire v3: supaya pagination view pakai Bootstrap
    public string $paginationTheme = 'bootstrap';

    public function render()
    {
        $tellers = User::whereHas('role', fn ($q) => $q->where('name', 'teller'))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.teller-table', [
            'tellers' => $tellers,
        ]);
    }
}
