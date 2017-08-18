@extends('layout') @section('title', 'Barang') @push('styles') {{ Html::style('css/jquery.dataTables.min.css') }} @endpush @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Barang <small>Master data barang.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('BarangController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Barang Baru">
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
					@foreach($barang as $brg)
					<tr>
						<td>{{ $brg->nama }}</td>
						<td class="text-center">
							<a href="{{ url('barang/' . $brg->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $brg->nama }}" data-toggle="tooltip">
                		<span class="zmdi zmdi-edit"></span>
              		</a>&nbsp;
							<a href="{{ url('barang/' . $brg->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $brg->nama }}" data-toggle="tooltip">
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
