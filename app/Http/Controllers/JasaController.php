<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use kikiLaundry\Jasa;
use kikiLaundry\Barang;
use kikiLaundry\Jasa_barang as Jb;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    private $validator;
    protected $barang;

    public function __construct(Request $request)
    {
        $this->barang = Barang::pluck('nama', 'id')->all();

        if ($request->has('ongkos') || $request->has('klaim') || $request->has('open')) {
            $request->merge([
            'ongkos' => is_null($request->ongkos) ? 0 : str_replace(',', null, $request->ongkos),
            'klaim' => is_null($request->klaim) ? 0 : str_replace(',', null, $request->klaim),
            'open' => is_null($request->open) ? 0 : str_replace(',', null, $request->open)
          ]);
        }

        $this->validator = Validator::make($request->all(), Jasa::rules()->toArray());
    }

    public function index()
    {
        $jasa = Jasa::all();
        return view('cuci.jasa.index', compact('jasa'));
    }

    public function create()
    {
        $barang = Barang::pluck('nama', 'id')->all();
        return view('cuci.jasa.create', compact('barang'));
    }

    public function store(Request $request)
    {
        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $create = Jasa::create($request->all());
        if ($request->tergantung_barang) {
            $this->store_jasa_barang($request->barang, $create->id);
        }
        return response()->json(['create' => $create], 200);
    }

    public function edit(Jasa $jasa)
    {
        $barang = $this->barang;
        $jasa = Jasa::with('jasa_barang')->findOrFail($jasa->id);
        return view('cuci.jasa.edit', compact('jasa', 'barang'));
    }

    public function update(Request $request, Jasa $jasa)
    {
        $this->validator = Validator::make($request->all(), Jasa::rules([
            'nama' => [
                'required',
                'string',
                'max:127',
                Rule::unique('jasa')->ignore($jasa->id)
            ]
        ])->toArray());

        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $update = $jasa->update($request->all());
        Jb::where('id_jasa', $jasa->id)->delete();
        if ($request->tergantung_barang) {
            $this->store_jasa_barang($request->barang, $jasa->id);
        }
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Jasa $jasa)
    {
        Jb::where('id_jasa', $jasa->id)->delete();
        $delete = $jasa->delete();
        return response()->json($delete, 200);
    }

    private function store_jasa_barang($barang, $id_jasa)
    {
        $barang = collect($barang)->map(function ($item, $key) use ($id_jasa) {
            $item['id_jasa'] = $id_jasa;
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
            return $item;
        });
        Jb::insert($barang->toArray());
    }
}
