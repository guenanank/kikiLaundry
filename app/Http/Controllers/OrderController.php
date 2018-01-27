<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;

use kikiLaundry\Harga;
use kikiLaundry\Pelanggan;
use kikiLaundry\Order;
use kikiLaundry\Order_lengkap as Ol;
use kikiLaundry\Barang;
use kikiLaundry\Cuci;
use kikiLaundry\Pemasukan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::pluck('nama', 'id')->all();
        $order = Order::with('detil', 'pelanggan')->get();
        return view('order.index', compact('order', 'pelanggan'));
    }

    public function payment($id)
    {
        $pembayaran = Pemasukan::cara_bayar();
        $order = Order::findOrFail($id);
        return view('order.payment', compact('order', 'pembayaran'));
    }

    public function paid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pembayaran' => 'required|max:15',
            'tanggal_pembayaran' => 'required|date:Y-m-d',
            'catatan_pembayaran' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::findOrFail($id);
        $update = $order->update($request->all());
        if ($update) {
            $catatan = 'Pembayaran ' . Pemasukan::cara_bayar($request->pembayaran) . ' ' . strtoupper($order->pelanggan->nama) . ' untuk order dengan nomer ' . $order->nomer;
            Pemasukan::create([
            'nomer' => Pemasukan::nomer(),
            'jenis' => camel_case(Pemasukan::jenis()->pop()),
            'id_pelanggan' => $order->pelanggan->id,
            'tanggal' => $request->tanggal_pembayaran,
            'jumlah' => $request->jumlah_tunai,
            'cara_bayar' => $request->pembayaran,
            'catatan' => $catatan
          ]);
        }
        return response()->json(['update' => $update], 200);
    }

    public function create()
    {
        $nomer = Order::nomer_urut();
        $pelanggan = Pelanggan::pluck('nama', 'id')->all();
        return view('order.create', compact('nomer', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Order::rules()->toArray());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $create = Order::create($request->all());
        if ($create) {
            foreach ($request->order_lengkap as $ol) {
                $ol['id_order'] = $create->id;
                Ol::create($ol);
            }
            return response()->json($create, 200);
        }
    }

    public function show($id)
    {
        $barang = Barang::pluck('nama', 'id')->all();
        $cuci = Cuci::pluck('nama', 'id')->all();
        $order = Order::with('detil', 'pelanggan')->findOrFail($id);
        return view('order.show', compact('order', 'barang', 'cuci'));
    }

    public function edit(Request $request, Order $order)
    {
        $order = Order::with('detil', 'pelanggan')->findOrFail($order->id);
        $barang = Barang::pluck('nama', 'id')->all();
        $cuci = Cuci::pluck('nama', 'id')->all();
        return view('order.edit', compact('order', 'barang', 'cuci'));
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), Order::rules([
            'nomer' => [
                'required', 'string', 'max:31',
                Rule::unique('order')->ignore($order->id)
            ]
        ])->toArray());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $update = $order->update($request->all());
        if ($update) {
            Ol::where('id_order', $order->id)->delete();
            foreach ($request->order_lengkap as $ol) {
                $ol['id_order'] = $order->id;
                Ol::create($ol);
            }
            return response()->json(['update' => $update], 200);
        }
    }

    public function destroy(Order $order)
    {
        Ol::where('id_order', $order->id)->delete();
        $delete = $order->delete();
        return response()->json($delete, 200);
    }
}
