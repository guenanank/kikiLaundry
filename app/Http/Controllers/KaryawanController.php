<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{

    public function index()
    {
        $karyawan = Karyawan::all();
        $bagian = Karyawan::bagian();
        return view('karyawan.index', compact('karyawan', 'bagian'));
    }

    public function create()
    {
        $bagian = Karyawan::bagian();
        return view('karyawan.create', compact('bagian'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'gaji_harian' => str_replace(',', null, $request->gaji_harian),
            'gaji_bulanan' => str_replace(',', null, $request->gaji_bulanan)
        ]);

        $validator = Validator::make($request->all(), Karyawan::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Karyawan::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Karyawan $karyawan)
    {
        $bagian = Karyawan::bagian();
        return view('karyawan.edit', compact('karyawan', 'bagian'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->merge([
            'gaji_harian' => str_replace(',', null, $request->gaji_harian),
            'gaji_bulanan' => str_replace(',', null, $request->gaji_bulanan)
        ]);

        $validator = Validator::make($request->all(), Karyawan::rules());
        if ($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $karyawan->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Karyawan $karyawan)
    {
        $delete = $karyawan->delete();
        return response()->json($delete, 200);
    }
}
