@extends('layout') @section('title', 'Barang - Ubah') @section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-6">
        <h2>Ubah Barang <small>Master data barang.</small></h2>
      </div>
      <div class="col-sm-6">
        <div class="pull-right">
          <a href="{{ action('BarangController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
            <i class="zmdi zmdi-arrow-left"></i>
</a>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix">&nbsp;</div>
  <div class="card-body card-padding">
    {{ Form::model($barang, ['route' => ['barang.update', $barang->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }} {{ Form::label('nama', 'Nama Barang', ['class' => 'fg-label']) }}
          </div>
          <small id="nama" class="help-block"></small>
        </div>
      </div>
    </div>

    @include('layouts.form_button') {{ Form::close() }}
  </div>
</div>
@endsection
