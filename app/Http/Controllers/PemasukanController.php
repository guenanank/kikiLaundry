<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use kikiLaundry\Pemasukan;
use kikiLaundry\Pelanggan;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    private $validator;
    private $jenis;
    private $cara_bayar;

    public function __construct(Request $request)
    {
        $jenis = Pemasukan::jenis();
        $jenis->pop();
        $this->jenis = $jenis->all();
        $this->cara_bayar = Pemasukan::cara_bayar()->toArray();

        if ($request->has('jumlah')) {
            $request->merge([
            'jumlah' => str_replace(',', null, $request->jumlah)
          ]);
        }

        $this->validator = Validator::make($request->all(), Pemasukan::rules()->toArray());
    }

    public function index()
    {
        $pemasukan = Pemasukan::with('pelanggan')->get();
        return view('pemasukan.index', compact('pemasukan'));
    }

    public function create()
    {
        $jenis = $this->jenis;
        $bayar = $this->cara_bayar;
        $pelanggan = Pelanggan::pluck('nama', 'id')->all();
        $nomer = Pemasukan::nomer();
        return view('pemasukan.create', compact('jenis', 'bayar', 'pelanggan', 'nomer'));
    }

    public function store(Request $request)
    {
        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $create = Pemasukan::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Pemasukan $pemasukan)
    {
        $jenis = $this->jenis;
        $bayar = $this->cara_bayar;
        $pelanggan = Pelanggan::pluck('nama', 'id')->all();
        return view('pemasukan.edit', compact('pemasukan', 'jenis', 'bayar', 'pelanggan'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $this->validator = Validator::make($request->all(), Pemasukan::rules([
            'nomer' => [
                'required',
                'string',
                'max:31',
                Rule::unique('pemasukan')->ignore($pemasukan->id)
            ]
        ])->toArray());

        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 422);
        }

        $update = $pemasukan->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $delete = $pemasukan->delete();
        return response()->json($delete, 200);
    }
}
