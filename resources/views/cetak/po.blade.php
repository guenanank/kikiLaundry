@extends('cetak.template')
@section('title', 'Cetak Faktur Pengiriman')
@section('name', 'FAKTUR PENGIRIMAN')
@push('customer')
	<label>
		Jakarta<br />
    Kepada Yth. {{ $order->pelanggan->nama }}<br />
    {{ $order->pelanggan->alamat }}<br />
  </label>
@endpush

@section('content')
	<table border="0" width="100%">
    <tr>
      <td>No Order : {{ $order->nomer }}</td>
      <td>&nbsp;</td>
      <td><span class="pull-right">Tgl Kirim : {{ $order->dikirim }}</span></td>
    </tr>
  </table>
  <div class="">&nbsp;</div>
	<table class="text-center" border="1" width="100%">
		<tr>
			<th width="15%">Banyaknya</th>
			<th width="10%">Kurang</th>
			<th width="10%">Lebih</th>
			<th width="40%">Nama Barang</th>
			<th width="35%">Nama Cuci/Jasa</th>
		</tr>
		@foreach($orderLengkap as $d)
			<tr>
				<td>{{ $d->banyaknya }}</td>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<td>{{ $d->barang->nama }}</td>
				<td>{{ $d->cuci->nama }}</td>
			</tr>
		@endforeach
	</table>
@endsection
@push('footer')
	<br />
	<table class="text-center" width="100%">
    <tr>
      <td width="33%">
      	Diterima Oleh<br /><br /><br />
      	(..............................)
    	</td>
      <td width="34%">
      	Pengirim<br /><br /><br />
      	(..............................)
    	</td>
      <td width="33%">
      	Hormat Kami<br /><br /><br />
      	Kiki Laundry
    	</td>
    </tr>
  </table>
  <div class="">&nbsp;</div>
	<div class="">&nbsp;</div>
	<div style="border:1px solid; margin: 0 20%">
		<p style="font-size: small; margin: 1px; padding: 2px; text-align: center">Harap untuk mengecek kembali ketika barang datang, Kiki Laundry tidak bertanggung jawab atas barang yang sudah dikirim.</p>
	</div>
@endpush
