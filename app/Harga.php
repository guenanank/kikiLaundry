<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harga extends Model
{
    use SoftDeletes;

    protected $table = 'harga';
    protected $fillable = ['id_pelanggan', 'id_barang', 'id_jasa', 'tunai', 'cicil'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'id_pelanggan' => 'required|int|max:999|exists:pelanggan,id',
    		'id_barang' => 'required|int|max:999|exists:barang,id',
    		'id_jasa' => 'required|int|max:999|exists:jasa,id',
            'tunai' => 'numeric|nullable',
            'cicil' => 'numeric|nullable'
		], $rules);
    }

    public function barang()
    {
        return $this->hasOne('kikiLaundry\Barang', 'id', 'id_barang');
    }

    public function jasa()
    {
        return $this->hasOne('kikiLaundry\Jasa', 'id', 'id_jasa');
    }

}
