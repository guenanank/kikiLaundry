<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuci extends Model
{
    use SoftDeletes;

    protected $table = 'cuci';
    protected $fillable = ['nama', 'nama_kunci'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127|unique:cuci,nama'
		], $rules);
    }

}
