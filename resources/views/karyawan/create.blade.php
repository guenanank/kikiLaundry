@extends('layout') @section('title', 'Karyawan - Tambah Baru') @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Tambah Karyawan Baru <small>Master data karyawan.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('KaryawanController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
	            <i class="zmdi zmdi-arrow-left"></i>
		        </a>
				</div>
			</div>
		</div>
	</div>
	<br />
	<div class="card-body card-padding">
		{{ Form::open(['route' => 'karyawan.store', 'class' => 'ajax_form'])}}
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('nama', null, ['class' => 'form-control fg-input']) }} {{ Form::label('nama', 'Nama Karyawan', ['class' => 'fg-label']) }}
					</div>
					<small id="nama" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('kontak', null, ['class' => 'form-control fg-input']) }} {{ Form::label('kontak', 'Kontak Karyawan', ['class' => 'fg-label']) }}
					</div>
					<small id="kontak" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group">
					{{ Form::select('bagian', $bagian, null, ['class' => 'form-control selectpicker', 'title' => 'Bagian karyawan', 'data-live-search' => true]) }}
					<small id="bagian" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('mulai_kerja', null, ['class' => 'form-control fg-input date-picker']) }} {{ Form::label('mulai_kerja', 'Tanggal Mulai Bekerja', ['class' => 'fg-label']) }}
					</div>
					<small id="mulai_kerja" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('gaji_harian', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('gaji_harian', 'Gaji Harian Karyawan', ['class' => 'fg-label']) }}
					</div>
					<small id="gaji_harian" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('gaji_lemburan', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('gaji_lemburan', 'Gaji Lemburan Karyawan', ['class' => 'fg-label']) }}
					</div>
					<small id="gaji_lemburan" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('gaji_bulanan', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('gaji_bulanan', 'Gaji Bulanan Karyawan', ['class' => 'fg-label']) }}
					</div>
					<small id="gaji_bulanan" class="help-block"></small>
				</div>
			</div>
		</div>

		@include('layouts.form_button') {{ Form::close() }}
	</div>
</div>
@endsection
