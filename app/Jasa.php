<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa extends Model
{
    use SoftDeletes;

    protected $table = 'jasa';
    protected $fillable = ['nama', 'nama_kunci', 'tergantung_barang','ongkos', 'klaim'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127|unique:jasa,nama',
            'tergantung_barang' => 'boolean'
		], $rules);
    }

    public function getOngkosAttribute($value)
    {
        return number_format($value);
    }

    public function getKlaimAttribute($value)
    {
        return number_format($value);
    }
    

    public function jasa_barang()
    {
        return $this->hasMany('kikiLaundry\Jasa_barang', 'id_jasa', 'id');
    }
}
