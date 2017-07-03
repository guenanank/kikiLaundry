@extends('layout')
@section('title', 'Pemasukan')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	    	<div class="row">
		    	<div class="col-sm-6">
		    		<h2>Pemasukan <small>Administrasi data pemasukan.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ action('PemasukanController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Pemasukan Baru">
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
		                    <th class="text-center">Nomer</th>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Jenis</th>
		                    <th class="text-center">Pelanggan</th>
		                    <th class="text-center">Pembayaran</th>
		                    <th class="text-center">Jumlah</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Nomer</th>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Jenis</th>
		                    <th class="text-center">Pelanggan</th>
		                    <th class="text-center">Pembayaran</th>
		                    <th class="text-center">Jumlah</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($pemasukan as $pmk)
		            		<tr>
		            			<td class="text-center"><strong class="c-blue">{{ $pmk->nomer }}</strong></td>
			                    <td class="text-center">{{ $pmk->tanggal }}</td>
			                    <td class="text-center">{{ $pmk->jenis }}</td>
			                    <td>{{ $pmk->pelanggan->nama or '~' }}</td>
			                    <td class="text-center">{{ $pmk->cara_bayar }}</td>
			                    <td class="text-right">Rp. {{ number_format($pmk->jumlah) }}</td>
			                    <td class="text-center">
			                    	@if($pmk->jenis == 'Cicilan Pelanggan')
			                    	<a href="{{ url('cetak/pemasukan/' . $pmk->id) }}" class="btn btn-icon btn-sm bgm-bluegray" title="Cetak Pemasukan {{ $pmk->nomer }}" data-toggle="tooltip" target="_blank">
			                    		<span class="zmdi zmdi-print"></span>
		                    		</a>&nbsp;
		                    		@endif

		                    		@if($pmk->jenis != 'Pembayaran Pelanggan')
			                    	<a href="{{ url('pemasukan/' . $pmk->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $pmk->nomer }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
		                    		@endif
		                    		
		                    		<a href="{{ url('pemasukan/' . $pmk->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $pmk->nomer }}" data-toggle="tooltip">
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