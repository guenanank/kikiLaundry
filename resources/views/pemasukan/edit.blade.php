@extends('layout')
@section('title', 'Pemasukan - Ubah')

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Ubah Pemasukan <small>Administrasi data pemasukan.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ action('PemasukanController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
		    		</div>
		    	</div>
		    </div>   
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($pemasukan, ['route' => ['pemasukan.update', $pemasukan->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
	        
	        	<div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="form-group has-success">
                            <div class="fg-line">
                                {{ Form::label('nomer', 'No Pemasukan', ['class' => 'control-label']) }}
                                {{ Form::text('_nomer', $pemasukan->nomer, ['class' => 'form-control', 'disabled']) }}
                                {{ Form::hidden('nomer') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="form-group has-success">
                            <div class="fg-line">
                            	{{ Form::label('jenis', 'Jenis pemasukan', ['class' => 'control-label']) }}
                                {{ Form::text('_jenis', $pemasukan->jenis, ['class' => 'form-control', 'disabled']) }}
                                {{ Form::hidden('jenis', camel_case($pemasukan->jenis)) }}
                            </div>
                        </div>
                    </div>
                </div>

	        	<div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="form-group has-success">
                            <div class="fg-line">
                            	{{ Form::label('tanggal', 'Tanggal pemasukan', ['class' => 'control-label']) }}
                                {{ Form::text('_tanggal', $pemasukan->tanggal, ['class' => 'form-control', 'disabled']) }}
                                {{ Form::hidden('tanggal') }}
                            </div>
                        </div>
                    </div>
                </div>

                @if($pemasukan->jenis != 'Penambahan Biaya')
                	<div class="row">
	                    <div class="col-sm-offset-1 col-sm-10">
	                        <div class="form-group has-success">
	                            <div class="fg-line">
	                            	{{ Form::label('id_pelanggan', 'Nama pelanggan', ['class' => 'control-label']) }}
	                                {{ Form::text('_id_pelanggan', $pemasukan->pelanggan->nama, ['class' => 'form-control', 'disabled']) }}
	                                {{ Form::hidden('id_pelanggan') }}
	                            </div>
	                        </div>
	                    </div>
	                </div>
                @endif

                <br />
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('jumlah', number_format($pemasukan->jumlah), ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('jumlah', 'Jumlah pemasukan', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="jumlah" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row bayar">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('cara_bayar', $bayar, camel_case($pemasukan->cara_bayar), ['class' => 'form-control selectpicker', 'title' => 'Cara pembayaran']) }}
		                    <small id="cara_bayar" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <br />
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::textarea('catatan', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }}
		                        {{ Form::label('catatan', 'Catatan pemasukan', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="catatan" class="help-block"></small>
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