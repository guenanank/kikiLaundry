@extends('layouts.cetak')
@section('title', 'Gaji Minnequeen')
@section('name', 'Gaji Minnequeen ' . $hari->min() . ' s/d ' . $hari->max())

@section('content')
<table border="1" width="100%" cellpadding="0" cellspacing="0">
  <tr class="text-center">
    <th>Tanggal</th>
    <th>Barang Keluar</th>
    <th>Total</th>
  </tr>
  @foreach($hari as $h)
    <tr>
      <td class="text-center">{{ $h }}</td>
      <td class="text-center">
        @if($gaji->where('dikirim', $h)->isNotEmpty())
          {{ $gaji->where('dikirim', $h)->pluck('detil')->flatten()->sum('banyaknya') }}
        @else
          0
        @endif
      </td>
      <td class="text-right">
        @if($gaji->where('dikirim', $h)->isNotEmpty())
          Rp. {{ number_format($gaji->where('dikirim', $h)->pluck('detil')->flatten()->transform(function($item) use($ongkos) {
              return $item->banyaknya * $ongkos->get($item->id_barang)->ongkos;
          })->sum()) }}
        @else
          Rp. {{ number_format(0) }}
        @endif
      </td>
    </tr>
  @endforeach
  <tr>
    <td class="text-right">Total&nbsp;</td>
    <td class="text-center">{{ $gaji->whereIn('dikirim', $hari)->pluck('detil')->flatten()->sum('banyaknya') }}</td>
    <td class="text-right">Rp. {{ number_format($gaji->whereIn('dikirim', $hari)->pluck('detil')->flatten()->transform(function($item) use($ongkos) {
        return $item->banyaknya * $ongkos->get($item->id_barang)->ongkos;
    })->sum()) }}</td>
  </tr>
</table>
@endsection
