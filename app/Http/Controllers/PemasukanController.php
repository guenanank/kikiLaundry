<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Pemasukan;
use kikiLaundry\Pelanggan;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{

    private $jenis;
    private $cara_bayar;
    private $pelanggan;

    public function __construct()
    {
        $this->jenis = Pemasukan::jenis();
        $this->cara_bayar = Pemasukan::cara_bayar();
        $this->pelanggan = Pelanggan::pluck('nama', 'id')->all();
    }

    public function index()
    {
        $jenis = $this->jenis;
        $bayar = $this->cara_bayar;
        $pemasukan = Pemasukan::with('pelanggan')->get();
        return view('pemasukan.index', compact('pemasukan', 'jenis', 'bayar'));
    }

    public function create()
    {
        $jenis = $this->jenis;
        $bayar = $this->cara_bayar;
        array_pop($jenis);
        $pelanggan = $this->pelanggan;
        return view('pemasukan.create', compact('jenis', 'bayar', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'jumlah' => str_replace(',', null, $request->jumlah)
        ]);

        $validator = Validator::make($request->all(), Pemasukan::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Pemasukan::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Pemasukan $pemasukan)
    {
        $pemasukan->jumlah = number_format($pemasukan->jumlah);
        $jenis = $this->jenis;
        $bayar = $this->cara_bayar;
        array_pop($jenis);
        $pelanggan = $this->pelanggan;
        return view('pemasukan.edit', compact('pemasukan', 'jenis', 'bayar', 'pelanggan'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $request->merge([
            'jumlah' => str_replace(',', null, $request->jumlah)
        ]);

        $validator = Validator::make($request->all(), Pemasukan::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $pemasukan->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $delete = $pemasukan->delete();
        return response()->json($delete, 200);
    }
}
