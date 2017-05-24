<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use SoftDeletes;

    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'alamat', 'telepon'];
    protected $dates = ['deleted_at'];
    protected $nullable = [
        'alamat',
        'telepon'
    ];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127',
    		'alamat' => 'string|nullable',
    		'telepon' => 'numeric|nullable'
		], $rules);
    }
}
