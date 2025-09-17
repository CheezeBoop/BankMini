<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aksi',
        'entitas',
        'entitas_id',
        'ip_addr'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
