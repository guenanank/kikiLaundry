@extends('layout')
@section('title', 'Harga')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Harga <small>Master data harga pelanggan <strong>({{ $pelanggan->nama }})</strong>.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
		    			<a href="{{ action('PelangganController@index') }}" class="btn btn-icon bgm-orange" data-toggle="tooltip" data-placement="top" title="Kembali">
				            <i class="add-new-item zmdi zmdi-arrow-left"></i>
				        </a>
				        &nbsp;
				        <a href="{{ url('harga/' . $pelanggan->id . '/create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Harga Baru">
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
		                    <th class="text-center">Barang</th>
		                    <th class="text-center">Cuci</th>
		                    <th class="text-center">Tunai</th>
		                    <th class="text-center">Cicil</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Barang</th>
		                    <th class="text-center">Cuci</th>
		                    <th class="text-center">Tunai</th>
		                    <th class="text-center">Cicil</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($harga as $hrg)
		            		<tr>
			                    <td>{{ $hrg->barang->nama }}</td>
			                    <td>{{ $hrg->cuci->nama }}</td>
			                    <td class="text-right">Rp. {{ $hrg->tunai }}</td>
			                    <td class="text-right">Rp. {{ $hrg->cicil }}</td>
			                    <td class="text-center">
			                    	<a href="{{ url('harga/' . $hrg->id_pelanggan . '/' . $hrg->barang->id . '/' . $hrg->cuci->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $hrg->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
		                    		<a href="{{ url('harga/' . $hrg->id_pelanggan . '/' . $hrg->barang->id . '/' . $hrg->cuci->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $hrg->nama }}" data-toggle="tooltip">
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