<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $table = 'karyawan';
    protected $fillable = ['nama', 'kontak', 'bagian', 'mulai_kerja', 'gaji_harian', 'gaji_bulanan'];
    protected $dates = ['deleted_at'];

    public static function bagian($bagian = null)
    {
        $collection = collect(['Sekertaris', 'Gudang', 'Supir/Kondektur', 'Keamanan', 'Mekanik', 'Umum']);
        $lists = $collection->combine($collection->map(function ($item) {
            return camel_case($item) ;
        }))->flip();

        return is_null($bagian) ? $lists : $lists->get($bagian);
    }

    public static function rules(array $rules = [])
    {
        return collect([
          'nama' => 'required|string|max:127',
          'kontak' => 'numeric|nullable',
          'bagian' => 'required|string',
          'mulai_kerja' => 'required|date_format:Y-m-d',
          'gaji_harian' => 'required',
          'gaji_bulanan' => 'nullable'
        ])->merge($rules);
    }

    public function getBagianAttribute($value)
    {
        return self::bagian($value);
    }

    public function setGajiHarianAttribute($value)
    {
        $this->attributes['gaji_harian'] = str_replace(',', null, $value);
    }

    public function setGajiBulananAttribute($value)
    {
        $this->attributes['gaji_bulanan'] = str_replace(',', null, $value);
    }

    public function absen()
    {
        return $this->hasMany('\kikiLaundry\Absensi', 'id_karyawan', 'id');
    }

    public static function gaji()
    {
      list($awal, $akhir) = func_get_args();
      return self::with(['absen' => function($query) use($awal, $akhir) {
        $query->whereBetween('tanggal', [$awal, $akhir]);
      }])->orderBy('nama', 'asc')->get();
    }
}
