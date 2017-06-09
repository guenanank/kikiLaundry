<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuci extends Model
{
	use SoftDeletes;

    protected $table = 'cuci';
    protected $fillable = ['nama'];
    protected $dates = ['deleted_at'];

    public static function rules($rules = [])
    {
    	return array_merge([
    		'nama' => 'required|string|max:127|unique:cuci,nama'
		], $rules);
    }

    public function cuci_jasa()
    {
        return $this->hasMany('\kikiLaundry\Cuci_jasa', 'id_cuci', 'id');
    }

}
