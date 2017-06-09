<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Jasa;
use kikiLaundry\Barang;
use kikiLaundry\Jasa_barang as Jb;
use Illuminate\Http\Request;

class JasaController extends Controller
{
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
        $request->merge([
            'nama_kunci' => kebab_case($request->nama),
            'ongkos' => is_null($request->ongkos) ? 0 : str_replace(',', null, $request->ongkos),
            'klaim' => is_null($request->klaim) ? 0 : str_replace(',', null, $request->klaim)
        ]);

        $validator = Validator::make($request->all(), Jasa::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Jasa::create($request->all());
        if($request->tergantung_barang) :
            $this->store_jasa_barang($request->barang, $create->id);
        endif;
        return response()->json(['create' => $create], 200);
    }

    public function edit(Jasa $jasa)
    {
        $barang = Barang::pluck('nama', 'id')->all();
        $jasa = Jasa::with('jasa_barang')->findOrFail($jasa->id);
        return view('cuci.jasa.edit', compact('jasa', 'barang'));
    }

    public function update(Request $request, Jasa $jasa)
    {
        $request->merge([
            'nama_kunci' => kebab_case($request->nama),
            'ongkos' => is_null($request->ongkos) ? 0 : str_replace(',', null, $request->ongkos),
            'klaim' => is_null($request->klaim) ? 0 : str_replace(',', null, $request->klaim)
        ]);
        
        $validator = Validator::make($request->all(), Jasa::rules());
        if ($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $jasa->update($request->all());
        Jb::where('id_jasa', $jasa->id)->delete();
        if($request->tergantung_barang) :
            $this->store_jasa_barang($request->barang, $create->id);
        endif;
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
        foreach ($barang as $brg) :
            $brg['id_jasa'] = $id_jasa;
            Jb::create($brg);
        endforeach;
    }
}
