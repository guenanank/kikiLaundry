@extends('layout')
@section('title', 'Beranda')

@push('styles')
  {{ Html::style('css/jquery.dataTables.min.css') }}
@endpush

@section('content')
<div class="row">
  <div class="col-md-12">
    @include('beranda.order_harian')
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    @include('beranda.order_belum_terkirim')
  </div>
  <div class="col-md-4">
    @include('beranda.pelanggan_terbaik')
  </div>
</div>
@endsection

@push('scripts')
{{ Html::script('js/flot/jquery.flot.js') }}
{{ Html::script('js/flot/jquery.flot.resize.js') }}
{{ Html::script('js/flot/jquery.flot.curvedLines.js') }}
{{ Html::script('js/jquery.sparkline.min.js') }}

{{ Html::script('js/jquery.dataTables.min.js') }}
<script type="text/javascript">
  (function($) {
    $('body').on('click', 'a.kirim', function(e) {
      e.preventDefault();
      $.get($(this).attr('href'), function(data) {
        $(data).modal().on('shown.bs.modal', function(e) {
          $('select.selectpicker').selectpicker();
          $('.date-picker').datetimepicker({
            format: 'YYYY-MM-DD'
          });
          $('.date-picker').on('dp.hide', function() {
            $(this).closest('.dtp-container').removeClass('fg-toggled');
            $(this).blur();
          });
          autosize($('.auto-size'));
          $('.data_table').DataTable();
          $('form.ajax_form').submit(function(e) {
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
