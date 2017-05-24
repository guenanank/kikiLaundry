@extends('layout')
@section('title', 'Cuci - Ubah')

@section('content')
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
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($cuci, ['route' => ['cuci.update', $cuci->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }}
		                        {{ Form::label('nama', 'Nama Cuci', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="nama" class="help-block"></small>
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