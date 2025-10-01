<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class TellerTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $tellers = User::whereHas('role', function ($q) {
            $q->where('name', 'teller');
        })->paginate(5);

        return view('livewire.teller-table', compact('tellers'));
    }
}
