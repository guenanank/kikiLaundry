<?php

namespace kikiLaundry\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

use kikiLaundry\Harga;
use kikiLaundry\Order;
use kikiLaundry\Pemasukan;
use kikiLaundry\Pelanggan;

class CetakController extends Controller
{
    private $half_paper_size = [0, 0, 685.98, 396.85];

    public function harga($id)
    {
        $harga = Harga::with('pelanggan', 'barang', 'cuci')->where('id_pelanggan', $id)->get();
        $pelanggan = Pelanggan::findOrFail($id);
        $pdf = PDF::loadView('cetak.harga', compact('harga', 'pelanggan'));
        return $pdf->download('harga_' . snake_case($pelanggan->nama) . '.pdf');
    }

    public function pemasukan($id)
    {
        $pemasukan = Pemasukan::with('pelanggan')->findOrFail($id);
        $pemasukan->terbilang = self::terbilang($pemasukan->jumlah);
        $pdf = PDF::loadView('cetak.pemasukan', compact('pemasukan'));
        return $pdf->setPaper($this->half_paper_size, 'portrait')->download($pemasukan->nomer . '.pdf');
    }

    public function tagihan(Request $request)
    {
        $pelanggan = Pelanggan::findOrFail($request->id_pelanggan);
        $tagihan = Order::with('pelanggan', 'detil.barang', 'detil.cuci')
              ->where('id_pelanggan', $request->id_pelanggan)
              ->where('dicetak', true)->whereNull('pembayaran')
              ->whereBetween('dikirim', [$request->awal, $request->akhir])
              ->orderBy('tanggal', 'asc')->get();

        $bayar = sprintf('harga_%s', $request->has('bayar') ? $request->bayar : 'cicil');
        $jumlah = sprintf('jumlah_%s', $request->has('bayar') ? $request->bayar : 'cicil');
        $pdf = PDF::loadView('cetak.tagihan', compact('tagihan', 'pelanggan', 'bayar', 'jumlah'));
        return $pdf->stream('kontra_bon_' . snake_case($pelanggan->nama) . '.pdf');
    }

    public function omzet(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $omzet = Order::with('pelanggan', 'detil.barang', 'detil.cuci')
            ->where('dicetak', true)->whereNull('pembayaran')
            ->whereBetween('dikirim', [$awal, $akhir])
            ->orderBy('tanggal', 'asc')->get();


        $pdf = PDF::loadView('cetak.omzet', compact('omzet', 'awal', 'akhir'));
        return $pdf->stream('omzet-' . $awal . '-' . $akhir . '.pdf');
    }

    public function po(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'dikirim' => 'required|date:Y-m-d'
        ]);

        $order = Order::with('pelanggan', 'detil.barang', 'detil.cuci')->findOrFail($request->id);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $update = $order->update($request->all());
        if ($update) {
            if (is_null($request->detil)) {
                $orderLengkap = $order->detil;
            } else {
                $barang = [];
                $cuci = [];
                foreach ($request->detil as $detil) {
                    list($id_barang, $id_cuci) = explode(',', $detil);
                    $barang[] = $id_barang;
                    $cuci[] = $id_cuci;
                }
                $orderLengkap = $order->detil->whereIn('id_barang', $barang)->whereIn('id_cuci', $cuci)->all();
            }

            $pdf = PDF::loadView('cetak.po', compact('order', 'orderLengkap'));
            return $pdf->setPaper($this->half_paper_size, 'portrait')->download($order->nomer . '.pdf');
        }
    }

    public function terbilang($i = 0)
    {
        $arrsatuan = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'];
        $arrbelasan = ['Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'];
        if (empty($i)) {
            return;
        }

        if ($i <= 9) {
            $return = $arrsatuan[$i - 1];
        } elseif ($i <= 19) {
            $return = $arrbelasan[$i - 10];
        } elseif ($i <= 99) {
            $div = floor($i / 10);
            $mod = bcmod($i, 10);
            $return = $arrsatuan[$div - 1] . " Puluh " . $this->terbilang($mod);
        } elseif ($i <= 999) {
            $div = floor($i / 100);
            $mod = bcmod($i, 100);
            if ($div == 1) :
          $return = "Seratus " . $this->terbilang($mod); else :
          $return = $arrsatuan[$div - 1] . " Ratus " . $this->terbilang($mod);
            endif;
        } elseif ($i <= 999999) {
            $div = floor($i / 1000);
            $mod = bcmod($i, 1000);
            if ($div == 1) :
          $return = "Seribu " . $this->terbilang($mod); else :
          $return = $this->terbilang($div) . " Ribu " . $this->terbilang($mod);
            endif;
        } elseif ($i <= 999999999) {
            $div = floor($i / 1000000);
            $mod = bcmod($i, 1000000);
            $return = $this->terbilang($div) . " Juta " . $this->terbilang($mod);
        } elseif ($i <= 999999999999) {
            $div = floor($i / 1000000000);
            $mod = bcmod($i, 1000000000);
            $return = $this->terbilang($div) . " Miliar " . $this->terbilang($mod);
        } elseif ($i <= 999999999999999) {
            $div = floor($i / 1000000000000);
            $mod = bcmod($i, 1000000000000);
            $return = $this->terbilang($div) . " Triliun " . $this->terbilang($mod);
        }

        return trim($return);
    }
}
