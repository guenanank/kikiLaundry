@extends('layout')
@section('title', 'Pemasukan - Tambah Baru')

@section('content')
	<div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Tambah Pemasukan Baru <small>Administrasi data pemasukan.</small></h2>
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
	        {{ Form::open(['route' => 'pemasukan.store', 'class' => 'ajax_form'])}}

	        	<div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="form-group has-success">
                            <div class="fg-line">
                                {{ Form::label('nomer', 'No Pemasukan', ['class' => 'control-label']) }}
                                {{ Form::text('nomer', $nomer, ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                    </div>
                </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('tanggal', null, ['class' => 'form-control fg-input date-picker']) }}
		                        {{ Form::label('tanggal', 'Tanggal Pemasukan', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="tanggal" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('jenis', $jenis, null, ['class' => 'form-control selectpicker', 'title' => 'Jenis pemasukan']) }}
		                    <small id="jenis" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row pelanggan">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('id_pelanggan', $pelanggan, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih pelanggan', 'data-live-search' => 'true']) }}
		                    <small id="pelanggan" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('jumlah', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('jumlah', 'Jumlah pemasukan', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="jumlah" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row cara_bayar">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('cara_bayar', $bayar, null, ['class' => 'form-control selectpicker', 'title' => 'Cara pembayaran']) }}
		                    <small id="cara_bayar" class="help-block"></small>
		                </div>
		            </div>
		        </div>

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

@push('scripts')
	<script type="text/javascript">

		$('select[name="jenis"').on('change', function() {
			if($(this).val() == 'penambahanBiaya') {
                $('div.pelanggan, div.cara_bayar').fadeOut();
            } else {
                $('div.pelanggan, div.cara_bayar').fadeIn();
            }
		});

	</script>
@endpush
