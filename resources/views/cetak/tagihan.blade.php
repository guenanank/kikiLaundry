
@extends('cetak.template')
@section('title', 'Cetak Nota Tagihan')
@section('name', 'NOTA BON TAGIHAN')

@push('customer')
	<label>
	    Kepada Yth. {{ $tagihan->pluck('pelanggan')->first()->nama }}<br />
	    {{ $tagihan->pluck('pelanggan')->first()->alamat }}<br />
	    Telp: {{ $tagihan->pluck('pelanggan')->first()->telepon }}
    </label>
@endpush

@section('content')
	<table width="100%" border="1" style="font-size: 12px">
		<thead>
			<tr class="text-center">
				<th>No</th>
				<th>Tanggal</th>
				<th>No Order</th>
				<th>Barang</th>
				<th>Cuci/Jasa</th>
				<th>Banyaknya</th>
				<th>Harga</th>
				<th>Subtotal</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tagihan as $k => $t)
				<tr class="text-center">
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ ++$k }}</td>
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->tanggal }}</td>
					<td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->nomer }}</td>
				</tr>
				@foreach($t->detil as $d)
					<tr>
						<td class="text-center">{{ $d->barang->nama }}</td>
						<td class="text-center">{{ $d->cuci->nama }}</td>
						<td class="text-center">{{ $d->banyaknya }}</td>
						<td class="text-right">{{ number_format($d->harga_cicil) }}</td>
						<td class="text-right">{{ number_format($d->harga_cicil * $d->banyaknya) }}</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7" class="text-right">Jumlah Total</th>
				<th class="text-right">Rp. {{ number_format($tagihan->sum('jumlah_cicil')) }}</th>
			</tr>
		</tfoot>
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