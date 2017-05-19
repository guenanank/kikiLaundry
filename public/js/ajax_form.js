/**
 * jQuery AJAX form
 * used only for material admin template
 *
 * @author nanank
 */

(function ($) {

    $.fn.ajax_form = function (obj) {

        var setting = $.fn.extend({
            url: '',
            data: {}
        }, obj);

        return this.each(function () {
            var $t = $(this);

            var $clear = function (create) {
                if (create) {
                    $t.find(':input').val(null).trigger('blur');
                    $('.selectpicker').selectpicker('refresh');
                    $(':input').not('input[type="hidden"]').val(null);
                }
                $('div.form-group').removeClass('has-warning');
                $('small.help-block').text(null);
            };

            $.ajax({
                type: $t.attr('method'),
                url: (setting.url) ? setting.url : $t.attr('action'),
                data: (typeof setting.data === 'undefined') ? setting.data : $t.serialize(),
                beforeSend: function () {
                    $('.page-loader').fadeIn();
                    $clear(false);
                },
                statusCode: {
                    200: function (data) {
                        swal({
                            type: 'success',
                            html: '<strong class="f-20">Success</strong><br />Data Saved.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $clear(data.create);
                    },
                    422: function (response) {
                        $.each(response.responseJSON, function (k, v) {
                            $('#' + k).parents('div.form-group').addClass('has-warning');
                            $('#' + k).text(v);
                        });
                    }
                }
            }).always(function() {
                $('.page-loader').fadeOut();
                $('.selectpicker').selectpicker('deselectAll');
            });
        });
    };

    $.fn.ajax_delete = function (obj) {

        var $t = $(this);

        return this.each(function () {

            $.ajaxSetup({
                type: 'POST',
                url: $t.attr('href'),
                data: { _method: 'DELETE' },
                statusCode: {
                    200: function () {
                        swal({
                            type: 'success',
                            html: '<strong class="f-20">Deleted</strong><br />Your file has been deleted.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, delete it!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger'
            }).then(function () {
                $.ajax();
                window.location.reload(true); 
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    swal({
                        type: 'error',
                        html: '<strong class="f-20">Cancelled</strong><br />Your file is safe :)',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    };

})(jQuery);