@extends('layout')
@section('title', 'Pelanggan - Ubah')

@section('content')
    <div class="card">
	    <div class="card-header">
	        <h2>Ubah Pelanggan <small>Master data pelanggan.</small></h2>
	        <a href="{{ action('PelangganController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
	            <i class="zmdi zmdi-arrow-left"></i>
	        </a>
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($pelanggan, ['route' => ['pelanggan.update', $pelanggan->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }}
	                        {{ Form::label('nama', 'Nama Pelanggan', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="nama" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::text('telepon', null, ['class' => 'form-control fg-input']) }}
	                        {{ Form::label('telepon', 'Kontak Pelanggan', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="telepon" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::textarea('alamat', null, ['class' => 'form-control fg-input']) }}
	                        {{ Form::label('alamat', 'Alamat Pelanggan', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="alamat" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <br />
	        <div class="form-group">
	            <div class="col-sm-offset-1 col-sm-10">
	                <button class="btn btn-primary btn-icon-text btn-sm waves-effect" type="submit">
	                    <i class="zmdi zmdi-check"></i> Simpan
	                </button>
	            </div>
	        </div>
	        <br />
	        {{ Form::close() }}
	    </div>
	</div>
@endsection