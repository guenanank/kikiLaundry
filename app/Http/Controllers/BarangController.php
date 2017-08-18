<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $validator = Validator::make($request->all(), Barang::rules()->toArray());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $create = Barang::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $validator = Validator::make($request->all(), Barang::rules([
          'nama' => [
            'required', 'string', 'max:127',
            Rule::unique('barang')->ignore($barang->id)
          ]
        ])->toArray());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $update = $barang->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy($id)
    {
        $delete = Barang::findOrFail($id)->delete();
        return response()->json($delete, 200);
    }
}
