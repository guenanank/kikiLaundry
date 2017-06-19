<?php

namespace kikiLaundry;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'order';
    protected $fillable = [
	    'nomer', 
	    'id_pelanggan', 
	    'tanggal', 
	    'catatan', 
	    'keterangan', 
	    'pembayaran', 
	    'tanggal_pembayaran', 
	    'jumlah_tunai', 
	    'jumlah_cicil', 
	    'dicetak', 
	    'dikirim'
    ];

    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nomer' => 'required|string|max:31|unique:order,nomer',
    		'id_pelanggan' => 'required|exists:pelanggan,id',
    		'tanggal' => 'required|date:Y-m-d',
    		'catatan' => 'string|nullable',
    		'keterangan' => 'string|nullable',
            'pembayaran' => 'string|max:15|nullable',
    		'tanggal_pembayaran' => 'date:Y-m-d|nullable',
    		'jumlah_tunai' => 'numeric',
    		'dicetak' => 'boolean',
    		'dikirim' => 'date:Y-m-d|nullable'
		], $rules);
    }

    public static function nomer_urut()
    {
        $terakhir = Order::select('nomer')->where([
            [DB::raw("substring(nomer, 4, 4)"), '=', date('Y')],
            [DB::raw("substring(nomer, 9, 2)"), '=', date('m')]
        ])->orderBy('nomer', 'desc')->first();

        $nomer = is_null($terakhir) ? 0 : substr($terakhir->nomer, 13);
        return sprintf('KL-%s/%s-OR%03d', date('Y'), date('m'), $nomer + 1);
    }

    public function pelanggan()
    {
    	return $this->hasOne('kikiLaundry\Pelanggan', 'id', 'id_pelanggan');
    }

    public function detil()
    {
    	return $this->hasMany('kikiLaundry\Order_lengkap', 'id_order', 'id');
    }
}
