@extends('layout') @section('title', 'Jasa') @push('styles') {{ Html::style('css/jquery.dataTables.min.css') }} @endpush @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Jasa <small>Master data jasa.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('CuciController@index') }}" class="btn btn-icon bgm-orange" data-toggle="tooltip" data-placement="top" title="Kembali">
				            <i class="add-new-item zmdi zmdi-arrow-left"></i>
				        </a> &nbsp;
					<a href="{{ action('JasaController@create') }}" class="btn btn-icon bgm-green" data-toggle="tooltip" data-placement="bottom" title="Tambah Jasa Baru">
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
						<th class="text-center">Kontrol</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="text-center">Nama</th>
						<th class="text-center">Kontrol</th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($jasa as $js)
					<tr>
						<td>{{ $js->nama }}</td>
						<td class="text-center">
							<a href="{{ url('jasa/' . $js->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $js->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
							<a href="{{ url('jasa/' . $js->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $js->nama }}" data-toggle="tooltip">
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
@endsection @push('scripts') {{ Html::script('js/jquery.dataTables.min.js') }}
<script type="text/javascript">
	$('.data_table').DataTable();
</script>
@endpush
