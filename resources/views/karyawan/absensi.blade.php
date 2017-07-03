@extends('layout')
@section('title', 'Karyawan - Tambah Baru')

@section('content')
	<div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <h2>Absensi Karyawan <small>Data absensi karyawan untuk tanggal {{ $tanggal }}.</small></h2>
          </div>
          <div class="col-sm-6">
            <div class="pull-right">
              <a href="{{ action('KaryawanController@index') }}" class="btn btn-icon pull-right bgm-orange" data-toggle="tooltip" data-placement="left" title="Kembali">
                <i class="zmdi zmdi-arrow-left"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
	    <div class="clearfix">&nbsp;</div>
	    <div class="card-body card-padding">
	        {{ Form::open(['route' => 'absen.submit', 'class' => 'ajax_form']) }}
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <div class="form-group has-success">
                        <div class="fg-line">
                            {{ Form::label('tanggal', 'Tanggal Absensi', ['class' => 'control-label']) }}
                            {{ Form::text('_tanggal', $tanggal, ['class' => 'form-control', 'disabled']) }}
                            {{ Form::hidden('tanggal', $tanggal) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                  <hr />
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed data_table">
                          <thead>
                              <tr>
                                  <th>Nama</th>
                                  <th>Masuk</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($karyawan as $k => $v)
                              <tr>
                                <td>{{ $v }}</td>
                                <td>
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="karyawan[]" value="{{ $k }}" {{ in_array($k, $absensi->pluck('id_karyawan')->all()) ? 'checked="true"' : null }} />
                                          <i class="input-helper"></i>
                                      </label>
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
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
  	        <div class="clearfix">&nbsp;</div>
	        {{ Form::close() }}
	    </div>
	</div>
@endsection
