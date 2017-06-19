<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
// use Barryvdh\DomPDF\Facade as PDF;

use kikiLaundry\Harga;
use kikiLaundry\Pelanggan;
use kikiLaundry\Order;
use kikiLaundry\Order_lengkap as Detil;
use kikiLaundry\Barang;
use kikiLaundry\Cuci;
use kikiLaundry\Pemasukan;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $pelanggan;
    private $detil;

    protected $barang;
    protected $cuci;
    protected $pemasukan;

    public function __construct(Detil $detil, Pelanggan $pelanggan, Barang $barang, Cuci $cuci, Pemasukan $pemasukan)
    {
        $this->pelanggan = $pelanggan;
        $this->barang = $barang;
        $this->cuci = $cuci;
        $this->detil = $detil;
        $this->pemasukan = $pemasukan;
    }

    public function index()
    {
        $pelanggan = $this->pelanggan->pluck('nama', 'id')->all();
        $order = Order::with('detil', 'pelanggan')->get();
        return view('order.index', compact('order', 'pelanggan'));
    }

    public function bill(Request $request)
    {
        $data = $request->all();
        $pdf = PDF::loadView('order.bill', ['data' => $data]);
        return $pdf->setPaper([0, 0, 609.449, 765.354], 'portrait')->stream();
    }

    public function payment($id)
    {
        $pembayaran = $this->pemasukan->cara_bayar();
        array_shift($pembayaran);
        $order = Order::findOrFail($id);
        return view('order.payment', compact('order', 'pembayaran'));
    }

    public function paid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pembayaran' => 'required|max:15',
            'tanggal_pembayaran' => 'required|date:Y-m-d',
            'keterangan' => 'string|nullable'
        ]);

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $order = Order::findOrFail($id);
        $update = $order->update($request->all());
        return response()->json(['update' => $update], 200);
    } 

    public function create()
    {
        $nomer = Order::nomer_urut();
        $pelanggan = $this->pelanggan->pluck('nama', 'id')->all();
        return view('order.create', compact('nomer', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'jumlah_tunai' => is_null($request->jumlah_tunai) ? 0 : str_replace(',', null, $request->jumlah_tunai),
            'jumlah_cicil' => is_null($request->jumlah_cicil) ? 0 : str_replace(',', null, $request->jumlah_cicil)
        ]);

        $validator = Validator::make($request->all(), Order::rules());
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $create = Order::create($request->all());
        if($create) :
            foreach($request->order_lengkap as $ol) :
                $ol['id_order'] = $create->id;
                $this->detil->create($ol);
            endforeach;
            return response()->json($create, 200);
        endif;
    }

    public function show($id)
    {
        $barang = $this->barang->pluck('nama', 'id')->all();
        $cuci = $this->cuci->pluck('nama', 'id')->all();
        $order = Order::with('detil', 'pelanggan')->findOrFail($id);
        return view('order.show', compact('order', 'barang', 'cuci'));
    }

    public function print_po(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dikirim' => 'required|date:Y-m-d'
        ]);

        $order = Order::with('pelanggan', 'detil')->findOrFail($id);

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $order->update($request->all());
        if($update) :
            if(is_null($request->detil)) :
                $detil = $order->detil;
            else :
                $barang = [];
                $cuci = [];
                foreach ($request->detil as $detil) :
                    list($id_barang, $id_cuci) = explode(',', $detil);
                    $barang[] = $id_barang;
                    $cuci[] = $id_cuci;
                endforeach;
                $detil = $order->detil->whereIn('id_barang', $barang)->whereIn('id_cuci', $cuci)->all();
            endif;

            dd($detil);
            // return response()->json(['update' => $update], 200);
        endif;
    }

    public function edit(Request $request, Order $order)
    {
        $order = Order::with('detil', 'pelanggan')->findOrFail($order->id);
        $barang = $this->barang->pluck('nama', 'id')->all();
        $cuci = $this->cuci->pluck('nama', 'id')->all();
        return view('order.edit', compact('order', 'barang', 'cuci'));
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), Order::rules([
            'nomer' => [
                'required',
                'string',
                'max:31',
                Rule::unique('order')->ignore($order->id)
            ]
        ]));

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        dd($request->all());
        $update = $order->update($request->all());
        if($update) :
            $this->detil->where('id_order', $order->id)->delete();
            foreach($request->order_lengkap as $ol) :
                $ol['id_order'] = $order->id;
                $this->detil->create($ol);
            endforeach;
            return response()->json(['update' => $update], 200);
        endif;
    }

    public function destroy(Order $order)
    {
        $this->detil->where('id_order', $order->id)->delete();
        $delete = $order->delete();
        return response()->json($delete, 200);
    }
}
