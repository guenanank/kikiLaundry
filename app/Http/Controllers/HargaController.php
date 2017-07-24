<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Pelanggan;
use kikiLaundry\Barang;
use kikiLaundry\Cuci;
use kikiLaundry\Harga;
use Illuminate\Http\Request;

class HargaController extends Controller
{
	private $validator;
	protected $pelanggan;
	protected $barang;
	protected $cuci;

	public function __construct(Request $request, Pelanggan $pelanggan, Barang $barang, Cuci $cuci)
	{
		$this->pelanggan = $pelanggan;
		$this->barang = $barang;
		$this->cuci = $cuci;

		if($request->has('tunai') || $request->has('cicil')) :
            $request->merge([
	            'tunai' => is_null($request->tunai) ? 0 : str_replace(',', null, $request->tunai),
	            'cicil' => is_null($request->cicil) ? 0 : str_replace(',', null, $request->cicil)
	        ]);
        endif;

        $this->validator = Validator::make($request->all(), Harga::rules()->toArray());
	}

	public function index($id_pelanggan)
	{
		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$harga = Harga::with('barang', 'cuci')->where('id_pelanggan', $id_pelanggan)->get();
		return view('pelanggan.harga.index', compact('pelanggan', 'harga'));
	}

	public function create($id_pelanggan)
	{
		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$barang = $this->barang->pluck('nama', 'id');
		$cuci = $this->cuci->pluck('nama', 'id');
		return view('pelanggan.harga.create', compact('pelanggan', 'barang', 'cuci'));
	}

	public function store(Request $request)
	{
        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
        endif;

        $create = Harga::create($request->all());
        return response()->json(['create' => $create], 200);
	}

	public function edit($id_pelanggan, $id_barang, $id_cuci)
	{
		$harga = Harga::where([
			['id_pelanggan', '=', $id_pelanggan],
			['id_barang', '=', $id_barang],
			['id_cuci', '=', $id_cuci]
		])->firstOrFail();

		$pelanggan = $this->pelanggan->findOrFail($id_pelanggan);
		$barang = $this->barang->pluck('nama', 'id');
		$cuci = $this->cuci->pluck('nama', 'id');
		return view('pelanggan.harga.edit', compact('harga', 'pelanggan', 'barang', 'cuci'));
	}

	public function update(Request $request)
	{
        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
        endif;

        Harga::where([
			['id_pelanggan', '=', $request->id_pelanggan],
			['id_barang', '=', $request->id_barang],
			['id_cuci', '=', $request->id_cuci]
		])->delete();

        $update = Harga::create($request->all());
        return response()->json(['update' => $update], 200);
	}

	public function destroy($id_pelanggan, $id_barang, $id_cuci)
	{
		$delete = Harga::where([
			['id_pelanggan', '=', $id_pelanggan],
			['id_barang', '=', $id_barang],
			['id_cuci', '=', $id_cuci]
		])->delete();

		return response()->json($delete, 200);
	}

	public function check_price($id_pelanggan)
	{
        $collect = [];
        $barang = $this->barang->pluck('nama', 'id')->all();
        $cuci = $this->cuci->pluck('nama', 'id')->all();
        foreach(Harga::where('id_pelanggan', $id_pelanggan)->get() as $harga) :
            $collect['barang'][$harga['id_barang']] = $barang[$harga['id_barang']];
            $collect['cuci'][$harga['id_barang']][$harga['id_cuci']] = [
                'nama' => $cuci[$harga['id_cuci']],
                'tunai' => $harga['tunai'],
                'cicil' => $harga['cicil']
            ];
        endforeach;

        $collect = collect($collect)->toJson();
        return $collect;
	}
}
