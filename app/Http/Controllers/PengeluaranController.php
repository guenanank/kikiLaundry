<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    private $jenis;
    private $validator;

    public function __construct(Request $request)
    {
        $this->jenis = Pengeluaran::jenis()->toArray();

        if ($request->has('jumlah')) :
            $request->merge([
                'jumlah' => str_replace(',', null, $request->jumlah)
            ]);
        endif;

        $this->validator = Validator::make($request->all(), Pengeluaran::rules()->toArray());
    }

    public function index()
    {
        $pengeluaran = Pengeluaran::all();
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        $jenis = $this->jenis;
        return view('pengeluaran.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        if ($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
        endif;

        $create = Pengeluaran::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $jenis = $this->jenis;
        return view('pengeluaran.edit', compact('pengeluaran', 'jenis'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        if ($this->validator->fails()) :
            return response()->json($this->validator->errors(), 422);
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
