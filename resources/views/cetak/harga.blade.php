@extends('cetak.template')
@section('title', 'Cetak Daftar Harga Pelanggan')
@section('name', 'DAFTAR HARGA ' . strtoupper($pelanggan->nama))

@section('content')
<table border="1" width="100%">
  <tr class="text-center">
    <th>Barang</th>
    <th>Cuci/Jasa</th>
    <th>Tunai</th>
    <th>Angsuran</th>
  </tr>
  @foreach($harga as $h)
    <tr>
      <td class="text-center">{{ $h->barang->nama }}</td>
      <td class="text-center">{{ $h->cuci->nama }}</td>
      <td class="text-right">Rp. {{ number_format($h->tunai) }}</td>
      <td class="text-right">Rp. {{ number_format($h->cicil) }}</td>
    </tr>
  @endforeach
</table>
@endsection
