@extends('layout')
@section('title', 'Pengeluaran')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Pengeluaran <small>Administrasi data pengeluaran.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ action('PengeluaranController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Pengeluaran Baru">
				            <i class="add-new-item zmdi zmdi-plus"></i>
				        </a>
		    		</div>
		    	</div>
		    </div>   
	    </div>

	    <div class="card-body card-padding">
		    <div class="table-responsive">
		        <table class="table table-hover table-condensed data_table">
		            <thead>
		                <tr>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Jenis</th>
		                    <th class="text-center">Jumlah</th>
		                    <th class="text-center">Keterangan</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Jenis</th>
		                    <th class="text-center">Jumlah</th>
		                    <th class="text-center">Keterangan</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($pengeluaran as $png)
		            		<tr>
			                    <td class="text-center">{{ $png->tanggal }}</td>
			                    <td class="text-center">{{ $jenis[$png->jenis] }}</td>
			                    <td class="text-right">Rp. {{ number_format($png->jumlah) }}</td>
			                    <td>{{ $png->keterangan }}</td>
			                    <td class="text-center">
			                    	<a href="{{ url('pengeluaran/' . $png->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $png->nomer }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
		                    		<a href="{{ url('pengeluaran/' . $png->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $png->nomer }}" data-toggle="tooltip">
		                    			<span class="zmdi zmdi-delete"></span>
		                    		</a>
			                    </td>
			                </tr>
		            	@endforeach
		            </tbody>
		        </table>
		    </div>
	    </div>
	</div>
@endsection

@push('scripts')
	{{ Html::script('js/jquery.dataTables.min.js') }}
	<script type="text/javascript">
		$('.data_table').DataTable();
	</script>
@endpush