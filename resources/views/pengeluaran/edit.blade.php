@extends('layout') @section('title', 'Pengeluaran - Ubah') @section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-6">
        <h2>Ubah Pengeluaran <small>Administrasi data pengeluaran.</small></h2>
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
    {{ Form::model($pengeluaran, ['route' => ['pengeluaran.update', $pengeluaran->id], 'method' =>'patch', 'class' => 'ajax_form']) }}

    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group has-success">
          <div class="fg-line">
            {{ Form::label('tanggal', 'Tanggal Pengeluaran', ['class' => 'control-label']) }} {{ Form::text('_tanggal', $pengeluaran->tanggal, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('tanggal') }}
          </div>
          <small id="tanggal" class="help-block"></small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group has-success">
          <div class="fg-line">
            {{ Form::label('jenis', 'Jenis pengeluaran', ['class' => 'control-label']) }} {{ Form::text('_jenis', $pengeluaran->jenis, ['class' => 'form-control', 'disabled']) }} {{ Form::hidden('jenis', camel_case($pengeluaran->jenis)) }}
          </div>
        </div>
      </div>
    </div>

    <br />
    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::text('jumlah', number_format($pengeluaran->jumlah), ['class' => 'form-control fg-input money']) }} {{ Form::label('jumlah', 'Jumlah pengeluaran', ['class' => 'fg-label']) }}
          </div>
          <small id="jumlah" class="help-block"></small>
        </div>
      </div>
    </div>

    <div class="row keterangan">
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
