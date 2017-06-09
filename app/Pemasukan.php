<?php

namespace kikiLaundry;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasukan extends Model
{
    use SoftDeletes;

    protected $table = 'pemasukan';
    protected $fillable = ['nomer', 'jenis', 'id_pelanggan','tanggal', 'jumlah', 'cara_bayar', 'catatan'];
    protected $dates = ['deleted_at'];

    public function getJumlahAttribute($value)
    {
        return number_format($value);
    }

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
    	return array_merge([
            'nomer' => 'required|string|max:31|unique:pemasukan,nomer',
    		'jenis' => 'required|string|max:31',
    		'id_pelanggan' => 'nullable|exists:pelanggan,id',
    		'tanggal' => 'required|date:Y-md',
    		'jumlah' => 'required|numeric',
    		'cara_bayar' => 'string|max:15|nullable',
    		'catatan' => 'string|nullable'
		], $rules);
    }

    public static function nomer()
    {
        $terakhir = Pemasukan::select('nomer')->where([
            [DB::raw("substring(nomer, 4, 4)"), '=', date('Y')],
            [DB::raw("substring(nomer, 9, 2)"), '=', date('m')]
        ])->orderBy('nomer', 'desc')->first();

        $nomer = is_null($terakhir) ? 0 : substr($terakhir->nomer, 13);
        return sprintf('KL-%s/%s-PM%03d', date('Y'), date('m'), $nomer + 1);
    }

    public function pelanggan()
    {
    	return $this->hasOne('kikiLaundry\pelanggan', 'id', 'id_pelanggan');
    }


}
