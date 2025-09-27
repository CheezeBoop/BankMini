<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';

    protected $fillable = [
        'nasabah_id',
        'no_rekening',
        'tanggal_buka',
        'status',
        'saldo',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'rekening_id');
    }
}
