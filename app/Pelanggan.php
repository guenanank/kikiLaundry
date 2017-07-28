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

    public static function rules($rules = [])
    {
    	return collect([
      		'nama' => 'required|string|max:127',
      		'alamat' => 'string|nullable',
      		'telepon' => 'numeric|nullable'
        ])->merge($rules);
    }
}
