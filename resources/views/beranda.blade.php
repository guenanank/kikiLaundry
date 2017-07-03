@extends('layout')
@section('title', 'Beranda')

@push('styles')
	{{ Html::style('css/fullcalendar.min.css') }}
@endpush

@section('content')


<div class="mini-charts">
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-lightgreen">
                <div class="clearfix">
                    <div class="chart stats-bar"></div>
                    <div class="count">
                        <small>Order Minggu Ini</small>
                        <h2>987,459</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-purple">
                <div class="clearfix">
                    <div class="chart stats-bar-2"></div>
                    <div class="count">
                        <small>Order Terkirim</small>
                        <h2>356,785K</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-orange">
                <div class="clearfix">
                    <div class="chart stats-line"></div>
                    <div class="count">
                        <small>Order Lunas</small>
                        <h2>$ 458,778</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-bluegray">
                <div class="clearfix">
                    <div class="chart stats-line-2"></div>
                    <div class="count">
                        <small>Order Cicil</small>
                        <h2>23,856</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
                <h2>Order Cepat<small>Buat order baru untuk hari ini ({{ date('Y-m-d') }})</small></h2>
                <ul class="actions">
                    <li>
                        <a href="#">
                            <i class="zmdi zmdi-refresh-alt"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="#">Change Date Range</a>
                            </li>
                            <li>
                                <a href="#">Change Graph Type</a>
                            </li>
                            <li>
                                <a href="#">Other Settings</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="card-body">
			{{ Form::open(['route' => 'order.store', 'class' => 'ajax_form']) }}
				{{ Form::hidden('nomer', $nomer) }}
				{{ Form::hidden('tanggal', date('Y-m-d')) }}

				<div class="row">
		            <div class="col-sm-offset-1 col-sm-10">
		                <div class="form-group">
		                    {{ Form::select('id_pelanggan', $pelanggan, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih pelanggan', 'data-live-search' => 'true']) }}
		                    <small id="pelanggan" class="help-block"></small>
		                </div>
		            </div>
		        </div>

		        <div class="clearfix">&nbsp;</div>
		        <div class="clearfix">&nbsp;</div>

		        <div class="row detil">
        			<div class="col-sm-offset-1 col-sm-10">
            			<div class="row">
	                        <div class="col-sm-4">
	                        	<div class="form-group">
				                    {{ Form::select('_barang', [], null, ['class' => 'form-control selectpicker', 'title' => 'Barang']) }}
				                    <small id="_barang" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-4">
	                            <div class="form-group">
				                    {{ Form::select('_cuci', [], null, ['class' => 'form-control selectpicker', 'title' => 'Cuci']) }}
				                    <small id="_cuci" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-2">
	                        	<div class="form-group fg-float">
				                    <div class="fg-line">
				                        {{ Form::text('_banyaknya', null, ['class' => 'form-control fg-input']) }}
				                        {{ Form::label('_banyaknya', 'Banyaknya', ['class' => 'fg-label']) }}
				                    </div>
				                    <small id="_banyaknya" class="help-block"></small>
				                </div>
	                        </div>
	                        <div class="col-sm-2">
	                        	<button type="button" class="btn btn-icon pull-right bgm-gray btn-waves" data-toggle="tooltip" data-placement="top" title="Tambah" id="tambah">
	                                <i class="zmdi zmdi-shopping-cart-plus"></i>
	                            </button>
	                        </div>
	                    </div>
            		</div>
            	</div>

            	<div class="row">
	        		<div class="col-sm-offset-1 col-sm-10">
			            <div class="table-responsive">
			                <table class="table table-striped table-bordered" id="daftar">
			                	<thead>
				                    <tr>
				                        <th>Barang</th>
				                        <th>Cuci</th>
				                        <th class="text-center">Banyaknya</th>
				                        <th class="text-center">&nbsp;</th>
				                    </tr>
			                    </thead>
			                    <tbody></tbody>
			                </table>
			            </div>
		            </div>
	            </div>

		        <div class="clearfix">&nbsp;</div>
			    <hr />
			    <div class="clearfix">&nbsp;</div>

		        <div class="form-group">
		            <div class="col-sm-offset-1 col-sm-10">
		                <button class="btn btn-primary btn-icon-text btn-sm" type="submit">
		                    <i class="zmdi zmdi-check"></i> Simpan
		                </button>
		            </div>
		        </div>
		        <div class="clearfix">&nbsp;</div>

			{{ Form::close() }}
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card" id="calendar-widget">
            <div class="card-header bgm-teal">
                <div class="cwh-year"></div>
                <div class="cwh-day"></div>

                <button class="bgm-lightgreen btn btn-default bg btn-float"><i class="zmdi zmdi-plus"></i></button>
            </div>

            <div class="card-body card-padding-sm">
                <div id="cw-body"></div>
            </div>
        </div>
	</div>
</div>
@endsection

@push('scripts')
	{{ Html::script('js/flot/jquery.flot.js') }}
	{{ Html::script('js/flot/jquery.flot.resize.js') }}
	{{ Html::script('js/flot/jquery.flot.curvedLines.js') }}
	{{ Html::script('js/jquery.sparkline.min.js') }}
	{{ Html::script('js/jquery.easypiechart.min.js') }}
@endpush
