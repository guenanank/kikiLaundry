<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa extends Model
{
	use SoftDeletes;

    protected $table = 'jasa';
    protected $fillable = ['nama', 'ongkos', 'klaim', 'kata_kunci'];
    protected $dates = ['deleted_at'];
}
