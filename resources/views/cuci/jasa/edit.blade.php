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
		                        {{ Form::text('ongkos', number_format($jasa->ongkos), ['class' => 'form-control fg-input money']) }}
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
		                        {{ Form::text('klaim', number_format($jasa->klaim), ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="klaim" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row open">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group fg-float">
		                    <div class="fg-line">
		                        {{ Form::text('open', number_format($jasa->open), ['class' => 'form-control fg-input money']) }}
		                        {{ Form::label('open', 'Open Jasa', ['class' => 'fg-label']) }}
		                    </div>
		                    <small id="open" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="row barang">
		        	<div class="col-sm-offset-1 col-sm-10"><hr /></div>
		        </div>
		        <div class="clearfix">&nbsp;</div>

		        <div class="row barang">
		        	<div class="col-sm-offset-2 col-sm-8">
		        		<div class="row">
		                    <div class="col-sm-4">
		                        <div class="form-group">
				                    {{ Form::select('id_barang', $barang, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih barang', 'data-live-search' => 'true']) }}
				                    <small id="id_barang" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-2">
		                        <div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('_ongkos', null, ['class' => 'form-control fg-input money']) }}
				                        {{ Form::label('_ongkos', 'Ongkos Jasa', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="_ongkos" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-2">
		                        <div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('_klaim', null, ['class' => 'form-control fg-input money']) }}
				                        {{ Form::label('_klaim', 'Klaim Jasa', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="_klaim" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-2">
		                        <div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('_open', null, ['class' => 'form-control fg-input money']) }}
				                        {{ Form::label('_open', 'Open Jasa', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="_open" class="help-block"></small>
				                </div>
		                    </div>

		                    <div class="col-sm-2">
		                        <button class="btn bgm-gray btn-icon-text btn-sm" type="button" id="tambah">
				                    <i class="zmdi zmdi-shopping-cart-plus"></i> Tambah
				                </button>
		                    </div>
		                    <div class="clearfix">&nbsp;</div>
		                    
			            	<div class="table-responsive">
			            		<table class="table table-striped" id="daftar">
				                	<thead>
					                    <tr>
					                        <th class="text-center">Nama</th>
					                        <th class="text-center">Ongkos</th>
					                        <th class="text-center">Klaim</th>
					                        <th class="text-center">Open</th>
					                        <th class="text-center">&nbsp;</th>
					                    </tr>
				                    </thead>
				                    <tbody>
				                    	@foreach($jasa->jasa_barang as $i => $jb)
				                    		<tr>
				                    			<td>
				                    				{{ $barang[$jb->id_barang] }}
				                    				<input type="hidden" name="barang[{{ $i + 1 }}][id_barang]" value="{{ $jb->id_barang }}" />
			                    				</td>
				                    			<td class="text-right">
				                    				Rp. {{ number_format($jb->ongkos) }}
				                    				<input type="hidden" name="barang[{{ $i + 1 }}][ongkos]" value="{{ $jb->ongkos }}" />
			                    				</td>
				                    			<td class="text-right">
				                    				Rp. {{ number_format($jb->klaim) }}
				                    				<input type="hidden" name="barang[{{ $i + 1 }}][klaim]" value="{{ $jb->klaim }}" />
			                    				</td>
				                    			<td class="text-right">
				                    				Rp. {{ number_format($jb->open) }}
				                    				<input type="hidden" name="barang[{{ $i + 1 }}][open]" value="{{ $jb->open }}" />
			                    				</td>
				                    			<td class="text-right">
				                    				<button type="button" class="btn btn-sm bgm-red btn-icon hapus">
														<i class="zmdi zmdi-close"></i>
													</button>
				                    			</td>
				                    		</tr>
				                    	@endforeach
				                    </tbody>
				                </table>
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
	{{ Html::script('js/jasa.js') }}
@endpush