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


    public function pembayaran()
    {
    	return $this->hasMany('\kikiLaundry\Pemasukan', 'id_pelanggan');
    }

}
