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

	public static function rules(Array $rules = [])
	{
		return collect([
				'nama' => 'required|string|max:127|unique:cuci,nama'
			])->merge($rules);
	}

	public function jasa()
	{
		return $this->belongsToMany('kikiLaundry\Jasa', 'cuci_jasa', 'id_cuci', 'id_jasa');
	}

	public function cuci_jasa()
	{
		return $this->hasMany('\kikiLaundry\Cuci_jasa', 'id_cuci', 'id');
	}

}
