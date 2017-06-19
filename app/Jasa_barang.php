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

    public function getOngkosAttribute($value)
    {
        return ($value == 0) ? null : number_format($value);
    }

    public function getKlaimAttribute($value)
    {
        return ($value == 0) ? null : number_format($value);
    }
    
    public function getOpenAttribute($value)
    {
        return ($value == 0) ? null : number_format($value);
    }

    public static function rules($rules = [])
    {
    	return array_merge([
    		'id_jasa' => 'exists:jasa,id',
    		'id_barang' => 'exists:barang,id'
		], $rules);
    }

}
