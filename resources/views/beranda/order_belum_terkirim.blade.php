<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-8">
        <h2>Order <small>Daftar order yang belum terkirim.</small></h2>
      </div>
      <div class="col-sm-4">
        <div class="pull-right">
          <a href="{{ action('OrderController@create') }}" class="btn btn-icon pull-right bgm-green" data-toggle="tooltip" data-placement="left" title="Buat Order Baru">
            <i class="add-new-item zmdi zmdi-plus"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="list-body">
      <div class="list-group">
        @if($order_belum_terkirim->isNotEmpty())
          @foreach($order_belum_terkirim as $order)
            <a class="list-group-item media kirim" href="{{ url('order/' . $order->id) }}">
              <div class="media-body">
                <div class="lgi-heading c-blue">{{ $order->nomer }}</div>
                <ul class="lgi-attrs">
                  <li>{{ $order->pelanggan->nama }}</li>
                  <li>{{ $order->tanggal }}</li>
                  <li><i class="zmdi zmdi-flight-takeoff"></i> Kirim</li>
                </ul>
              </div>
            </a>
        @endforeach
        @endif
      </div>
    </div>
  </div>
</div>
