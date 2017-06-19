@extends('layout')
@section('title', 'Order')

@push('styles')
	{{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
    <div class="card">
	    <div class="card-header">
	        <div class="row">
		    	<div class="col-sm-6">
		    		<h2>Order <small>Daftar transaksi order.</small></h2>
		    	</div>
		    	<div class="col-sm-6">
		    		<div class="pull-right">
		    			<a href="#" class="btn btn-icon bgm-pink" data-toggle="modal" data-target="#tagihan" data-placement="top" title="Tagihan">
				            <i class="add-new-item zmdi zmdi-money"></i>
				        </a>
				        &nbsp;
				        <a href="{{ action('OrderController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="bottom" title="Tambah Order Baru">
				            <i class="add-new-item zmdi zmdi-plus"></i>
				        </a>
		    		</div>
		    	</div>
		    </div>
	    </div>

	    <div class="card-body card-padding">
		    <div class="table-responsive">
		        <table class="table table-hover table-condensed data_table">
		            <thead>
		                <tr>
		                    <th class="text-center">Nomer</th>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Pelanggan</th>
		                    <th class="text-center">Tunai</th>
		                    <th class="text-center">Cicilan</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                    <th class="text-center">Nomer</th>
		                    <th class="text-center">Tanggal</th>
		                    <th class="text-center">Pelanggan</th>
		                    <th class="text-center">Tunai</th>
		                    <th class="text-center">Cicilan</th>
		                    <th class="text-center">Kontrol</th>
		                </tr>
		            </tfoot>
		            <tbody>
		            	@foreach($order as $ord)
		            		<tr class="{{ is_null($ord->dikirim) ? null : 'info' }}">
			                    <td class="text-center"><strong class="c-blue">{{ $ord->nomer }}</strong></td>
			                    <td class="text-center">{{ $ord->tanggal }}</td>
			                    <td>{{ $ord->pelanggan->nama }}</td>
			                    <td class="text-right">Rp. {{ number_format($ord->jumlah_tunai) }}</td>
			                    <td class="text-right">Rp. {{ number_format($ord->jumlah_cicil) }}</td>
			                    <td class="text-center">
			                    	<a href="{{ url('order/' . $ord->id) }}" class="btn btn-icon bgm-gray" title="Detil order nomer {{ $ord->nomer }}" data-toggle="tooltip" id="detil">
			                    		<span class="zmdi zmdi-search"></span>
		                    		</a>&nbsp;
		                    		@if(is_null($ord->pembayaran))
			                    	<a href="{{ url('order/' . $ord->id . '/payment') }}" class="btn btn-icon bgm-teal" title="Lunas order nomer {{ $ord->nomer }}" data-toggle="tooltip" data-placement="bottom" id="lunas">
			                    		<span class="zmdi zmdi-check"></span>
		                    		</a>&nbsp;
		                    		@endif
		                    		<a href="{{ url('order/' . $ord->id) }}" class="btn btn-icon bgm-red delete" title="Hapus order nomer {{ $ord->nomer }}" data-toggle="tooltip">
		                    			<span class="zmdi zmdi-delete"></span>
		                    		</a>
			                    </td>
			                </tr>
		            	@endforeach
		            </tbody>
		        </table>
		    </div>
	    </div>
	</div>

	<div class="modal fade" id="tagihan" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        	{{ Form::open(['route' => 'order.bill', 'target' => '_blank']) }}
	            <div class="modal-header">
	                <h4 class="modal-title">Tagihan Pelanggan</h4>
	            </div>
	            <div class="modal-body">
	            	<br />
            		<div class="row">
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
			                        {{ Form::text('awal', null, ['class' => 'form-control fg-input input-mask', 'data-mask' => '0000-00-00']) }}
			                        {{ Form::label('awal', 'Tanggal awal', ['class' => 'fg-label']) }}
			                    </div>
			                    <small id="tanggal" class="help-block"></small>
			                </div>
			            </div>
			        </div>

			        <div class="row">
			            <div class="col-sm-offset-1 col-sm-10">
			                <div class="form-group fg-float">
			                    <div class="fg-line">
			                        {{ Form::text('akhir', null, ['class' => 'form-control fg-input input-mask', 'data-mask' => '0000-00-00']) }}
			                        {{ Form::label('akhir', 'Tanggal akhir', ['class' => 'fg-label']) }}
			                    </div>
			                    <small id="tanggal" class="help-block"></small>
			                </div>
			            </div>
			        </div>
	                <br />
	            </div>
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-print"></i>&nbsp;Cetak</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                    	<i class="zmdi zmdi-close"></i>&nbsp;Tutup</button>
	                </button>
	            </div>
	            {{ Form::close() }}
	        </div>
	    </div>
	</div>
@endsection

@push('scripts')
	{{ Html::script('js/jquery.dataTables.min.js') }}
	<script type="text/javascript">
		$('.data_table').DataTable();

		(function($) {
			$('a#lunas, a#detil').on('click', function(e) {
				e.preventDefault();
				$.get($(this).attr('href'), function(data) {
					$(data).modal().on('shown.bs.modal', function(e) {
						$('select.selectpicker').selectpicker();
						$('.date-picker').datetimepicker({format:"YYYY-MM-DD"});
						$(".date-picker").on('dp.hide', function() {
							$(this).closest(".dtp-container").removeClass("fg-toggled");
							$(this).blur();
						});
						autosize($('.auto-size'));
						$('.data_table').DataTable();

						$('form.ajax_form').submit(function (e) {
		                    e.preventDefault();
		                    e.stopImmediatePropagation();
		                    $(this).ajax_form();
		                });

					}).on('hidden.bs.modal', function() {
						$(this).remove();
					});

				});
			});

		})(jQuery);
	</script>
@endpush