<?php

namespace kikiLaundry\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use kikiLaundry\Absensi;
use kikiLaundry\Karyawan;

class AbsensiController extends Controller
{
	  private $Validator;
    private $karyawan;

    public function __construct(Request $request)
    {
    	$this->validator = Validator::make($request->all(), Absensi::rules()->toArray());
    	$this->karyawan = Karyawan::orderBy('bagian')->pluck('nama', 'id')->all();
    }

		public function find(Request $request)
		{
			$karyawan = $this->karyawan;
			$absensi = Absensi::where('tanggal', $request->tanggal)->get();
			$tanggal = $absensi->isEmpty() ? $request->tanggal : $absensi->pluck('tanggal')->unique()->first();
			return view('karyawan.absensi', compact('karyawan', 'tanggal', 'absensi'));
		}

		public function submit(Request $request)
		{
			if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
      endif;

			$data = [];
			foreach(collect($this->karyawan)->only($request->karyawan) as $k => $v) :
				$data[] = [
					'id_karyawan' => $k,
					'tanggal' => $request->tanggal,
					'masuk' => true,
					'libur' => $request->libur == 'on' ? true : false,
					'libur_keterangan' => $request->libur_keterangan,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
			endforeach;

			Absensi::where('tanggal', $request->tanggal)->delete();
			$submit = Absensi::insert($data);
			return response()->json(['submit' => $submit], 200);
		}
}
