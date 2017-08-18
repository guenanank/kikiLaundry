@extends('layout') @section('title', 'Order - Ubah') @section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-sm-6">
				<h2>Ubah Order <small>Form transaksi order.</small></h2>
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
		{{ Form::model($order, ['route' => ['order.update', $order->id], 'method' =>'patch', 'class' => 'ajax_form']) }}

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group has-success">
					<div class="fg-line">
						{{ Form::label('nomer', 'Nomer Order', ['class' => 'control-label']) }} {{ Form::text('_nomer', $order->nomer, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('nomer', null) }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group has-success">
					<div class="fg-line">
						{{ Form::label('tanggal', 'Tanggal Order', ['class' => 'control-label']) }} {{ Form::text('_tanggal', $order->tanggal, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('tanggal', null) }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<div class="form-group has-success">
					<div class="fg-line">
						{{ Form::label('id_pelanggan', 'Nama pelanggan', ['class' => 'control-label']) }} {{ Form::text('_pelanggan', $order->pelanggan->nama, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('id_pelanggan', null) }}
					</div>
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
									<strong class="text-primary"><span class="jumlah_tunai">Rp. {{ number_format($order->jumlah_tunai) }}</span></strong>
									<input type="hidden" name="jumlah_tunai" value="{{ $order->jumlah_tunai }}" />
								</td>
								<td class="text-right">
									<strong class="text-primary"><span class="jumlah_cicil">Rp. {{ number_format($order->jumlah_cicil) }}</span></strong>
									<input type="hidden" name="jumlah_cicil" value="{{ $order->jumlah_cicil }}" />
								</td>
								<td>&nbsp;</td>
							</tr>
						</tfoot>
						<tbody>
							@foreach($order->detil as $i => $dtl)
							<tr>
								<td>
									{{ $barang[$dtl->id_barang] }}
									<input type="hidden" name="order_lengkap[{{ $i + 1 }}][id_barang]" value="{{ $dtl->id_barang }}" />
								</td>
								<td>
									{{ $cuci[$dtl->id_cuci] }}
									<input type="hidden" name="order_lengkap[{{ $i + 1 }}][id_cuci]" value="{{ $dtl->id_cuci }}" />
								</td>
								<td class="text-center">
									{{ $dtl->banyaknya }}
									<input type="hidden" name="order_lengkap[{{ $i + 1 }}][banyaknya]" value="{{ $dtl->banyaknya }}" />
								</td>
								<td class="text-right">
									Rp. {{ number_format($dtl->banyaknya * $dtl->harga_tunai) }}
									<input type="hidden" name="order_lengkap[{{ $i + 1 }}][harga_tunai]" value="{{ $dtl->harga_tunai }}" />
								</td>
								<td class="text-right">
									Rp. {{ number_format($dtl->banyaknya * $dtl->harga_cicil) }}
									<input type="hidden" name="order_lengkap[{{ $i + 1 }}][harga_cicil]" value="{{ $dtl->harga_cicil }}" />
								</td>
								<td>
									<button type="button" class="btn btn-sm bgm-red btn-icon hapus" data-tunai="{{ $dtl->banyaknya * $dtl->harga_tunai }}" data-cicil="{{ $dtl->banyaknya * $dtl->harga_cicil }}">
													<i class="zmdi zmdi-close"></i>
												</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		@include('layouts.form_button') {{ Form::close() }}
	</div>
</div>
@endsection @push('scripts') {{ Html::script('js/order.js') }} @endpush
