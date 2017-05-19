@extends('layout')
@section('title', 'Pengeluaran')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <h2>Pengeluaran <small>Administrasi data pengeluaran.</small></h2>
	        <a href="{{ action('PengeluaranController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Pengeluaran Baru">
	            <i class="add-new-item zmdi zmdi-plus"></i>
	        </a>
	    </div>

	    <div class="table-responsive">
	        <table class="table table-hover table-condensed data_table">
	            <thead>
	                <tr>
	                    <th class="text-center">Tanggal</th>
	                    <th class="text-center">Nomer</th>
	                    <th class="text-center">Jenis</th>
	                    <th class="text-center">Jumlah</th>
	                    <th class="text-center">Keterangan</th>
	                    <th class="text-center">Kontrol</th>
	                </tr>
	            </thead>
	            <tfoot>
	                <tr>
	                    <th class="text-center">Tanggal</th>
	                    <th class="text-center">Nomer</th>
	                    <th class="text-center">Jenis</th>
	                    <th class="text-center">Jumlah</th>
	                    <th class="text-center">Keterangan</th>
	                    <th class="text-center">Kontrol</th>
	                </tr>
	            </tfoot>
	            <tbody>
	            	@foreach($pengeluaran as $png)
	            		<tr>
		                    <td  class="text-center">{{ $png->tanggal }}</td>
		                    <td class="text-center">{{ $png->nomer }}</td>
		                    <td class="text-center">{{ $jenis[$png->jenis] }}</td>
		                    <td class="text-right">Rp. {{ number_format($png->jumlah) }}</td>
		                    <td>{{ $pb[$png->keterangan] or $png->keterangan }}</td>
		                    <td class="text-center">
		                    	<a href="{{ url('pengeluaran/' . $png->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $png->tanggal }}" data-toggle="tooltip">
		                    		<span class="zmdi zmdi-edit"></span>
	                    		</a>&nbsp;
	                    		<a href="{{ url('pengeluaran/' . $png->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $png->tanggal }}" data-toggle="tooltip">
	                    			<span class="zmdi zmdi-delete"></span>
	                    		</a>
		                    </td>
		                </tr>
	            	@endforeach
	            </tbody>
	        </table>
	    </div>
	</div>
@endsection

@push('scripts')
	{{ Html::script('js/jquery.dataTables.min.js') }}
@endpush