<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    private $validator;
    private $bagian;

    public function __construct(Request $request)
    {
        $this->bagian = Karyawan::bagian();
        $this->validator = Validator::make($request->all(), Karyawan::rules()->toArray());
    }

    public function index()
    {
        $karyawan = Karyawan::select('id', 'nama', 'kontak', 'bagian', 'mulai_kerja')->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $bagian = $this->bagian;
        return view('karyawan.create', compact('bagian'));
    }

    public function store(Request $request)
    {
        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $create = Karyawan::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Karyawan $karyawan)
    {
        $bagian = $this->bagian;
        return view('karyawan.edit', compact('karyawan', 'bagian'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $update = $karyawan->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Karyawan $karyawan)
    {
        $delete = $karyawan->delete();
        return response()->json($delete, 200);
    }
}
