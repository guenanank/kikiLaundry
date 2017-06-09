<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuci_jasa extends Model
{
	use SoftDeletes;
	
    protected $table = 'cuci_jasa';
    protected $fillable = ['id_cuci', 'id_jasa'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'id_cuci' => 'exists:cuci,id',
    		'id_jasa' => 'exists:jasa,id'
		], $rules);
    }
}
