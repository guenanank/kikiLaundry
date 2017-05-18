<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasukan extends Model
{
    use SoftDeletes;

    protected $table = 'pemasukan';
    protected $fillable = ['jenis', 'id_pelanggan','tanggal', 'jumlah', 'cara_bayar', 'catatan'];
    protected $dates = ['deleted_at'];
}
