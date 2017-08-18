<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa_barang extends Model
{
    use SoftDeletes;

    protected $table = 'jasa_barang';
    protected $fillable = ['id_jasa', 'id_barang', 'ongkos', 'klaim', 'open'];
    protected $dates = ['deleted_at'];

    public static function rules(array $rules = [])
    {
        return collect([
        'id_jasa' => 'exists:jasa,id',
        'id_barang' => 'exists:barang,id'
      ])->merge($rules);
    }

    public function jasa()
    {
        return $this->hasOne('kikiLaundry\Jasa', 'id', 'id_jasa');
    }
}
