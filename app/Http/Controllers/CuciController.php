<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use kikiLaundry\Jasa;
use kikiLaundry\Cuci;
use kikiLaundry\Cuci_jasa;
use Illuminate\Http\Request;

class CuciController extends Controller
{
    private $jasa;
    private $validator;

    public function __construct(Request $request)
    {
        $this->jasa = Jasa::pluck('nama', 'id')->all();
        $this->validator = Validator::make($request->all(), Cuci::rules()->toArray());
    }

    public function index()
    {
        $cuci = Cuci::all();
        return view('cuci.index', compact('cuci'));
    }

    public function create()
    {
        $jasa = $this->jasa;
        return view('cuci.create', compact('jasa'));
    }

    public function store(Request $request)
    {
        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
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

    public function edit(Cuci $cuci)
    {
        $cuci = $cuci->with('cuci_jasa')->findOrFail($cuci->id);
        $jasa = $this->jasa;
        return view('cuci.edit', compact('cuci', 'jasa'));
    }

    public function update(Request $request, Cuci $cuci)
    {
        $this->validator = Validator::make($request->all(), $cuci->rules([
          'nama' => [
            'required', 'string', 'max:127',
            Rule::unique('cuci')->ignore($cuci->id),
          ]
        ])->toArray());

        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
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

    public function destroy(Cuci $cuci)
    {
        Cuci_jasa::where('id_cuci', $cuci->id)->delete();
        $delete = $cuci->delete();
        return response()->json($delete, 200);
    }
}
