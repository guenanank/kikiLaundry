<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa extends Model
{
  use SoftDeletes;

  protected $table = 'jasa';
  protected $fillable = ['nama', 'nama_kunci', 'tergantung_barang','ongkos', 'klaim', 'open'];
  protected $dates = ['deleted_at'];

  public static function rules($rules = [])
  {
    return collect([
      'nama' => 'required|string|max:127|unique:jasa,nama',
      'tergantung_barang' => 'boolean'
    ])->merge($rules);
  }

  public function setNamaAttribute($value)
  {
    $this->attributes['nama'] = $value;
    $this->attributes['nama_kunci'] = kebab_case($value);
  }

  public function cuci()
  {
    return $this->belongsToMany('kikiLaundry\Cuci', 'cuci_jasa', 'id_jasa', 'id_cuci')
      ->wherePivot('deleted_at');
  }

  public function barang()
  {
    return $this->belongsToMany('kikiLaundry\Barang', 'jasa_barang', 'id_jasa', 'id_barang')
      ->withPivot('id_jasa', 'id_barang', 'ongkos', 'klaim', 'open');
  }

  public function jasa_barang()
  {
    return $this->hasMany('kikiLaundry\Jasa_barang', 'id_jasa', 'id');
  }
}
