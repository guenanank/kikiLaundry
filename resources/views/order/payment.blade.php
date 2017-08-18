<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    {{ Form::model($order, ['route' => ['order.paid', $order->id], 'method' =>'patch', 'class' => 'ajax_form']) }}
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Order <strong class="text-primary">{{ $order->nomer }}</strong></h4>
      </div>
      <div class="modal-body">
        {{ Form::hidden('jumlah_tunai', $order->jumlah_tunai) }}
        <br />
        <div class="row">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="form-group">
              {{ Form::select('pembayaran', $pembayaran, null, ['class' => 'form-control selectpicker', 'title' => 'Pilih pembayaran']) }}
              <small id="pembayaran" class="help-block"></small>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="form-group fg-float">
              <div class="fg-line">
                {{ Form::text('tanggal_pembayaran', null, ['class' => 'form-control fg-input date-picker']) }} {{ Form::label('tanggal_pembayaran', 'Tanggal pembayaran', ['class' => 'fg-label']) }}
              </div>
              <small id="tanggal_pembayaran" class="help-block"></small>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="form-group fg-float">
              <div class="fg-line">
                {{ Form::textarea('catatan_pembayaran', null, ['class' => 'form-control fg-input auto-size', 'cols' => '', 'rows' => '']) }} {{ Form::label('catatan_pembayaran', 'Catatan pembayaran', ['class' => 'fg-label']) }}
              </div>
              <small id="catatan_pembayaran" class="help-block"></small>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm btn-icon-text"><i class="zmdi zmdi-check"></i>&nbsp;Simpan</button>
        <button type="button" class="btn btn-default btn-sm btn-icon-text" data-dismiss="modal"><i class="zmdi zmdi-close"></i>&nbsp;Tutup</button>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
