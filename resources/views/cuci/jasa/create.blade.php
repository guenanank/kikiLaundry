@extends('layout') @section('title', 'Jasa - Tambah Baru') @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Tambah Jasa Baru <small>Master data jasa.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('JasaController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="card-body card-padding">
		{{ Form::open(['route' => 'jasa.store', 'class' => 'ajax_form'])}}
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('nama', null, ['class' => 'form-control fg-input']) }} {{ Form::label('nama', 'Nama Jasa', ['class' => 'fg-label']) }}
					</div>
					<small id="nama" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="checkbox">
					<label>
		                    	{{ Form::checkbox('tergantung_barang', true) }}
		                        <i class="input-helper"></i> Ongkos jasa tergantung dari jenis barang
		                    </label>
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>

		<div class="row ongkos">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('ongkos', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('ongkos', 'Ongkos Jasa', ['class' => 'fg-label']) }}
					</div>
					<small id="ongkos" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row klaim">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('klaim', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
					</div>
					<small id="klaim" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row open">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('open', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('open', 'Open Jasa', ['class' => 'fg-label']) }}
					</div>
					<small id="open" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row barang">
			<div class="col-sm-offset-1 col-sm-10">
				<hr />
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>

		<div class="row barang">
			<div class="col-sm-offset-2 col-sm-8">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							{{ Form::select('id_barang', $barang, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang', 'data-live-search' => 'true']) }}
							<small id="id_barang" class="help-block"></small>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group fg-float">
							<div class="fg-line">
								{{ Form::text('_ongkos', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('ongkos', 'Ongkos Jasa', ['class' => 'fg-label']) }}
							</div>
							<small id="ongkos" class="help-block"></small>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group fg-float">
							<div class="fg-line">
								{{ Form::text('_klaim', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
							</div>
							<small id="klaim" class="help-block"></small>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group fg-float">
							<div class="fg-line">
								{{ Form::text('_open', null, ['class' => 'form-control fg-input money']) }} {{ Form::label('open', 'Open Jasa', ['class' => 'fg-label']) }}
							</div>
							<small id="open" class="help-block"></small>
						</div>
					</div>

					<div class="col-sm-2">
						<button class="btn bgm-gray btn-icon-text btn-sm" type="button" id="tambah">
				                    <i class="zmdi zmdi-shopping-cart-plus"></i> Tambah
				                </button>
					</div>

					<div class="clearfix">&nbsp;</div>
					<div class="table-responsive">
						<table class="table table-striped" id="daftar">
							<thead>
								<tr>
									<th class="text-center">Nama</th>
									<th class="text-center">Ongkos</th>
									<th class="text-center">Klaim</th>
									<th class="text-center">Open</th>
									<th class="text-center">&nbsp;</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		@include('layouts.form_button') {{ Form::close() }}
	</div>
</div>
@endsection @push('scripts') {{ Html::script('js/jasa.js') }} @endpush
