<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Pelanggan;
use kikiLaundry\Barang;
use kikiLaundry\Jasa;
use kikiLaundry\Harga;
use Illuminate\Http\Request;

class HargaController extends Controller
{

	protected $pelanggan;
	protected $barang;
	protected $jasa;

	public function __construct(Pelanggan $pelanggan, Barang $barang, Jasa $jasa)
	{
		$this->pelanggan = $pelanggan;
		$this->barang = $barang;
		$this->jasa = $jasa;
	}

	public function index($id_pelanggan)
	{
		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$harga = Harga::with('barang', 'jasa')->where('id_pelanggan', $id_pelanggan)->get();
		return view('pelanggan.harga.index', compact('pelanggan', 'harga'));
	}

	public function create($id_pelanggan)
	{
		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$barang = $this->barang->pluck('nama', 'id');
		$jasa = $this->jasa->pluck('nama', 'id');
		return view('pelanggan.harga.create', compact('pelanggan', 'barang', 'jasa'));
	}

	public function store(Request $request)
	{
		$request->merge([
            'tunai' => is_null($request->tunai) ? 0 : str_replace(',', null, $request->tunai),
            'cicil' => is_null($request->cicil) ? 0 : str_replace(',', null, $request->cicil)
        ]);

        $validator = Validator::make($request->all(), Harga::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Harga::create($request->all());
        return response()->json(['create' => $create], 200);
	}

	public function edit($id_pelanggan, $id_barang, $id_jasa)
	{
		$harga = Harga::where([
			['id_pelanggan', '=', $id_pelanggan],
			['id_barang', '=', $id_barang],
			['id_jasa', '=', $id_jasa]
		])->firstOrFail();

		$harga->tunai = number_format($harga->tunai);
		$harga->cicil = number_format($harga->cicil);
		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$barang = $this->barang->pluck('nama', 'id');
		$jasa = $this->jasa->pluck('nama', 'id');
		return view('pelanggan.harga.edit', compact('harga', 'pelanggan', 'barang', 'jasa'));
	}

	public function update(Request $request)
	{
		$request->merge([
            'tunai' => is_null($request->tunai) ? 0 : str_replace(',', null, $request->tunai),
            'cicil' => is_null($request->cicil) ? 0 : str_replace(',', null, $request->cicil)
        ]);

        $validator = Validator::make($request->all(), Harga::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        Harga::where([
			['id_pelanggan', '=', $request->id_pelanggan],
			['id_barang', '=', $request->id_barang],
			['id_jasa', '=', $request->id_jasa]
		])->delete();
		
        $update = Harga::create($request->all());
        return response()->json(['update' => $update], 200);
	}

	public function destroy(Request $request)
	{
		$delete = Harga::where([
			['id_pelanggan', '=', $request->id_pelanggan],
			['id_barang', '=', $request->id_barang],
			['id_jasa', '=', $request->id_jasa]
		])->delete();

		return response()->json($delete, 200);
	}

	public function check_price($id_pelanggan)
	{
        $collect = [];
        $barang = $this->barang->pluck('nama', 'id')->all();
        $jasa = $this->jasa->pluck('nama', 'id')->all();
        foreach(Harga::where('id_pelanggan', $id_pelanggan)->get() as $harga) :
            $collect['barang'][$harga['id_barang']] = $barang[$harga['id_barang']];
            $collect['jasa'][$harga['id_barang']][$harga['id_jasa']] = [
                'nama' => $jasa[$harga['id_jasa']],
                'tunai' => $harga['tunai'],
                'cicil' => $harga['cicil']
            ];
        endforeach;

        $collect = collect($collect)->toJson();
        return $collect;
	}
}
