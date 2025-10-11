<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
        'user_id',
        'nis_nip',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'email',
        'status',
    ];

    public function rekening()
    {
        return $this->hasOne(Rekening::class, 'nasabah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
