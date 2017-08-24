@extends('layouts.cetak')
@section('title', 'Gaji Karyawan Harian')
@section('name', 'Gaji Karyawan Harian Periode ' . $hari->min() . ' s/d ' . $hari->max())

@section('content')
<table border="1" width="100%" cellpadding="0" cellspacing="0">
  <tr class="text-center">
    <th rowspan="2">Nama</th>
    <th colspan="{{ $hari->count() }}">Tanggal</th>
    <th rowspan="2">Total</th>
  </tr>
  <tr>
    @foreach($hari as $h)
      <td class="text-center">{{ $h }}</td>
    @endforeach
  </tr>
  {{--*/ $total = 0 /*--}}
  <?php $total = 0 ?>
  @foreach($gaji as $karyawan)
    <tr>
      <td>{{ $karyawan->nama }}</td>
      @foreach($hari as $h)
        <td class="text-center">{{ $karyawan->absen->where('tanggal', $h)->isNotEmpty() ? 'y' : 'x' }}</td>
      @endforeach
      <td class="text-right">
        @unless($karyawan->absen->isEmpty())
          Rp. {{ number_format($karyawan->absen->pluck('gaji')->sum()) }}
        @endunless
      </td>
    </tr>
    <?php $total += $karyawan->absen->pluck('gaji')->sum() ?>
  @endforeach
  <tr>
    <td  class="text-right" colspan="{{ $hari->count() + 1 }}">Total&nbsp;</td>
    <td class="text-right">Rp. {{ number_format($total) }}</td>
  </tr>
</table>
@endsection
