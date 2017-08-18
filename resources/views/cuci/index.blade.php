@extends('layout') @section('title', 'Cuci') @push('styles') {{ Html::style('css/jquery.dataTables.min.css') }} @endpush @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Cuci <small>Master data cuci.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('JasaController@index') }}" class="btn btn-icon bgm-bluegray" data-toggle="tooltip" data-placement="top" title="Jasa">
				            <i class="add-new-item zmdi zmdi-washing-machine"></i>
				        </a> &nbsp;
					<a href="{{ action('CuciController@create') }}" class="btn btn-icon bgm-green" data-toggle="tooltip" data-placement="bottom" title="Tambah Cuci Baru">
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
					@foreach($cuci as $c)
					<tr>
						<td>{{ $c->nama }}</td>
						<td class="text-center">
							<a href="{{ url('cuci/' . $c->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $c->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
							<a href="{{ url('cuci/' . $c->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $c->nama }}" data-toggle="tooltip">
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
