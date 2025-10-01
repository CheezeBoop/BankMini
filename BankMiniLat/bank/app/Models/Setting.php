<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'minimal_setor',
        'maksimal_setor',
        'minimal_tarik',
        'maksimal_tarik',
    ];
}
