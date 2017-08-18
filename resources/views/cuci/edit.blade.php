@extends('layout') @section('title', 'Cuci - Ubah') @section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-6">
        <h2>Ubah Cuci <small>Master data cuci.</small></h2>
      </div>
      <div class="col-sm-6">
        <div class="pull-right">
          <a href="{{ action('CuciController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix">&nbsp;</div>
  <div class="card-body card-padding">
    {{ Form::model($cuci, ['route' => ['cuci.update', $cuci->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="form-group fg-float">
          <div class="fg-line">
            {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }} {{ Form::label('nama', 'Nama Cuci', ['class' => 'fg-label']) }}
          </div>
          <small id="nama" class="help-block"></small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-offset-1 col-sm-10">
        <p class="m-b-20 c-gray">Jenis Jasa</p>
        @foreach($jasa as $k => $v)
        <div class="checkbox m-b-15">
          <label>
									{{ Form::checkbox('jasa[]', $k, in_array($k, $cuci->cuci_jasa->pluck('id_jasa')->all()) ? true : false) }}
									<i class="input-helper"></i>{{ $v }}
								</label>
        </div>
        @endforeach
      </div>
    </div>

    @include('layouts.form_button') {{ Form::close() }}
  </div>
</div>
@endsection
