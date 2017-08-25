@extends('layouts.cetak')
@section('title', 'Gaji Setrika / Gosok')
@section('name', 'Gaji Setrika / Gosok Periode ' . $hari->min() . ' s/d ' . $hari->max())

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
      <td class="text-center">{{ null }}</td>
    </tr>
  @endforeach
</table>
@endsection
