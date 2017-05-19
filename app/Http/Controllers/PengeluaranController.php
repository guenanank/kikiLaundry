<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use DB;
use kikiLaundry\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    private $jenis;
    private $pengeluaran_bulanan;

    public function __construct()
    {
        $this->jenis = Pengeluaran::jenis();
        $this->pengeluaran_bulanan = Pengeluaran::pengeluaran_bulanan();
    }

    public function index() 
    {
        $pengeluaran = Pengeluaran::all();
        $jenis = $this->jenis;
        $pb = $this->pengeluaran_bulanan;
        return view('pengeluaran.index', compact('pengeluaran', 'jenis', 'pb'));
    }

    public function create()
    {
        $nomer = Pengeluaran::nomer_urut();
        $jenis = $this->jenis;
        $pb = $this->pengeluaran_bulanan;
        return view('pengeluaran.create', compact('nomer', 'jenis', 'pb'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'jumlah' => str_replace(',', null, $request->jumlah)
        ]);

        $validator = Validator::make($request->all(), Pengeluaran::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Pengeluaran::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $pengeluaran->jumlah = number_format($pengeluaran->jumlah);
        $jenis = $this->jenis;
        $pb = $this->pengeluaran_bulanan;
        return view('pengeluaran.edit', compact('pengeluaran', 'jenis', 'pb'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->merge([
            'jumlah' => str_replace(',', null, $request->jumlah)
        ]);

        $validator = Validator::make($request->all(), Pengeluaran::rules());

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $pengeluaran->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $delete = $pengeluaran->delete();
        return response()->json($delete, 200);
    }
}
