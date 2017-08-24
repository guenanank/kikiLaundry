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

    public static function jenis($jenis = null)
    {
        $collection = collect(['Penambahan Biaya', 'Cicilan Pelanggan', 'Pembayaran Pelanggan']);
        $lists = $collection->combine($collection->map(function ($item) {
            return camel_case($item);
        }))->flip();

        return is_null($jenis) ? $lists : $lists->get($jenis);
    }

    public static function cara_bayar($cara_bayar = null)
    {
        $collection = collect(['Tunai', 'Giro', 'Cek', 'Transfer']);
        $lists = $collection->combine($collection->map(function ($item) {
            return camel_case($item);
        }))->flip();

        return is_null($cara_bayar) ? $lists : $lists->get($cara_bayar);
    }

    public static function rules(array $rules = [])
    {
        return collect([
          'nomer' => 'required|string|max:31|unique:pemasukan,nomer',
              'jenis' => 'required|string|max:31',
              'id_pelanggan' => 'nullable|exists:pelanggan,id',
              'tanggal' => 'required|date:Y-md',
              'jumlah' => 'required|numeric',
              'cara_bayar' => 'string|max:15|nullable',
              'catatan' => 'string|nullable'
        ])->merge($rules);
    }

    public static function nomer()
    {
        $terakhir = Pemasukan::withTrashed()->select('nomer')->where([
          [DB::raw("substring(nomer, 4, 4)"), '=', date('Y')],
          [DB::raw("substring(nomer, 9, 2)"), '=', date('m')]
        ])->orderBy('nomer', 'desc')->first();

        $nomer = is_null($terakhir) ? 0 : substr($terakhir->nomer, 13);
        return sprintf('KL-%s/%s-PM%03d', date('Y'), date('m'), $nomer + 1);
    }

    public function getJenisAttribute($value)
    {
        return self::jenis($value);
    }

    public function getCaraBayarAttribute($value)
    {
        return self::cara_bayar($value);
    }

    public function pelanggan()
    {
        return $this->hasOne('kikiLaundry\Pelanggan', 'id', 'id_pelanggan');
    }
}
