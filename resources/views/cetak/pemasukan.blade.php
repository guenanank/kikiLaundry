@extends('cetak.template')
@section('title', 'Cetak Kwitansi Pembayaran')
@section('name', 'KWITANSI PEMBAYARAN')

@section('content')
	<br />
	<div style="margin-left: 10%">
		<div>Telah diterima pembayaran {{ $pemasukan->cara_bayar }} pada tanggal {{ $pemasukan->tanggal }} dengan : </div>
		<br />
		<table style="margin-left: 30%" width="100%">
			<tr>
				<td width="20%">Nomer</td>
				<td width="5%">:</td>
				<td width="75%"><strong>{{ $pemasukan->nomer }}</strong></td>
			</tr>
			<tr>
				<td>Atas Nama</td>
				<td>:</td>
				<td>{{ $pemasukan->pelanggan->nama }}</td>
			</tr>
			<tr>
				<td>Sejumlah</td>
				<td>:</td>
				<td>
					Rp. {{ number_format($pemasukan->jumlah) }}<br />
					(<em>{{ $pemasukan->terbilang }} Rupiah</em>)
				</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td>{{ $pemasukan->catatan or '~' }}</td>
			</tr>
		</table>
	</div>
@endsection

@push('footer')
	<br />
	<table class="text-center" width="100%">
    <tr>
      <td width="33%">
      	Yang Menerima<br /><br /><br />
      	(..............................)
    	</td>
      <td width="34%">&nbsp;</td>
      <td width="33%">
      	Hormat Kami<br /><br /><br />
      	Kiki Laundry
    	</td>
    </tr>
  </table>
@endpush
