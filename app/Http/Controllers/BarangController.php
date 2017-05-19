<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Barang::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Barang::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), Barang::rules());
        if ($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $barang->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Barang $barang)
    {
        $delete = $barang->delete();
        return response()->json($delete, 200);
    }
}
