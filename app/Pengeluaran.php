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
}
