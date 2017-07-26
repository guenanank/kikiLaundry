<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

use kikiLaundry\Harga;
use kikiLaundry\Order;
use kikiLaundry\Pemasukan;

class CetakController extends Controller
{
    public function harga($id)
    {
      $harga = Harga::with('pelanggan', 'barang', 'cuci')->where('id_pelanggan', $id)->get();
      $pelanggan = $harga->pluck('pelanggan')->unique()->first();
      $pdf = PDF::loadView('cetak.harga', compact('harga', 'pelanggan'));
      return $pdf->download();
    }

    public function pemasukan($id)
    {
        $pemasukan = Pemasukan::with('pelanggan')->findOrFail($id);
        $pdf = PDF::loadView('cetak.pemasukan', compact('pemasukan'));
        return $pdf->setPaper([0, 0, 685.98, 396.85], 'portrait')->stream();
    }

    public function tagihan(Request $request)
    {
        $tagihan = Order::with('pelanggan', 'detil.barang', 'detil.cuci')
        ->where('id_pelanggan', $request->id_pelanggan)
        ->where('dicetak', true)
        ->whereBetween('tanggal', [$request->awal, $request->akhir])
        ->whereNotNull('dikirim')->whereNull('pembayaran')
        ->orderBy('tanggal', 'asc')->get();

        $pdf = PDF::loadView('cetak.tagihan', compact('tagihan'));
        return $pdf->download();
    }

    public function po(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dikirim' => 'required|date:Y-m-d'
        ]);

        $order = Order::with('pelanggan', 'detil.barang', 'detil.cuci')->findOrFail($request->id);
        if($validator->fails()) :
            return response()->json($validator->errors(), 422);
        endif;

        $update = $order->update($request->all());
        if($update) :
            if(is_null($request->detil)) :
                $orderLengkap = $order->detil;
            else :
                $barang = [];
                $cuci = [];
                foreach ($request->detil as $detil) :
                    list($id_barang, $id_cuci) = explode(',', $detil);
                    $barang[] = $id_barang;
                    $cuci[] = $id_cuci;
                endforeach;
                $orderLengkap = $order->detil->whereIn('id_barang', $barang)->whereIn('id_cuci', $cuci)->all();
            endif;

            $pdf = PDF::loadView('cetak.po', compact('order', 'orderLengkap'));
            return $pdf->setPaper([0, 0, 685.98, 396.85], 'portrait')->download();
        endif;
    }

    public function terbilang($i = 0)
    {
        $arrsatuan = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'];
        $arrbelasan = ['Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'];
        if (empty($i))
            return;

        if ($i <= 9) {
            $return = $arrsatuan[$i - 1];
        } else if ($i <= 19) {
            $return = $arrbelasan[$i - 10];
        } else if ($i <= 99) {
            $div = floor($i / 10);
            $mod = bcmod($i, 10);
            $return = $arrsatuan[$div - 1] . " Puluh " . $this->terbilang($mod);
        } else if ($i <= 999) {
            $div = floor($i / 100);
            $mod = bcmod($i, 100);
            if ($div == 1) {
                $return = "Seratus " . $this->terbilang($mod);
            } else {
                $return = $arrsatuan[$div - 1] . " Ratus " . $this->terbilang($mod);
            }
        } else if ($i <= 999999) {
            $div = floor($i / 1000);
            $mod = bcmod($i, 1000);
            if ($div == 1) {
                $return = "Seribu " . $this->terbilang($mod);
            } else {
                $return = $this->terbilang($div) . " Ribu " . $this->terbilang($mod);
            }
        } else if ($i <= 999999999) {
            $div = floor($i / 1000000);
            $mod = bcmod($i, 1000000);
            $return = $this->terbilang($div) . " Juta " . $this->terbilang($mod);
        } else if ($i <= 999999999999) {
            $div = floor($i / 1000000000);
            $mod = bcmod($i, 1000000000);
            $return = $this->terbilang($div) . " Miliar " . $this->terbilang($mod);
        } else if ($i <= 999999999999999) {
            $div = floor($i / 1000000000000);
            $mod = bcmod($i, 1000000000000);
            $return = $this->terbilang($div) . " Triliun " . $this->terbilang($mod);
        }

        return trim($return);
    }
}
