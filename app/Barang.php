<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';
    protected $fillable = ['nama'];
    protected $dates = ['deleted_at'];

    public static function rules(array $rules = [])
    {
        return collect([
        'nama' => 'required|string|max:127|unique:barang,nama'
      ])->merge($rules);
    }

    public function jasa()
    {
        return $this->belongsToMany('kikiLaundry\Jasa', 'jasa_barang', 'id_barang', 'id_jasa')
        ->withPivot('id_jasa', 'id_barang', 'ongkos', 'klaim', 'open');
    }
}
