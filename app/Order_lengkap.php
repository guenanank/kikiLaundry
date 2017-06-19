<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_lengkap extends Model
{
    use SoftDeletes;

    protected $table = 'order_lengkap';
    protected $fillable = ['id_order', 'id_barang', 'id_cuci', 'banyaknya', 'harga_tunai', 'harga_cicil', 'jumlah_harga_tunai', 'jumlah_harga_cicil'];
    protected $dates = ['deleted_at'];

    public function rules($rules = [])
    {
    	return array_merge([
    		'id_order' => 'required|int|exists:order,id',
    		'id_barang' => 'required|int|exists:barang,id',
    		'id_cuci' => 'required|int|exists:cuci,id',
    		'banyaknya' => 'required|numeric',
    		'harga_tunai' => 'required|numeric',
    		'harga_cicil' => 'required|numeric',
    		'jumlah_harga_tunai' => 'required|numeric',
    		'jumlah_harga_cicil' => 'required|numeric'
		], $rules);
    }

    public function barang()
    {
        return $this->hasOne('kikiLaundry\Barang', 'id', 'id_barang');
    }

    public function cuci()
    {
        return $this->hasOne('kikiLaundry\Cuci', 'id', 'id_cuci');   
    }
}
