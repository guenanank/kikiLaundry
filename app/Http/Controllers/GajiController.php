<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use kikiLaundry\Gaji;
use kikiLaundry\Jasa;
use kikiLaundry\Order;

class GajiController extends Controller
{

  public function index()
  {
    $bagian = Gaji::bagian();
    return view('gaji.index', compact('bagian'));
  }

  public function show(Request $request)
  {
    $rules = Gaji::rules();
    $rules->pop();
    $validator = Validator::make($request->all(), $rules->toArray());

    if($validator->fails()) :
        return response()->json($validator->errors(), 422);
    endif;

    $bagian = null;
    switch ($request->bagian) {
      case 'harian':
        $bagian = self::harian($request->awal, $request->akhir, $request->prosentase);
        break;

      case 'borongan':
        $bagian = self::borongan($request->awal, $request->akhir);
        break;

      case 'spray':
        $bagian = self::spray($request->awal, $request->akhir);
        break;

      case 'snow':
        $bagian = self::snow($request->awal, $request->akhir);
        break;

      case 'mannequeen':
        $bagian = self::mannequeen($request->awal, $request->akhir);
        break;

      case 'setrika/-gosok':
        $bagian = self::setrika($request->awal, $request->akhir);
        break;
    }

    $gaji = new Gaji;
    $gaji->where([
      ['bagian', '=', $request->bagian],
      ['awal', '=', $request->awal],
      ['akhir', '=', $request->akhir],
    ])->delete();

    $gaji->create([
      'bagian' => $request->bagian,
      'awal' => $request->awal,
      'akhir' => $request->akhir,
      'jumlah' => $bagian['total']
    ]);
  }

  private function harian()
  {
    $parameter = func_get_args();
    return $parameter;
  }

  private function borongan()
  {
    list($awal, $akhir) = func_get_args();
    return;
  }

  private function spray()
  {
    list($awal, $akhir) = func_get_args();
    $jasa = self::cari_jasa('spray');
    $cuci = $jasa->cuci->unique()->pluck('id')->toArray();
    $order = self::cari_order($awal, $akhir);
    $spray = collect([]);
    foreach($order as $o) :
      foreach($o->detil as $d) :
        if(in_array($d->id_cuci, $cuci) == false) :
          continue;
        endif;

        $tergantung_barang = $jasa->barang->pluck('pivot')->where('id_barang', $d->id_barang);
        if($tergantung_barang->isEmpty()) :
          continue;
        endif;

        $spray->push(collect([
          'nomer' => $o->nomer,
          'tanggal' => $o->tanggal,
          'dikirim' => $o->dikirim,
          'barang' => $d->barang->nama,
          'cuci' => $d->cuci->nama,
          'banyaknya' => $d->banyaknya,
          'ongkos' => $tergantung_barang->first()->ongkos
        ]));
      endforeach;
    endforeach;
    return self::hasil($spray, 'spray');
  }

  private function snow()
  {
    list($awal, $akhir) = func_get_args();
    $jasa = self::cari_jasa('snow');
    $cuci = $jasa->cuci->pluck('id')->toArray();
    $order = self::cari_order($awal, $akhir);
    $snow = collect([]);
    foreach($order as $o) :
      foreach($o->detil as $d) :
        if(in_array($d->id_cuci, $cuci) == false) :
          continue;
        endif;

        $snow->push(collect([
          'nomer' => $o->nomer,
          'tanggal' => $o->tanggal,
          'dikirim' => $o->dikirim,
          'barang' => $d->barang->nama,
          'cuci' => $d->cuci->nama,
          'banyaknya' => $d->banyaknya,
          'ongkos' => $jasa->ongkos
        ]));
      endforeach;
    endforeach;
    return self::hasil($snow, 'snow');
  }

  private function mannequeen()
  {
    list($awal, $akhir) = func_get_args();
    $jasa = self::cari_jasa('mannequeen');
    $cuci = $jasa->cuci->unique()->pluck('id')->toArray();
    $order = self::cari_order($awal, $akhir);
    $mannequeen = collect([]);
    foreach($order as $o) :
      foreach($o->detil as $d) :
        if(in_array($d->id_cuci, $cuci) == false) :
          continue;
        endif;

        $tergantung_barang = $jasa->barang->pluck('pivot')->where('id_barang', $d->id_barang);
        if($tergantung_barang->isEmpty()) :
          continue;
        endif;

        $mannequeen->push(collect([
          'nomer' => $o->nomer,
          'tanggal' => $o->tanggal,
          'dikirim' => $o->dikirim,
          'barang' => $d->barang->nama,
          'cuci' => $d->cuci->nama,
          'banyaknya' => $d->banyaknya,
          'ongkos' => $tergantung_barang->first()->ongkos
        ]));
      endforeach;
    endforeach;
    return self::hasil($mannequeen, 'mannequeen');
  }

  private function setrika()
  {
    list($awal, $akhir) = func_get_args();
    $jasa = self::cari_jasa('setrika/-gosok');
    $cuci = $jasa->cuci->unique()->pluck('id')->toArray();
    $order = self::cari_order($awal, $akhir);
    $setrika = collect([]);
    foreach($order as $o) :
      foreach($o->detil as $d) :
        if(in_array($d->id_cuci, $cuci) == false) :
          continue;
        endif;

        $tergantung_barang = $jasa->barang->pluck('pivot')->where('id_barang', $d->id_barang);
        $ongkos = $tergantung_barang->isNotEmpty() ? $tergantung_barang->first()->ongkos :$jasa->ongkos;
        $setrika->push(collect([
          'nomer' => $o->nomer,
          'tanggal' => $o->tanggal,
          'dikirim' => $o->dikirim,
          'barang' => $d->barang->nama,
          'cuci' => $d->cuci->nama,
          'banyaknya' => $d->banyaknya,
          'ongkos' => $ongkos
        ]));
      endforeach;
    endforeach;
    return self::hasil($setrika, 'setrika');
  }

  private function cari_jasa($bagian = null)
  {
    return Jasa::with('barang', 'cuci')->where('nama_kunci', $bagian)->first();
  }

  private function cari_order($awal, $akhir)
  {
    return Order::with('detil.barang', 'detil.cuci')
      ->whereNotNull('dikirim')
      ->whereBetween('tanggal', [$awal, $akhir])
      ->get();
  }

  private function hasil($data = [], $bagian)
  {
    $total = $data->sum(function($item) {
      return $item['banyaknya'] * $item['ongkos'];
    });
    return collect([$bagian => $data, 'total' => $total]);
  }
}
