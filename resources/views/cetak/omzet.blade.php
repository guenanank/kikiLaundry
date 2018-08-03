@extends('cetak.template')
@section('title', 'Omzet')
@section('name', 'Omzet Order')

@section('content')
	<table border="1">
    <tr class="text-center">
			<th>No</th>
			<th>Tanggal</th>
			<th>No Order</th>
			<th>Barang</th>
			<th>Cuci/Jasa</th>
			<th>Jumlah</th>
			<th>Cicil</th>
			<th>Tunai</th>
		</tr>
    @if($omzet->isEmpty())
			<tr><td colspan="8" class="text-center">data kosong</td></tr>
		@else
      @foreach($omzet as $k => $t)
        <tr class="text-center">
          <td rowspan="{{ $t->detil->count() + 1 }}">{{ ++$k }}</td>
          <td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->dikirim }}</td>
          <td rowspan="{{ $t->detil->count() + 1 }}">{{ $t->nomer }}</td>
        </tr>
        @foreach($t->detil as $d)
          <tr>
            <td class="text-center">{{ $d->barang->nama }}</td>
            <td class="text-center">{{ $d->cuci->nama }}</td>
            <td class="text-center">{{ number_format($d->banyaknya) }}</td>
						<td class="text-right">{{ number_format($d->harga_cicil * $d->banyaknya) }}</td>
            <td class="text-right">{{ number_format($d->harga_tunai * $d->banyaknya) }}</td>
          </tr>
        @endforeach
      @endforeach
			<tr>
				<th class="text-center" colspan="5">Total</th>
				<th class="text-center">{{ number_format($omzet->pluck('detil')->flatten()->sum('banyaknya')) }}</th>
				<th class="text-right">{{ number_format($omzet->sum('jumlah_tunai')) }}</th>
				<th class="text-right">{{ number_format($omzet->sum('jumlah_cicil')) }}</th>
			</tr>
    @endif
  </table>
@endsection
