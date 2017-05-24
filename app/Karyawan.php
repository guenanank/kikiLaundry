<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $table = 'karyawan';
    protected $fillable = ['nama', 'kontak', 'bagian', 'mulai_kerja', 'gaji_harian', 'gaji_bulanan'];
    protected $dates = ['deleted_at'];

    public static function bagian($bagian = null)
    {
    	$bag = [
    		'sekertaris' => 'Sekertaris',
    		'gudang' => 'Gudang',
    		'supir_kondektur' => 'Supir/Kondektur',
    		'keamanan' => 'Keamanan',
    		'mekanik' => 'Mekanik',
    		'umum' => 'Umum'
    	];

    	return is_null($bagian) ? $bag : $bag[$bagian];
    }

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127',
    		'kontak' => 'numeric|nullable',
    		'bagian' => 'required|string',
    		'mulai_kerja' => 'required|date_format:Y-m-d',
    		'gaji_harian' => 'required|numeric',
    		'gaji_bulanan' => 'numeric|nullable'
		], $rules);
    }
}
