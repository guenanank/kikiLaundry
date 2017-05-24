<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Cuci;
use Illuminate\Http\Request;

class CuciController extends Controller
{

    public function index()
    {
        $cuci = Cuci::all();
        return view('jasa.cuci.index', compact('cuci'));
    }

    public function create()
    {
        return view('jasa.cuci.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'nama_kunci' => kebab_case($request->nama)
        ]);

        $validator = Validator::make($request->all(), Cuci::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Cuci::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Cuci $cuci)
    {
        return view('jasa.cuci.edit', compact('cuci'));
    }

    public function update(Request $request, Cuci $cuci)
    {
        $request->merge([
            'nama_kunci' => kebab_case($request->nama)
        ]);
        
        $validator = Validator::make($request->all(), Cuci::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $cuci->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Cuci $cuci)
    {
        $delete = $cuci->delete();
        return response()->json($delete, 200);
    }
}
