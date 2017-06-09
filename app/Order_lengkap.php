<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_lengkap extends Model
{
    use SoftDeletes;

    protected $table = 'order_lengkap';
    protected $fillable = ['id_order', 'id_barang', 'id_jasa', 'banyaknya', 'harga_tunai', 'harga_cicil', 'jumlah_harga_tunai', 'jumlah_harga_cicil'];
    protected $dates = ['deleted_at'];

    public function getHargaTunaiAttribute($value)
    {
        return number_format($value);
    }

    public function getHargaCicilAttribute($value)
    {
        return number_format($value);
    }

    public function getJumlahHargaTunaiAttribute($value)
    {
        return number_format($value);
    }

    public function getJumlahHargaCicilAttribute($value)
    {
        return number_format($value);
    }

    public function rules($rules = [])
    {
    	return array_merge([
    		'id_order' => 'required|int|exists:order,id',
    		'id_barang' => 'required|int|exists:barang,id',
    		'id_jasa' => 'required|int|exists:jasa,id',
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

    public function jasa()
    {
        return $this->hasOne('kikiLaundry\Jasa', 'id', 'id_jasa');   
    }
}
