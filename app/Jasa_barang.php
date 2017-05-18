<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa_barang extends Model
{
    use SoftDeletes;

    protected $table = 'jasa_barang';
    protected $fillable = ['id_jasa', 'id_barang', 'ongkos'];
    protected $dates = ['deleted_at'];
}
