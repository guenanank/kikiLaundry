@extends('layout')
@section('title', 'Karyawan')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <h2>Karyawan <small>Master data karyawan.</small></h2>
	        <a href="{{ action('KaryawanController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Tambah Karyawan Baru">
	            <i class="add-new-item zmdi zmdi-plus"></i>
	        </a>
	    </div>

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
		                    <td>{{ $bagian[$kry->bagian] }}</td>
		                    <td>{{ $kry->mulai_kerja }}</td>
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
@endsection

@push('scripts')
	{{ Html::script('js/jquery.dataTables.min.js') }}
@endpush