@extends('layout')
@section('title', 'Order - Tambah Baru')

@section('content')
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
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::open(['route' => 'order.store', 'class' => 'ajax_form'])}}

	        	<div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float has-success">
		                    <div class="fg-line">
		                        {{ Form::text('nomer_', $nomer, ['class' => 'form-control fg-input', 'disabled' => true]) }}
		                        {{ Form::hidden('nomer', $nomer) }}
		                        {{ Form::label('nomer', 'Nomer Order', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="nomer" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('tanggal', null, ['class' => 'form-control fg-input date-picker']) }}
		                        {{ Form::label('tanggal', 'Tanggal Order', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="tanggal" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('id_pelanggan', $pelanggan, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih pelanggan', 'data-live-search' => 'true']) }}
		                    <small id="pelanggan" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::textarea('catatan', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }}
		                        {{ Form::label('catatan', 'Catatan Order', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="catatan" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="clearfix">&nbsp;</div>
		        <div class="clearfix">&nbsp;</div>
		        <div class="row barang">
		        	<div class="col-sm-offset-1 col-sm-10"><hr /></div>
		        </div>
		        <div class="clearfix">&nbsp;</div>

		        <div class="row">
        			<div class="col-sm-offset-2 col-sm-9">
            			<div class="row">
	                        <div class="col-sm-3">
	                        	<div class="form-group">
				                    {{ Form::select('barang_', [], null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang']) }}
				                    <small id="barang_" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-3">
	                            <div class="form-group">
				                    {{ Form::select('jasa_', [], null, ['class' => 'form-control selectpicker', 'title' => 'Pilih jasa']) }}
				                    <small id="jasa_" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-3">
	                        	<div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('banyaknya_', null, ['class' => 'form-control fg-input']) }}
				                        {{ Form::label('banyaknya_', 'Banyaknya', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="tanggal" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-3">
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
			                <table class="table table-striped" id="daftar">
			                	<thead>
				                    <tr>
				                        <th class="text-center">Barang</th>
				                        <th class="text-center">Jasa</th>
				                        <th class="text-center">Banyaknya</th>
				                        <th class="text-center">Tunai</th>
				                        <th class="text-center">Angsuran</th>
				                        <th class="text-center">Subtotal Tunai</th>
				                        <th class="text-center">Subtotal Angsuran</th>
				                        <th class="text-center">&nbsp;</th>
				                    </tr>
			                    </thead>
			                    <tfoot>
			                    	<tr>
			                    		<th colspan="5" class="text-right">Total</th>
			                    		<th>
			                    			<strong id="jumlah_harga_tunai_teks" class="text-primary text-right"></strong>
			                    			<input type="hidden" name="jumlah_tunai" id="jumlah_harga_tunai" />
			                    		</th>
			                    		<th>
			                    			<strong id="jumlah_harga_cicil_teks" class="text-primary text-right"></strong>
			                    			<input type="hidden" name="jumlah_cicil" id="jumlah_harga_cicil" />
			                    		</th>
			                    	</tr>
			                    </tfoot>
			                    <tbody></tbody>
			                </table>
			            </div>
		            </div>
	            </div>

			    <div class="clearfix">&nbsp;</div>
			    <hr />

		        <br />
		        <div class="form-group">
		            <div class="col-sm-offset-1 col-sm-10">
		                <button class="btn btn-primary btn-icon-text btn-sm" type="submit">
		                    <i class="zmdi zmdi-check"></i> Simpan
		                </button>
		            </div>
		        </div>
		        <br />
	        {{ Form::close() }}
	    </div>
	</div>

@endsection

@push('scripts')
	{{ Html::script('js/order.js') }}
@endpush