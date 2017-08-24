<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;

    protected $table = 'absensi';
    protected $fillable = ['id_karyawan', 'tanggal', 'masuk', 'libur', 'libur_keterangan'];
    protected $dates = ['deleted_at'];

    protected $appends = ['gaji'];

    public static function rules(array $rules = [])
    {
        return collect([
        'tanggal' => 'required|date:Y-m-d',
        'masuk' => 'boolean',
        'libur_keterangan' => 'string|nullable'
      ])->merge($rules);
    }

    public function karyawan()
    {
        return $this->hasOne('\kikiLaundry\Karyawan', 'id', 'id_karyawan');
    }

    public function getGajiAttribute()
    {
      $karyawan = Karyawan::findOrFail($this->attributes['id_karyawan']);
      return $this->attributes['libur'] ? ($karyawan->gaji_harian * 0.5) + $karyawan->gaji_harian : $karyawan->gaji_harian;
    }
}
