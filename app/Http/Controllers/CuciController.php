<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Jasa;
use kikiLaundry\Cuci;
use kikiLaundry\Cuci_jasa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CuciController extends Controller
{
    public function index()
    {
      $cuci = Cuci::all();
      return view('cuci.index', compact('cuci'));
    }

    public function create()
    {
      $jasa = Jasa::pluck('nama', 'id')->all();
      return view('cuci.create', compact('jasa'));
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), Cuci::rules()->toArray());
      if($validator->fails()) :
        return response()->json($validator->errors(), 422);
      endif;

      $create = Cuci::create($request->all());
      $id_cuci = $create->id;
      if($create) :
        $cuci_jasa = collect($request->jasa)->map(function($item) use($id_cuci) {
            return [
              'id_cuci' => $id_cuci,
              'id_jasa' => $item,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ];
          })->toArray();
        Cuci_jasa::insert($cuci_jasa);
      endif;

      return response()->json(['create' => $create], 200);
    }

    public function edit($id)
    {
      $cuci = Cuci::with('cuci_jasa')->findOrFail($id);
      $jasa = Jasa::pluck('nama', 'id')->all();
      return view('cuci.edit', compact('cuci', 'jasa'));
    }

    public function update(Request $request, $id)
    {
      $cuci = Cuci::findOrFail($id);
      $validator = Validator::make($request->all(), $cuci->rules([
          'nama' => [
            'required', 'string', 'max:127',
            Rule::unique('cuci')->ignore($cuci->id),
          ]
        ])->toArray());

      if($validator->fails()) :
        return response()->json($validator->errors(), 422);
      endif;

      $update = $cuci->update($request->all());
      Cuci_jasa::where('id_cuci', $cuci->id)->delete();
      $id_cuci = $cuci->id;
      $cuci_jasa = collect($request->jasa)->map(function($item) use($id_cuci) {
          return [
              'id_cuci' => $id_cuci,
              'id_jasa' => $item,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ];
        })->toArray();
      Cuci_jasa::insert($cuci_jasa);

      return response()->json(['update' => $update], 200);
    }

    public function destroy($id)
    {
      $cuci = Cuci::findOrFail($id);
      Cuci_jasa::where('id_cuci', $cuci->id)->delete();
      $delete = $cuci->delete();
      return response()->json($delete, 200);
    }
}
