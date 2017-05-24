@extends('layout')
@section('title', 'Pelanggan')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Pelanggan <small>Master data pelanggan.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ action('PelangganController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Pelanggan Baru">
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
		                    <th class="text-center">Nama</th>
		                    <th class="text-center">Telepon</th>
		                    <th class="text-center">Alamat</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Nama</th>
		                    <th class="text-center">Telepon</th>
		                    <th class="text-center">Alamat</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($pelanggan as $plg)
		            		<tr>
			                    <td>{{ $plg->nama }}</td>
			                    <td>{{ $plg->telepon }}</td>
			                    <td>{{ $plg->alamat }}</td>
			                    <td class="text-center">
			                    	<a href="{{ url('harga/' . $plg->id) }}" class="btn btn-icon bgm-purple" title="Harga {{ $plg->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-shopping-cart"></span>
		                    		</a>&nbsp;
			                    	<a href="{{ url('pelanggan/' . $plg->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $plg->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
		                    		<a href="{{ url('pelanggan/' . $plg->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $plg->nama }}" data-toggle="tooltip">
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