<?php

namespace kikiLaundry\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use kikiLaundry\Absensi;
use kikiLaundry\Karyawan;

class AbsensiController extends Controller
{
    public function find(Request $request)
    {
        $karyawan = Karyawan::orderBy('bagian')->pluck('nama', 'id')->all();
        $absensi = Absensi::where('tanggal', $request->tanggal)->get();
        $tanggal = $absensi->isEmpty() ? $request->tanggal : $absensi->pluck('tanggal')->unique()->first();
        $libur = $absensi->pluck('libur_keterangan', 'libur')->unique();
        return view('karyawan.absensi', compact('karyawan', 'tanggal', 'absensi', 'libur'));
    }

    public function submit(Request $request)
    {
        $karyawan = Karyawan::orderBy('bagian')->pluck('nama', 'id')->all();
        $validator = Validator::make($request->all(), Absensi::rules()->toArray());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [];
        foreach (collect($karyawan)->only($request->karyawan) as $k => $v) {
            $data[] = [
            'id_karyawan' => $k,
            'tanggal' => $request->tanggal,
            'masuk' => true,
            'libur' => $request->libur,
            'libur_keterangan' => $request->libur_keterangan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ];
        }

        Absensi::where('tanggal', $request->tanggal)->delete();
        $submit = Absensi::insert($data);
        return response()->json(['submit' => $submit], 200);
    }
}
