@extends('layouts.cetak')
@section('title', 'Gaji Karyawan Harian')
@section('name', 'Gaji Karyawan Harian')

@section('content')
<table border="1" width="100%" cellpadding="0" cellspacing="0">
  <tr class="text-center">
    <th rowspan="2">Nama</th>
    <th colspan="{{ $harian->pluck('tanggal')->unique()->count() }}">
      Periode {{ \Carbon\Carbon::createFromFormat('Y-m-d', $harian->pluck('tanggal')->unique()->min())->day }}
      {{ \Carbon\Carbon::createFromFormat('Y-m-d', $harian->pluck('tanggal')->unique()->min())->format('M') }}
      s/d {{ \Carbon\Carbon::createFromFormat('Y-m-d', $harian->pluck('tanggal')->unique()->max())->day }}
      {{ \Carbon\Carbon::createFromFormat('Y-m-d', $harian->pluck('tanggal')->unique()->max())->format('M') }}
      {{ \Carbon\Carbon::createFromFormat('Y-m-d', $harian->pluck('tanggal')->unique()->max())->format('Y') }}
    </th>
    <th rowspan="2">Total</th>
  </tr>
  <tr class="text-center">
    @foreach($harian->pluck('tanggal')->unique() as $tgl)
      <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $tgl)->day }}</td>
    @endforeach
  </tr>


  @foreach($karyawan as $kry)
    <tr>
      <td>{{ $kry->nama }}</td>
      @if(is_null($harian->groupBy('id_karyawan')->get($kry->id)))
        @foreach($harian->pluck('tanggal')->unique() as $tgl)
          <td class="text-center">x</td>
        @endforeach
      @else
        @foreach($harian->pluck('tanggal')->unique() as $tgl)
          <td class="text-center">
            {{ $harian->groupBy('id_karyawan')->get($kry->id)->where('tanggal', $tgl)->isEmpty() ? 'x' : 'y' }}
          </td>
        @endforeach
      @endif

      <td class="text-right">
        Rp. {{ number_format($harian->where('id_karyawan', $kry->id)->pluck('masuk')->count() * $kry->gaji_harian) }}
      </td>
    </tr>
  @endforeach
</table>
@endsection
