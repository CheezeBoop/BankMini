<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model {
  protected $table = 'nasabah';
  protected $fillable = ['nis_nip','nama','jenis_kelamin','alamat','no_hp','email','status'];
  public function rekening(){ return $this->hasOne(Rekening::class); }
}
