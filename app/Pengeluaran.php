<?php

namespace kikiLaundry;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;

    protected $table = 'pengeluaran';
    protected $fillable = ['tanggal', 'nomer', 'jenis', 'jumlah', 'keterangan'];
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

    public static function pengeluaran_bulanan($pb = null)
    {
    	$pengeluaran_bulanan = [
    		'listrik' => 'Listrik', 
    		'kimia' => 'Kimia', 
    		'bahanBakar' => 'Bahan Bakar'
    	];
    	return is_null($pb) ? $pengeluaran_bulanan : $pengeluaran_bulanan[$pb];
    }

    public static function rules($rules = [])
    {
    	return array_merge($rules, [
    		'tanggal' => 'required|date:Y-m-d',
            'nomer' => 'required|string|max:31',
    		'jenis' => 'required|string|max:7',
    		'jumlah' => 'required|numeric',
    		'keterangan' => 'string|nullable'
		]);
    }

    public static function nomer_urut()
    {
        $terakhir = Pengeluaran::select('nomer')->where([
            [DB::raw("substring('nomer', 4, 4)"), '=', date('Y')],
            [DB::raw("substring('nomer', 9, 2)"), '=', date('m')]
        ])->orderBy('nomer', 'desc')->first();

        $nomer = is_null($terakhir) ? 0 : substr($terakhir->nomer, 13);
        return sprintf('KL-%s/%s-PL%03d', date('Y'), date('m'), $nomer + 1);
    }

}
