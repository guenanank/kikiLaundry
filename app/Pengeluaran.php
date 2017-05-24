<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;

    protected $table = 'pengeluaran';
    protected $fillable = ['tanggal', 'jenis', 'jumlah', 'keterangan'];
    protected $dates = ['deleted_at'];

    public static function jenis($jenis = null)
    {
    	$jns = [
    		'hari' => 'Harian', 
    		'minggu' => 'Mingguan', 
    		'bulan' => 'Bulanan'
    	];

    	return is_null($jenis) ? $jns : $jns[$jenis];
    }

    public static function rules($rules = [])
    {
    	return array_merge([
    		'tanggal' => 'required|date:Y-m-d',
    		'jenis' => 'required|string|max:7',
    		'jumlah' => 'required|numeric',
    		'keterangan' => 'string|nullable'
		], $rules);
    }

}
