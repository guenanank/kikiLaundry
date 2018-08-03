@extends('cetak.template')
@section('title', 'Omzet')
@section('name', 'Omzet Order')

@section('content')
	<table border="1" style="font-size: small; width: 100%; height: 0; border-collapse: collapse;">
    <tr class="text-center">
			<th>No</th>
			<th>Tanggal</th>
			<th>No Order</th>
			<th>Barang</th>
			<th>Cuci/Jasa</th>
			<th>Jumlah</th>
			<th>Harga</th>
			<th>Subtotal</th>
		</tr>
    @if($omzet->isEmpty())
			<tr><td colspan="8" class="text-center">data kosong</td></tr>
		@else
      @foreach($omzet as $k => $t)
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
  </table>
@endsection
