<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
    'user_id','nis_nip','nama','jenis_kelamin','alamat','no_hp','email','status',
    'photo_path','photo_thumb_path',
    ];


    public function getPhotoUrlAttribute(): ?string {
        return $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null;
    }

    public function getPhotoThumbUrlAttribute(): ?string {
        return $this->photo_thumb_path
            ? Storage::disk('public')->url($this->photo_thumb_path)
            : ($this->photo_url ?: null);
    }

    public function rekening()
    {
        return $this->hasOne(Rekening::class, 'nasabah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
