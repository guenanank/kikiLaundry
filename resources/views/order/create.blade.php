@extends('layout') @section('title', 'Order - Tambah Baru') @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Tambah Order Baru <small>Form transaksi order.</small></h2>
			</div>
			<div class="col-sm-6">
				<div class="pull-right">
					<a href="{{ action('OrderController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="card-body card-padding">
		{{ Form::open(['route' => 'order.store', 'class' => 'ajax_form']) }}

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group has-success">
					<div class="fg-line">
						{{ Form::label('nomer', 'Nomer Order', ['class' => 'control-label']) }} {{ Form::text('_nomer', $nomer, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('nomer', $nomer) }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::text('tanggal', null, ['class' => 'form-control fg-input date-picker']) }} {{ Form::label('tanggal', 'Tanggal Order', ['class' => 'fg-label']) }}
					</div>
					<small id="tanggal" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group">
					{{ Form::select('id_pelanggan', $pelanggan, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih pelanggan', 'data-live-search' => 'true']) }}
					<small id="id_pelanggan" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group fg-float">
					<div class="fg-line">
						{{ Form::textarea('catatan', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }} {{ Form::label('catatan', 'Catatan Order', ['class' => 'fg-label']) }}
					</div>
					<small id="catatan" class="help-block"></small>
				</div>
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>

		<div class="row detil">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							{{ Form::select('_barang', [], null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang']) }}
							<small id="_barang" class="help-block"></small>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							{{ Form::select('_cuci', [], null, ['class' => 'form-control selectpicker', 'title' => 'Pilih jasa/cuci']) }}
							<small id="_cuci" class="help-block"></small>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group fg-float">
							<div class="fg-line">
								{{ Form::text('_banyaknya', null, ['class' => 'form-control fg-input']) }} {{ Form::label('_banyaknya', 'Banyaknya', ['class' => 'fg-label']) }}
							</div>
							<small id="_banyaknya" class="help-block"></small>
						</div>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn bgm-gray btn-icon-text btn-sm" id="tambah">
	                                <i class="zmdi zmdi-shopping-cart-plus"></i> Tambah
	                            </button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="daftar">
						<thead>
							<tr>
								<th>Barang</th>
								<th>Cuci</th>
								<th class="text-center">Banyaknya</th>
								<th class="text-right">Subtotal Tunai</th>
								<th class="text-right">Subtotal Angsuran</th>
								<th class="text-center">&nbsp;</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="3" class="text-right"><strong class="text-primary">Total</strong></td>
								<td class="text-right">
									<strong class="text-primary"><span class="jumlah_tunai"></span></strong>
									<input type="hidden" name="jumlah_tunai" />
								</td>
								<td class="text-right">
									<strong class="text-primary"><span class="jumlah_cicil"></span></strong>
									<input type="hidden" name="jumlah_cicil" />
								</td>
								<td>&nbsp;</td>
							</tr>
						</tfoot>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

		@include('layouts.form_button') {{ Form::close() }}
	</div>
</div>

@endsection @push('scripts') {{ Html::script('js/order.js') }} @endpush
