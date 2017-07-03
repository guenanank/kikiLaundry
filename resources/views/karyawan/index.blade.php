@extends('layout')
@section('title', 'Karyawan')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Karyawan <small>Master data karyawan.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
								<a href="#" class="btn btn-icon bgm-bluegray" data-toggle="modal" data-target="#absensi" data-placement="top" title="Absensi">
				            <i class="zmdi zmdi-assignment"></i>
				        </a>
		    			&nbsp;
				        <a href="{{ action('KaryawanController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="bottom" title="Tambah Karyawan Baru">
				            <i class="zmdi zmdi-plus"></i>
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
		                    <th class="text-center">Kontak</th>
		                    <th class="text-center">Bagian</th>
		                    <th class="text-center">Mulai Bekerja</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Nama</th>
		                    <th class="text-center">Kontak</th>
		                    <th class="text-center">Bagian</th>
		                    <th class="text-center">Mulai Bekerja</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($karyawan as $kry)
		            		<tr>
			                    <td>{{ $kry->nama }}</td>
			                    <td>{{ $kry->kontak }}</td>
			                    <td class="text-center">{{ $kry->bagian }}</td>
			                    <td class="text-center">{{ $kry->mulai_kerja }}</td>
			                    <td class="text-center">
			                    	<a href="{{ url('karyawan/' . $kry->id . '/edit') }}" class="btn btn-icon bgm-blue" title="Ubah {{ $kry->nama }}" data-toggle="tooltip">
			                    		<span class="zmdi zmdi-edit"></span>
		                    		</a>&nbsp;
		                    		<a href="{{ url('karyawan/' . $kry->id) }}" class="btn btn-icon bgm-red delete" title="Hapus {{ $kry->nama }}" data-toggle="tooltip">
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

	<div class="modal fade" id="absensi" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        	{{ Form::open(['route' => 'absen.find']) }}
	            <div class="modal-header">
	                <h4 class="modal-title">Absensi Karyawan</h4>
	            </div>
	            <div class="modal-body">
								<div class="clearfix">&nbsp;</div>
			        	<div class="row">
			            <div class="col-sm-offset-1 col-sm-10">
			                <div class="form-group fg-float">
			                    <div class="fg-line">
			                        {{ Form::text('tanggal', null, ['class' => 'form-control fg-input date-picker']) }}
			                        {{ Form::label('tanggal', 'Tanggal absensi', ['class' => 'fg-label']) }}
			                    </div>
			                    <small id="tanggal" class="help-block"></small>
			                </div>
			            </div>
			        	</div>

	            </div>
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-search-for"></i>&nbsp;Cari</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                    	<i class="zmdi zmdi-close"></i>&nbsp;Tutup</button>
	                </button>
	            </div>
	            {{ Form::close() }}
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
