
@extends('cetak.template')
@section('title', 'Cetak Nota Tagihan')
@section('name', 'NOTA BON TAGIHAN')

@push('customer')
	<label>
	  Kepada Yth. {{ $pelanggan->nama }}<br />
	  {{ $pelanggan->alamat }}
	</label>
@endpush

@section('content')
	<table border="1" style="font-size: small; width: 100%; height: 0; border-collapse: collapse;">
		<tr class="text-center">
			<th width="3%">No</th>
			<th width="10%">Tanggal</th>
			<th width="17%">No Order</th>
			<th width="23%">Barang</th>
			<th width="20%">Cuci/Jasa</th>
			<th width="7%">Jumlah</th>
			<th width="7%">Harga</th>
			<th width="13%">Subtotal</th>
		</tr>
		@if($tagihan->isEmpty())
			<tr><td colspan="8" class="text-center">data kosong</td></tr>
		@else
			@foreach($tagihan as $k => $t)
				<tr class="text-center" style="height: 0; border-spacing: 0; border-collapse: 0;">
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ ++$k }}</td>
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->dikirim }}</td>
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->nomer }}</td>
				</tr>
				@foreach($t->detil as $d)
					<tr style="height: 1; border-spacing: 1; border-collapse: 1;">
						<td class="text-center">{{ $d->barang->nama }}</td>
						<td class="text-center">{{ $d->cuci->nama }}</td>
						<td class="text-center">{{ $d->banyaknya }}</td>
						<td class="text-right">{{ number_format($d->{$bayar}) }}</td>
						<td class="text-right">{{ number_format($d->{$bayar} * $d->banyaknya) }}</td>
					</tr>
				@endforeach
			@endforeach
		@endif
		<tr>
			<th colspan="7" class="text-right">Jumlah Total   </th>
			<th class="text-right">Rp. {{ number_format($tagihan->sum($jumlah)) }}</th>
		</tr>
	</table>
@endsection

@push('footer')
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
