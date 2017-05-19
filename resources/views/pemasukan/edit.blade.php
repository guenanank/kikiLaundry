@extends('layout')
@section('title', 'Pemasukan - Ubah')

@section('content')
    <div class="card">
	    <div class="card-header">
	        <h2>Ubah Pemasukan <small>Administrasi data pemasukan.</small></h2>
	        <a href="{{ action('PemasukanController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
	            <i class="zmdi zmdi-arrow-left"></i>
	        </a>
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($pemasukan, ['route' => ['pemasukan.update', $pemasukan->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
	        
	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::text('_tanggal', $pemasukan->tanggal, ['class' => 'form-control fg-input input-mask', 'data-mask' => '0000-00-00', 'disabled' => true]) }}
	                        {{ Form::hidden('tanggal') }}
	                        {{ Form::label('tanggal', 'Tanggal Pemasukan', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="tanggal" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group">
	                    {{ Form::select('jenis_', $jenis, $pemasukan->jenis, ['class' => 'form-control selectpicker', 'title' => 'Jenis pemasukan', 'disabled' => true]) }}
	                    {{ Form::hidden('jenis') }}
	                    <small id="jenis" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row pelanggan">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group">
	                    {{ Form::select('id_pelanggan_', $pelanggan, $pemasukan->id_pelanggan, ['class' => 'form-control selectpicker', 'title' => 'Pilih pelanggan', 'data-live-search' => true, 'disabled' => true]) }}
	                    {{ Form::hidden('id_pelanggan') }}
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

	        <div class="row bayar">
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

@push('scripts')
	<script type="text/javascript">

		var jenis = $('select[name="jenis"');

		if(jenis.val() != null && jenis.val() == 'penambahanBiaya') {
			$('div.pelanggan, div.bayar').hide();
		} else {
			$('div.pelanggan, div.bayar').show();
		}

		console.log(jenis.val());

		jenis.on('change', function() {
			if($(this).val() == 'penambahanBiaya') {
                $('div.pelanggan, div.bayar').fadeOut();
            } else {
                $('div.pelanggan, div.bayar').fadeIn();
            }
		});

	</script>
@endpush