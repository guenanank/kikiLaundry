@extends('layout')
@section('title', 'Jasa - Ubah')

@section('content')
    <div class="card">
	    <div class="card-header">
	    	<div class="row">
		    	<div class="col-sm-6">
		    		<h2>Ubah Jasa <small>Master data jasa.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
				        <a href="{{ action('JasaController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
				            <i class="zmdi zmdi-arrow-left"></i>
				        </a>
		    		</div>
		    	</div>
		    </div>   
	    </div>
	    <br />
	    <div class="card-body card-padding">
	        {{ Form::model($jasa, ['route' => ['jasa.update', $jasa->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
	        	
		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('nama', null, ['class' => 'form-control fg-input']) }}
		                        {{ Form::label('nama', 'Nama Jasa', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="nama" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="checkbox">
		                    <label>
		                    	{{ Form::checkbox('tergantung_barang', true, (bool) $jasa->tergantung_barang) }}
		                        <i class="input-helper"></i> Ongkos jasa tergantung dari jenis barang
		                    </label>
		                </div>
		            </div>
		        </div>
		        <div class="clearfix">&nbsp;</div>
		        <div class="clearfix">&nbsp;</div>

		        <div class="row ongkos">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('ongkos', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('ongkos', 'Ongkos Jasa', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="ongkos" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row klaim">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('klaim', null, ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="klaim" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row barang">
		        	<div class="col-sm-offset-1 col-sm-10"><hr /></div>
		        </div>
		        <div class="clearfix">&nbsp;</div>

		        <div class="row barang">
		        	<div class="col-sm-offset-2 col-sm-9">
		        		<div class="row">
		                    <div class="col-sm-3">
		                        <div class="form-group">
				                    {{ Form::select('id_barang', $barang, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang', 'data-live-search' => 'true']) }}
				                    <small id="id_barang" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-3">
		                        <div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('ongkos', null, ['class' => 'form-control fg-input money']) }}
				                        {{ Form::label('ongkos', 'Ongkos Jasa', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="ongkos" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-3">
		                        <div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('klaim', null, ['class' => 'form-control fg-input money']) }}
				                        {{ Form::label('klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="klaim" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-3">
		                        <button class="btn bgm-gray btn-icon-text btn-sm" type="button" id="tambah">
				                    <i class="zmdi zmdi-shopping-cart-plus"></i> Tambah
				                </button>
		                    </div>
		                    <div class="clearfix">&nbsp;</div>
		                    <div class="row">
	        					<div class="col-sm-offset-1 col-sm-10">
					            	<div class="table-responsive">
					            		<table class="table table-striped" id="daftar">
						                	<thead>
							                    <tr>
							                        <th class="text-center">Nama</th>
							                        <th class="text-center">Ongkos</th>
							                        <th class="text-center">Klaim</th>
							                        <th class="text-center">&nbsp;</th>
							                    </tr>
						                    </thead>
						                    <tbody></tbody>
						                </table>
					            	</div>
			            		</div>
			            	</div>
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

		var price_format = function(number) {
            var regex = parseFloat(number, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
            return 'Rp. ' + regex.slice(0, -3);
        };

		// $('div.ongkos, div.klaim, div.barang').hide();
		$('input[name="tergantung_barang"]').change(function() {
		    if(this.checked) {
		    	$('div.ongkos, div.klaim').fadeOut();
		    	$('div.barang').fadeIn();
		    } else {
		    	$('div.ongkos, div.klaim').fadeIn();
		        $('div.barang').fadeOut();
		    }
		});

		if ($('input[name="tergantung_barang"]').is(':checked')) {
			$('div.ongkos, div.klaim').fadeOut();
	    	$('div.barang').fadeIn();
		} else {
			$('div.ongkos, div.klaim').fadeIn();
	        $('div.barang').fadeOut();
		}

		var data, i = 0;
		$('div.barang').on('click', 'button#tambah', function() {
			var obj = {};
            $(this).parents('div.barang').find(':input').each(function() {
    			var nama = $(this).attr('name');
            	if(typeof nama != 'undefined') {
	            	if($(this).val().length === 0) {
	            		$('#' + nama).parents('div.barang').find('div.form-group').addClass('has-warning');
	            		$('#' + nama).text('The ' + nama + ' field is required');
	            	} else {
	            		obj['barang'] = $('select[name="id_barang"]').find(':selected').text();
	            		obj[nama] = $(this).val();
	            	}
            	}
            });

            if($.isEmptyObject(obj) == false) 
            	data = $.makeArray(obj); // data.push(obj);

            if(data.length !== 0) {
            	$('div.form-group').removeClass('has-warning');
                $('small.help-block').text(null);
            }
            
        	tbody(data);
			$('select.selectpicker').selectpicker('val', []);
			$('input[name="ongkos"], input[name="klaim"]').val(null).blur();
		});

		var tbody = function(data) {
			var tbody;
			var hapus = '<button type="button" class="btn btn-sm bgm-red btn-icon hapus">';
			hapus += '<i class="zmdi zmdi-close"></i>';
			hapus += '</button>';

			$.each(data, function(k, v) {
				i += 1;
				tbody += '<tr>';
				tbody += '<td><input type="hidden" name="barang[' + i + '][id_barang]" value="' + v.id_barang + '" />' + v.barang + '</td>';
				tbody += '<td class="text-right">' + price_format(v.ongkos) + '<input type="hidden" name="barang[' + i + '][ongkos]" value="' + v.ongkos + '" /></td>';
				tbody += '<td class="text-right">' + price_format(v.klaim) + '<input type="hidden" name="barang[' + i + '][klaim]" value="' + v.klaim + '" /></td>';
				tbody += '<td class="text-right">' + hapus + '</td>';
				tbody += '</tr>';
				$('table#daftar tbody').append(tbody);
			});

		};

		$('table#daftar').on('click', '.hapus', function() {
			$(this).parents('tr').hide(function() {
				$(this).remove();
			});
		});

		

	</script>
@endpush