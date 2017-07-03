<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harga extends Model
{
    use SoftDeletes;

    protected $table = 'harga';
    protected $fillable = ['id_pelanggan', 'id_barang', 'id_cuci', 'tunai', 'cicil'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return collect([
    		'id_pelanggan' => 'required|int|max:999|exists:pelanggan,id',
    		'id_barang' => 'required|int|max:999|exists:barang,id',
    		'id_cuci' => 'required|int|max:999|exists:cuci,id',
            'tunai' => 'nullable',
            'cicil' => 'nullable'
		])->merge($rules);
    }

    public function pelanggan()
    {
        return $this->hasOne('kikiLaundry\Pelanggan', 'id', 'id_pelanggan');
    }

    public function barang()
    {
        return $this->hasOne('kikiLaundry\Barang', 'id', 'id_barang');
    }

    public function cuci()
    {
        return $this->hasOne('kikiLaundry\Cuci', 'id', 'id_cuci');
    }

    public function setTunaiAttribute($value)
    {
        $this->attributes['tunai'] = str_replace(',', null, $value);
    }

    public function setCicilAttribute($value)
    {
        $this->attributes['cicil'] = str_replace(',', null, $value);
    }

}
