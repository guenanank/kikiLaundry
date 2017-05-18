<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harga extends Model
{
    use SoftDeletes;

    protected $table = 'harga';
    protected $fillable = ['id_pelanggan', 'id_barang', 'id_cuci', 'tunai', 'cicil'];
    protected $dates = ['deleted_at'];
}
