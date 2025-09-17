<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {
  protected $table = 'transaksi';
  protected $fillable = ['rekening_id','user_id','jenis','nominal','keterangan','saldo_setelah','status','admin_approved'];
  public function rekening(){ return $this->belongsTo(Rekening::class); }
  public function user(){ return $this->belongsTo(\App\Models\User::class); }
}
