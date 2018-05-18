<div class="card">
  <div class="card-header">
    <h2>Pelanggan Terbaik
      <small>
        10 pelanggan dengan order terbanyak pada bulan
        <span class="c-blue">
          {{ \Carbon\Carbon::now()->format('F') }}
          {{ \Carbon\Carbon::now()->format('Y') }}
        </span>.
      </small>
    </h2>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        @foreach($pelanggan_terbaik as $pelanggan)
          <tr>
            <td>
              {{ $pelanggan->nama }} <small class="c-gray">({{ $pelanggan->telepon }})</small>
              <br />{{ $pelanggan->alamat }}
            </td>
            <td class="text-right">
              <h4 class="c-green">{{ number_format($pelanggan->order_count) }} order</h4>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
