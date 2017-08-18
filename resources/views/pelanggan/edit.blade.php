@extends('layout') @section('title', 'Pelanggan - Ubah') @section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-6">
        <h2>Ubah Pelanggan <small>Master data pelanggan.</small></h2>
      </div>
      <div class="col-sm-6">
        <div class="pull-right">
          <a href="{{ action('PelangganController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
	            <i class="zmdi zmdi-arrow-left"></i>
		        </a>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix">&nbsp;</div>
  <div class="card-body card-padding">
    {{ Form::model($pelanggan, ['route' => ['pelanggan.update', $pelanggan->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }} {{ Form::label('nama', 'Nama Pelanggan', ['class' => 'fg-label']) }}
          </div>
          <small id="nama" class="help-block"></small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::text('telepon', null, ['class' => 'form-control fg-input']) }} {{ Form::label('telepon', 'Kontak Pelanggan', ['class' => 'fg-label']) }}
          </div>
          <small id="telepon" class="help-block"></small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::textarea('alamat', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }} {{ Form::label('alamat', 'Alamat Pelanggan', ['class' => 'fg-label']) }}
          </div>
          <small id="alamat" class="help-block"></small>
        </div>
      </div>
    </div>

    @include('layouts.form_button') {{ Form::close() }}
  </div>
</div>
@endsection
