@extends('layout') @section('title', 'Pengeluaran - Tambah Baru') @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Tambah Pengeluaran Baru <small>Administrasi data pengeluaran.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('PengeluaranController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="card-body card-padding">
		{{ Form::open(['route' => 'pengeluaran.store', 'class' => 'ajax_form'])}}

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('tanggal', null, ['class' => 'form-control fg-input date-picker']) }} {{ Form::label('tanggal', 'Tanggal Pengeluaran', ['class' => 'fg-label']) }}
					</div>
					<small id="tanggal" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group">
					{{ Form::select('jenis', $jenis, null, ['class' => 'form-control selectpicker', 'title' => 'Jenis pengeluaran']) }}
					<small id="jenis" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('jumlah', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('jumlah', 'Jumlah pengeluaran', ['class' => 'fg-label']) }}
					</div>
					<small id="jumlah" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::textarea('keterangan', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }} {{ Form::label('keterangan', 'Catatan pengeluaran', ['class' => 'fg-label']) }}
					</div>
					<small id="keterangan" class="help-block"></small>
				</div>
			</div>
		</div>

		@include('layouts.form_button') {{ Form::close() }}
	</div>
</div>
@endsection
