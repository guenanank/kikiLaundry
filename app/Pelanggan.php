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
    	return array_merge($rules, [
    		'nama' => 'required|string|max:127',
    		'alamat' => 'string|nullable',
    		'telepon' => 'numeric|nullable'
		]);
    }

    public function pembayaran()
    {
    	return $this->hasMany('\kikiLaundry\Pemasukan', 'id_pelanggan');
    }

}
