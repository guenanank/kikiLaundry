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
    'keterangan',
    'pembayaran',
    'tanggal_pembayaran',
    'catatan_pembayaran',
    'jumlah_tunai',
    'jumlah_cicil',
    'dicetak',
    'dikirim'
  ];

    protected $dates = ['deleted_at'];

    public static function rules(array $rules = [])
    {
        return collect([
        'nomer' => 'required|string|max:31|unique:order,nomer',
        'id_pelanggan' => 'required|exists:pelanggan,id',
        'tanggal' => 'required|date:Y-m-d',
        'keterangan' => 'string|nullable',
        'pembayaran' => 'string|max:15|nullable',
        'tanggal_pembayaran' => 'date:Y-m-d|nullable',
        'catatan_pembayaran' => 'string|nullable',
        'jumlah_tunai' => 'required',
        'jumlah_cicil' => 'required',
        'dicetak' => 'boolean',
        'dikirim' => 'date:Y-m-d|nullable'
      ])->merge($rules);
    }

    public static function nomer_urut()
    {
        $terakhir = Order::withTrashed()->select('nomer')->where([
        [DB::raw('substring(nomer, 4, 4)'), '=', date('Y')],
        [DB::raw('substring(nomer, 9, 2)'), '=', date('m')]
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

    public function setJumlahTunaiAttribute($value)
    {
        $this->attributes['jumlah_tunai'] = str_replace(',', null, $value);
    }

    public function setJumlahCicilAttribute($value)
    {
        $this->attributes['jumlah_cicil'] = str_replace(',', null, $value);
    }
}
