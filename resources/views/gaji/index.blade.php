@extends('layout')
@section('title', 'Gaji - Perhitungan gaji karyawan')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-6">
        <h2>Gaji <small>Perhitungan gaji karyawan.</small></h2>
      </div>
    </div>
    </div>
  <div class="clearfix">&nbsp;</div>
  <div class="card-body card-padding">
    {{ Form::open(['route' => 'gaji.show'])}}
      <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="form-group">
            {{ Form::select('bagian', $bagian, null, ['class' => 'form-control selectpicker', 'title' => 'Bagian karyawan']) }}
            <small id="bagian" class="help-block"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="form-group fg-float">
            <div class="fg-line">
              {{ Form::text('awal', null, ['class' => 'form-control fg-input date-picker']) }}
              {{ Form::label('awal', 'Tanggal awal', ['class' => 'fg-label']) }}
            </div>
            <small id="awal" class="help-block"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="form-group fg-float">
            <div class="fg-line">
              {{ Form::text('akhir', null, ['class' => 'form-control fg-input date-picker']) }}
              {{ Form::label('akhir', 'Tanggal akhir', ['class' => 'fg-label']) }}
            </div>
            <small id="akhir" class="help-block"></small>
          </div>
        </div>
      </div>

      <div class="clearfix">&nbsp;</div>
      <hr />
      <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
          <button class="btn btn-primary btn-icon-text btn-sm" type="submit">
            <i class="zmdi zmdi-flag"></i> Hitung
          </button>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
    {{ Form::close() }}
  </div>
</div>
@endsection
