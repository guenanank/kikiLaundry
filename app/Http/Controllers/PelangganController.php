<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private $validator;

    public function __construct(Request $request) 
    {
        $this->validator = Validator::make($request->all(), Pelanggan::rules()->toArray());
    }

    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
        endif;

        $create = Pelanggan::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        if($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
        endif;

        $update = $pelanggan->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $delete = $pelanggan->delete();
        return response()->json($delete, 200);
    }
}
