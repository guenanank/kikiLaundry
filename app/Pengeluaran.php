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
        $collection = collect(['Harian', 'Mingguan', 'Bulanan']);
        $lists = $collection->combine($collection->map(function($item) {
            return camel_case($item);
        }))->flip();
        return is_null($jenis) ? $lists : $lists->get($jenis);
    }

    public static function rules($rules = [])
    {
    	return collect([
    		'tanggal' => 'required|date:Y-m-d',
    		'jenis' => 'required|string|max:7',
    		'jumlah' => 'required|numeric',
    		'keterangan' => 'string|nullable'
		])->merge($rules);
    }  

    public function getJenisAttribute($value)
    {
        return self::jenis($value);
    }
}