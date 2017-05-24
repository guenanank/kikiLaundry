<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use kikiLaundry\Cuci;
use kikiLaundry\Jasa;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    private $cuci;

    public function __construct()
    {
        $this->cuci = Cuci::pluck('nama')->all();
    }

    public function index()
    {
        $jasa = Jasa::all();
        return view('jasa.index', compact('jasa'));
    }

    public function create()
    {
        $cuci = $this->cuci;
        return view('jasa.create', compact('cuci'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Jasa::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Jasa::create($request->all());
        return response()->json(['create' => $create], 200);
    }

    public function edit(Jasa $jasa)
    {
        $cuci = $this->cuci;
        return view('jasa.edit', compact('jasa', 'cuci'));
    }

    public function update(Request $request, Jasa $jasa)
    {
        $validator = Validator::make($request->all(), Jasa::rules());
        if ($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $jasa->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Jasa $jasa)
    {
        $delete = $jasa->delete();
        return response()->json($delete, 200);
    }
}
