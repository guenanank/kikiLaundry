<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasukan extends Model
{
    use SoftDeletes;

    protected $table = 'pemasukan';
    protected $fillable = ['jenis', 'id_pelanggan','tanggal', 'jumlah', 'cara_bayar', 'catatan'];
    protected $dates = ['deleted_at'];

    public static function jenis($jenis = null)
    {
    	$jns = [
    		'penambahanBiaya' => 'Penambahan Biaya',
    		'cicilanPelanggan' => 'Cicilan Pelanggan',
    		'pembayaranPelanggan' => 'Pembayaran Pelanggan'
    	];
    	return is_null($jenis) ? $jns : $jns[$jenis];
    }

    public static function cara_bayar($bayar = null)
    {
    	$cara_bayar = [
    		null => null,
    		'tunai' => 'Tunai',
    		'giro' => 'Giro',
    		'cek' => 'Cek',
    		'transfer' => 'Transfer Bank'
    	];
    	return is_null($bayar) ? $cara_bayar : $cara_bayar[$bayar];
    }

    public static function rules($rules = [])
    {
    	return array_merge($rules, [
    		'jenis' => 'required|string|max:31',
    		'id_pelanggan' => 'nullable|exists:pelanggan,id',
    		'tanggal' => 'required|date:Y-md',
    		'jumlah' => 'required|numeric',
    		'cara_bayar' => 'string|max:15|nullable',
    		'catatan' => 'string|nullable'
		]);
    }

    public function pelanggan()
    {
    	return $this->hasOne('kikiLaundry\pelanggan', 'id', 'id_pelanggan');
    }


}
