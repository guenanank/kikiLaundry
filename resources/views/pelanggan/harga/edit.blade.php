@extends('layout')
@section('title', 'Harga - Ubah')

@section('content')
    <div class="card">
	    <div class="card-header">
	    	<div class="row">
		    	<div class="col-sm-6">
		    		<h2>Ubah Harga <small>Master data harga pelanggan <strong>({{ $pelanggan->nama }})</strong>.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ url('harga/' . $pelanggan->id) }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
		    		</div>
		    	</div>
		    </div>
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($harga, ['route' => ['harga.update', $harga->id_pelanggan, $harga->id_barang, $harga->id_jasa], 'method' =>'patch', 'class' => 'ajax_form']) }}
		        {{ Form::hidden('id_pelanggan', $harga->id_pelanggan) }}
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('id_barang', $barang, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang', 'data-live-search' => 'true']) }}
		                    <small id="id_barang" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('id_jasa', $jasa, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih jasa', 'data-live-search' => 'true']) }}
		                    <small id="id_jasa" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('tunai', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('tunai', 'Harga tunai', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="tunai" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('cicil', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('cicil', 'Harga cicil', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="cicil" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="clearfix">&nbsp;</div>
    			<hr />
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