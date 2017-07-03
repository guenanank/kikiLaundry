$('div.ongkos, div.klaim, div.open, div.barang').hide();
$('input[name="tergantung_barang"]').change(function() {
    if(this.checked) {
    	$('div.ongkos, div.klaim, div.open').fadeOut();
    	$('div.barang').fadeIn();
    } else {
    	$('div.ongkos, div.klaim, div.open').fadeIn();
        $('div.barang').fadeOut();
    }
});

if($('input[name="tergantung_barang"]').prop('checked')) {
	$('div.ongkos, div.klaim, div.open').fadeOut();
	$('div.barang').fadeIn();
} else {
	$('div.ongkos, div.klaim, div.open').fadeIn();
    $('div.barang').fadeOut();
}

var data, i = $('table#daftar tbody').find('tr').length;
$('div.barang').on('click', 'button#tambah', function() {
	var obj = {};
    $(this).parents('div.barang').find(':input').each(function() {
		var nama = $(this).attr('name');
    	if(typeof nama != 'undefined') {
        	if($(this).val().length === 0) {
        		$('#' + nama).parents('div.barang').find('div.form-group').addClass('has-warning');
        		$('#' + nama).text('The ' + nama + ' field is required');
        	} else {
        		obj['barang'] = $('select[name="id_barang"]').find(':selected').text();
        		obj[nama] = $(this).val();
        	}
    	}
    });

    if($.isEmptyObject(obj) == false) 
    	data = $.makeArray(obj);

    if(data.length !== 0) {
    	$('div.form-group').removeClass('has-warning');
        $('small.help-block').text(null);
    }
    
	tbody(data);
	$('select.selectpicker').selectpicker('val', []);
	$('input[name="_ongkos"], input[name="_klaim"], input[name="_open"]').val(null).blur();
});

var tbody = function(data) {
	var tbody;
	var hapus = '<button type="button" class="btn btn-sm bgm-red btn-icon hapus">';
	hapus += '<i class="zmdi zmdi-close"></i>';
	hapus += '</button>';

	$.each(data, function(k, v) {
		v._ongkos = typeof v._ongkos == 'undefined' ? 0 : v._ongkos;
		v._klaim = typeof v._klaim == 'undefined' ? 0 : v._klaim;
		v._open = typeof v._open == 'undefined' ? 0 : v._open;
		
		i += 1;
		tbody += '<tr>';
		tbody += '<td><input type="hidden" name="barang[' + i + '][id_barang]" value="' + v.id_barang + '" />' + v.barang + '</td>';
		tbody += '<td class="text-right">' + price_format(v._ongkos) + '<input type="hidden" name="barang[' + i + '][ongkos]" value="' + v._ongkos + '" /></td>';
		tbody += '<td class="text-right">' + price_format(v._klaim) + '<input type="hidden" name="barang[' + i + '][klaim]" value="' + v._klaim + '" /></td>';
		tbody += '<td class="text-right">' + price_format(v._open) + '<input type="hidden" name="barang[' + i + '][open]" value="' + v._open + '" /></td>';
		tbody += '<td class="text-right">' + hapus + '</td>';
		tbody += '</tr>';
		$('table#daftar tbody').append(tbody);
	});

};

$('table#daftar').on('click', '.hapus', function() {
	$(this).parents('tr').hide(function() {
		$(this).remove();
	});
});		