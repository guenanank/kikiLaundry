<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa extends Model
{
	use SoftDeletes;

    protected $table = 'jasa';
    protected $fillable = ['nama'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127|unique:jasa,nama'
		], $rules);
    }

}
