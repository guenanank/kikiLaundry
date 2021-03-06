<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gaji extends Model
{
    use SoftDeletes;

    protected $table = 'gaji';
    protected $fillable = ['bagian', 'awal', 'akhir'];
    protected $dates = ['deleted_at'];

    public static function bagian($bagian = null)
    {
        $lists = Jasa::pluck('nama', 'nama_kunci')->reject(function ($item, $key) {
            return starts_with($key, 'distro-');
        })->reject(function ($item, $key) {
            return starts_with($key, 'whiskert-');
        })->put('harian', 'Harian');

        return is_null($bagian) ? $lists : $lists->get($bagian);
    }

    public static function rules(array $rules = [])
    {
        return collect([
        'bagian' => 'required|string|max:127',
        'awal' => 'required|date_format:Y-m-d|before:akhir',
        'akhir' => 'required|date_format:Y-m-d|after:awal'
      ])->merge($rules);
    }
}
