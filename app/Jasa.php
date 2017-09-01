<?php

namespace kikiLaundry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use kikiLaundry\Jasa_barang as Jb;

class Jasa extends Model
{
    use SoftDeletes;

    protected $table = 'jasa';
    protected $fillable = ['nama', 'nama_kunci', 'tergantung_barang','ongkos', 'klaim', 'open'];
    protected $dates = ['deleted_at'];

    protected $cast = ['tergantung_barang' => 'boolean'];
    protected $appends = ['ongkos_jasa'];

    public static function rules(array $rules = [])
    {
        return collect([
              'nama' => 'required|string|max:127|unique:jasa,nama',
              'tergantung_barang' => 'boolean'
          ])->merge($rules);
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['nama_kunci'] = kebab_case($value);
    }

    public function getOngkosJasaAttribute()
    {
        if ($this->attributes['tergantung_barang']) {
          return Jb::select('id_barang', 'ongkos', 'klaim', 'open')
              ->where('id_jasa', $this->attributes['id'])->get()->keyBy('id_barang');
        } else {
          return self::select('ongkos', 'klaim', 'open')->findOrFail($this->attributes['id']);
        }
    }

    public function cuci()
    {
        return $this->belongsToMany('kikiLaundry\Cuci', 'cuci_jasa', 'id_jasa', 'id_cuci')
          ->wherePivot('deleted_at');
    }

    public function barang()
    {
        return $this->belongsToMany('kikiLaundry\Barang', 'jasa_barang', 'id_jasa', 'id_barang')
          ->withPivot('id_jasa', 'id_barang', 'ongkos', 'klaim', 'open');
    }

    public function jasa_barang()
    {
        return $this->hasMany('kikiLaundry\Jasa_barang', 'id_jasa', 'id');
    }

    public static function gaji()
    {
        list($nama_kunci, $awal, $akhir) = func_get_args();
        $gaji = self::with('barang', 'cuci')->where('nama_kunci', $nama_kunci)->firstOrFail();
        if ($gaji->cuci->isNotEmpty()) {
            $gaji->cuci->load(['order.detil', 'order' => function ($query) use ($awal, $akhir) {
                $query->whereBetween('tanggal', [$awal->format('Y-m-d'), $akhir->format('Y-m-d')]);
            }]);
        }

        return $gaji;
    }
}
