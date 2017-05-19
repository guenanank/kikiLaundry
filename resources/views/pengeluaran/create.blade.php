@extends('layout')
@section('title', 'Pengeluaran - Tambah Baru')

@section('content')
	<div class="card">
	    <div class="card-header">
	        <h2>Tambah Pengeluaran Baru <small>Administrasi data pengeluaran.</small></h2>
	        <a href="{{ action('PengeluaranController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
	            <i class="zmdi zmdi-arrow-left"></i>
	        </a>
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::open(['route' => 'pengeluaran.store', 'class' => 'ajax_form'])}}

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::text('nomer_', $nomer, ['class' => 'form-control fg-input', 'disabled' => true]) }}
	                        {{ Form::hidden('nomer', $nomer) }}
	                        {{ Form::label('nomer', 'Nomer Pengeluaran', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="nomer" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group fg-float">
	                    <div class="fg-line">
	                        {{ Form::text('tanggal', null, ['class' => 'form-control fg-input input-mask', 'data-mask' => '0000-00-00']) }}
	                        {{ Form::label('tanggal', 'Tanggal Pengeluaran', ['class' => 'fg-label']) }}
	                    </div>
	                    <small id="tanggal" class="help-block"></small>
	                </div>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group">
	                    {{ Form::select('jenis', $jenis, null, ['class' => 'form-control selectpicker', 'title' => 'Jenis pengeluaran']) }}
	                    <small id="jenis" class="help-block"></small>
	                </div>
	            </div>
	        </div>

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

	        <div class="row pb">
	            <div class="col-sm-offset-1 col-sm-10">
	                <div class="form-group">
	                    {{ Form::select('keterangan', $pb, null, ['class' => 'form-control selectpicker', 'title' => 'Pengeluaran Bulanan']) }}
	                    <small id="jenis" class="help-block"></small>
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

		$('div.pb').hide();
        $('select[name="jenis"]').on('change', function() {
            var type = $(this).val();
            if($(this).val() === 'bulan') {
            	
                $('div.keterangan').find('textarea').attr('disabled', true);
                $('div.keterangan').hide();
                
                $('div.pb').find('select').removeAttr('disabled');
                $('div.pb').slideDown();
            } else {
            	
                $('div.keterangan').find('textarea').removeAttr('disabled');
                $('div.keterangan').slideDown();
                
                $('div.pb').find('select').attr('disabled', true);
                $('div.pb').hide();
            }
        });

	</script>
@endpush
