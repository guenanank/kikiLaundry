<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Barryvdh\DomPDF\Facade as PDF;

use kikiLaundry\Harga;
use kikiLaundry\Pelanggan;
use kikiLaundry\Order;
use kikiLaundry\Order_lengkap as Detil;
use kikiLaundry\Barang;
use kikiLaundry\Jasa;
use kikiLaundry\Pemasukan;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $pelanggan;
    private $detil;

    protected $barang;
    protected $jasa;
    protected $pemasukan;

    public function __construct(Detil $detil, Pelanggan $pelanggan, Barang $barang, Jasa $jasa, Pemasukan $pemasukan)
    {
        $this->pelanggan = $pelanggan;
        $this->barang = $barang;
        $this->jasa = $jasa;
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

    public function paid($id)
    {
        $pembayaran = $this->pemasukan->cara_bayar();
        array_shift($pembayaran);
        $order = Order::findOrFail($id);
        return view('order.paid', compact('order', 'pembayaran'));
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
        $jasa = $this->jasa->pluck('nama', 'id')->all();
        $order = Order::with('detil', 'pelanggan')->findOrFail($id);
        return view('order.show', compact('order', 'barang', 'jasa'));
    }

    public function edit($order)
    {

    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'jumlah_tunai' => 'numeric',
            'pembayaran' => 'required|string|max:15',
            'tanggal_pembayaran' => 'required|date:Y-m-d',
            'keterangan' => 'string|nullable'
        ]);

        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $order->update($request->all());
        return response()->json(['update' => $update], 200);
    }

    public function destroy(Order $order)
    {
        $this->detil->where('id_order', $order->id)->delete();
        $delete = $order->delete();
        return response()->json($delete, 200);
    }
}
