<?php

namespace kikiLaundry\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use kikiLaundry\Order;
use kikiLaundry\Pelanggan;

class BerandaController extends Controller
{
    public function index()
    {
        $pelanggan_terbaik = Pelanggan::select('id', 'nama', 'telepon', 'alamat')
        ->withCount(['order' => function($query) {
          $query->select(\DB::raw('count(id)'))
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year);
        }])->orderBy('order_count', 'desc')->take(10)->get();

        $order_belum_terkirim = Order::select('id', 'nomer', 'tanggal', 'id_pelanggan')
        ->with(['pelanggan' => function($query) {
          $query->select('id', 'nama');
        }])->whereNull('dikirim')
        ->orderBy('tanggal', 'asc')
        ->get();

        return view('beranda', compact('order_belum_terkirim', 'pelanggan_terbaik'));
    }
}
