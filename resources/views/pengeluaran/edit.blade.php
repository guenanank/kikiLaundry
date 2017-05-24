@extends('layout')
@section('title', 'Pengeluaran - Ubah')

@section('content')
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
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($pengeluaran, ['route' => ['pengeluaran.update', $pengeluaran->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
	        
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group has-success">
		                    <div class="fg-line">
		                        {{ Form::label('tanggal', 'Tanggal Pengeluaran', ['class' => 'control-label']) }}
		                        {{ Form::text('tanggal_', $pengeluaran->tanggal, ['class' => 'form-control', 'disabled']) }}
		                        {{ Form::hidden('tanggal', $pengeluaran->tanggal) }}
		                    </div>
		                    <small id="tanggal" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="form-group has-success">
                            <div class="fg-line">
                            	{{ Form::label('jenis', 'Jenis pengeluaran', ['class' => 'control-label']) }}
                                {{ Form::text('jenis_', $jenis[$pengeluaran->jenis], ['class' => 'form-control', 'disabled']) }}
                                {{ Form::hidden('jenis', $pengeluaran->jenis) }}
                            </div>
                        </div>
                    </div>
                </div>

                <br />
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('jumlah', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('jumlah', 'Jumlah pengeluaran', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="jumlah" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row keterangan">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::textarea('keterangan', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }}
		                        {{ Form::label('keterangan', 'Catatan pengeluaran', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="keterangan" class="help-block"></small>
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