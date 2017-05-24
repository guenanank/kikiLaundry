<div class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::model($order, ['route' => ['order.update', $order->id], 'method' => 'PATCH', 'class' => 'ajax_form']) }}
                <div class="modal-header">
                    <h4 class="modal-title">No Order :  
                        <strong class="text-primary">{{ $order->nomer }}</strong>
                        <span class="pull-right">Tgl Order&nbsp;:&nbsp;{{ $order->tanggal }}</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <br />
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="form-group has-success">
                                <div class="fg-line">
                                    {{ Form::label('id_pelanggan', 'Nama pelanggan', ['class' => 'control-label']) }}
                                    {{ Form::text('id_pelanggan', $order->pelanggan->nama, ['class' => 'form-control', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="form-group has-success">
                                <div class="fg-line">
                                    {{ Form::label('catatan', 'Catatan', ['class' => 'control-label']) }}
                                    {{ Form::textarea('catatan', is_null($order->catatan) ? '~' : $order->catatan, ['class' => 'form-control', 'cols' => 0, 'rows' => 0, 'disabled']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="form-group has-success">
                                <div class="fg-line">
                                    {{ Form::label('jumlah_tunai', 'Total harga tunai', ['class' => 'control-label']) }}
                                    {{ Form::text('jumlah_tunai', 'Rp.' . number_format($order->jumlah_tunai), ['class' => 'form-control', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <div class="form-group has-success">
                                <div class="fg-line">
                                    {{ Form::label('jumlah_cicil', 'Total harga cicil', ['class' => 'control-label']) }}
                                    {{ Form::text('jumlah_cicil', 'Rp.' . number_format($order->jumlah_cicil), ['class' => 'form-control', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            @if(is_null($order->dikirim))
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        {{ Form::text('dikirim', $order->dikirim, ['class' => 'form-control fg-input']) }}
                                        {{ Form::label('dikirim', 'Tanggal dikirim', ['class' => 'fg-label']) }}
                                    </div>
                                    <small id="dikirim" class="help-block"></small>
                                </div>
                            @else
                                <div class="form-group has-success">
                                    <div class="fg-line">
                                        {{ Form::label('jumlah_cicil', 'Total harga cicil', ['class' => 'control-label']) }}
                                        {{ Form::text('dikirim', $order->dikirim, ['class' => 'form-control', 'disabled']) }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="clearfix">&nbsp;</div>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed data_table">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Barang</th>
                                <th class="text-center">Jasa</th>
                                <th class="text-center">Banyaknya</th>
                                <th class="text-center">Tunai</th>
                                <th class="text-center">Angsuran</th>
                                <th class="text-center">Subtotal Tunai</th>
                                <th class="text-center">Subtotal Cicil</th>
                            </tr>
                            @foreach ($order->detil as $detil)
                                <tr>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="detils[]" value="">
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $barang[$detil->id_barang] }}</td>
                                    <td>{{ $jasa[$detil->id_jasa] }}</td>
                                    <td class="text-center">{{ (int) $detil->banyaknya }}</td>
                                    <td class="text-right">Rp. {{ number_format($detil->harga_tunai) }}</td>
                                    <td class="text-right">Rp. {{ number_format($detil->harga_cicil) }}</td>
                                    <td class="text-right">Rp. {{ number_format($detil->jumlah_harga_tunai) }}</td>
                                    <td class="text-right">Rp. {{ number_format($detil->jumlah_harga_cicil) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total</strong></td>
                                <td class="text-right"><strong class="text-primary">Rp. {{ number_format($order->detil->sum('jumlah_harga_tunai')) }}</strong></td>
                                <td class="text-right"><strong class="text-primary">Rp. {{ number_format($order->detil->sum('jumlah_harga_cicil')) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bgm-gray btn-sm btn-icon-text"><i class="zmdi zmdi-print"></i>&nbsp;Cetak surat jalan</button>
                        <?php
                        if ($order->dicetak == false AND is_null($order->dikirim)) :
                            ?>
                            <a href="#" class="btn btn-primary btn-sm btn-icon-text">
                                <i class="zmdi zmdi-edit"></i>&nbsp;Ubah
                            </a>
                            <?php
                        endif;
                        ?>
                    <button type="button" class="btn btn-default btn-sm btn-icon-text" data-dismiss="modal"><i class="zmdi zmdi-close"></i>&nbsp;Tutup</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

