<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

use kikiLaundry\Gaji;
use kikiLaundry\Karyawan;
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

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $awal = $request->awal;
        $akhir = $request->akhir;
        $hari = self::date_range($awal, $akhir);
        switch ($request->bagian) {
            case 'harian':
              $gaji = Karyawan::gaji($awal, $akhir);
              $pdf = PDF::loadView('gaji.harian', compact('gaji', 'awal', 'akhir', 'hari'));
              return $pdf->download('gaji_harian_' . $awal . '_' . $akhir . '.pdf');
              break;

            case 'borongan':
              break;

            case 'spray':
              break;

            case 'snow':
              break;

            case 'minnequeen':
            case 'setrika/-gosok':
              $jasa = Jasa::with('cuci')->where('nama_kunci', $request->bagian)->firstOrFail();
              $cuci = $jasa->cuci->pluck('nama', 'id');
              $ongkos = $jasa->ongkos_jasa;
              $gaji = Order::whereNotNull('dikirim')
                  ->whereBetween('dikirim', [$awal, $akhir])
                  ->with(['detil' => function ($query) use ($cuci, $ongkos) {
                      $query->whereIn('id_cuci', $cuci->keys()->all());
                      $query->whereIn('id_barang', $ongkos->keys()->all());
                  }])->get();

              $filename = $request->bagian == 'setrika/-gosok' ? 'setrika' : $request->bagian;
              $pdf = PDF::loadView('gaji.' . $filename, compact('gaji', 'awal', 'akhir', 'ongkos', 'hari'));
              return $pdf->download('gaji_' . $filename . '_' . $awal . '_' . $akhir . '.pdf');
              break;
        }
    }

    private static function date_range($start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $dates = collect();
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        return $dates;
    }
}
