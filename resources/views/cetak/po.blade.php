
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
            <td><strong>No Order : {{ $order->nomer }}</strong></td>
            <td>&nbsp;</td>
            <td><strong class="pull-right">Tgl Kirim : {{ $order->dikirim }}</strong></td>
        </tr>
    </table>
    <div class="">&nbsp;</div>
	<table class="text-center" cellpadding="0" cellspacing="0" border="1" width="100%">
		<tr>
			<th width="15%">Banyaknya</th>
			<th width="40%">Nama Barang</th>
			<th width="40%">Nama Cuci/Jasa</th>
		</tr>
		@foreach($orderLengkap as $d)
			<tr>
				<td>{{ $d->banyaknya }}</td>
				<td>{{ $d->barang->nama }}</td>
				<td>{{ $d->cuci->nama }}</td>
			</tr>
		@endforeach
	</table>
@endsection
@push('footer')
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
		<small style="font-size: smaller">Catatan : Harap untuk mengecek kembali ketika barang datang, Kiki Laundry tidak bertanggung jawab atas barang yang sudah dikirim.</small>
@endpush
