@extends('cetak.template')
@section('title', 'Cetak Daftar Harga Pelanggan')
@section('name', 'DAFTAR HARGA ' . strtoupper($pelanggan->nama))

@section('content')
<table class="text-center" cellpadding="0" cellspacing="0" border="1" width="100%">
  <tr>
    <th>Barang</th>
    <th>Cuci/Jasa</th>
    <th>Tunai</th>
    <th>Angsuran</th>
  </tr>
  @foreach($harga as $h)
    <tr>
      <td>{{ $h->barang->nama }}</td>
      <td>{{ $h->cuci->nama }}</td>
      <td>Rp. {{ number_format($h->tunai) }}</td>
      <td>Rp. {{ number_format($h->cicil) }}</td>
    </tr>
  @endforeach
</table>
@endsection
