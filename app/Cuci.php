<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuci extends Model
{
    use SoftDeletes;

    protected $table = 'cuci';
    protected $fillable = ['nama', 'ongkos', 'open'];
    protected $dates = ['deleted_at'];
}
