(function($) {

	var data, i = $('table#daftar tbody').find('tr').length;
	var tunai = [], cicil = [];
	var total = function(arr) {
		var t = 0;
		for(var i = 0; i < arr.length; i++)
			t += arr[i] << 0;

		return parseInt(t, 10);
	};

	var clear = function() {
		$('select[name="_barang"], select[name="_cuci"]').empty().selectpicker('refresh');
		$('input[name="_banyaknya"]').val(null).blur();
		$('span.jumlah_tunai').text(null);
		$('span.jumlah_cicil').text(null);
		$('input[name="jumlah_tunai"]').val(0);
		$('input[name="jumlah_cicil"]').val(0);

		$('table#daftar tbody > tr').hide(function() {
			$(this).remove();
		});
	};

	if($('input[name=id_pelanggan]')[0]) {
		$.getJSON(base_url + '/harga/' + $('input[name=id_pelanggan]').val() + '/check', function(data) {
			harga(data);
		});

		$.each($('table#daftar tbody > tr > td > button'), function() {
			tunai.push($(this).data('tunai'));
			cicil.push($(this).data('cicil'));
		});

	} else {
		$('select[name="id_pelanggan"]').on('change', function() {
			$('.page-loader').show();
			clear();
			$.getJSON(base_url + '/harga/' + $(this).val() + '/check', function(data) {
				harga(data);
			}).done(function() {
				$('.page-loader').hide();
			});
		});
	}

	var harga = function(data) {
		if(data.length === 0)
			return;

		$.each(data.barang, function(k, v) {
			$('select[name="_barang"]').append('<option value="' + k + '">' + v + '</option>');
		});

		$('select[name="_barang"]').on('change', function() {
			$('select[name="_cuci"]').empty().selectpicker('refresh');
			var barang = $(this).find(':selected').val();
			$.each(data.cuci[barang], function(index, row) {
				$('select[name="_cuci"]').append('<option data-tunai="' + row.tunai + '" data-cicil="' + row.cicil + '" value="' + index + '">' + row.nama + '</option>');
				$('select[name="_cuci"]').selectpicker('refresh');
			});
		});

		$('.selectpicker').selectpicker('refresh');
	};

	$('div.detil').on('click', 'button#tambah', function() {
		var obj = {};
		$(this).parents('div.detil').find(':input').each(function() {
			var nama = $(this).attr('name');
        	if(typeof nama !== 'undefined') {
            	if($(this).val().length === 0) {
            		$('#' + nama).parents('div.barang').find('div.form-group').addClass('has-warning');
            		$('#' + nama).text('The ' + nama + ' field is required');
            	} else {
            		obj[nama] = $(this).val();
            		obj['_nama_barang'] = $('select[name="_barang"]').find(':selected').text();
            		obj['_nama_cuci'] = $('select[name="_cuci"]').find(':selected').text();
            		if(nama == '_cuci') {
            			obj['_tunai'] = $(this).find(':selected').data('tunai');
            			obj['_cicil'] = $(this).find(':selected').data('cicil');
            		}
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
    	tunai.push($('input[name="_banyaknya"]').val() * $('select[name="_cuci"]').find(':selected').data('tunai'));
		cicil.push($('input[name="_banyaknya"]').val() * $('select[name="_cuci"]').find(':selected').data('cicil'));
		$('span.jumlah_tunai').text(price_format(total(tunai)));
		$('span.jumlah_cicil').text(price_format(total(cicil)));
		$('input[name="jumlah_tunai"]').val(total(tunai));
		$('input[name="jumlah_cicil"]').val(total(cicil));
		$('select[name="_barang"], select[name="_cuci"]').selectpicker('val', null);
		$('input[name="_banyaknya"]').val(null).blur();
	});

	var tbody = function(data) {
		var tbody;
		$.each(data, function(k, v) {
			var jumlah_tunai = v._banyaknya * v._tunai;
			var jumlah_cicil = v._banyaknya * v._cicil;
			i += 1;
			tbody += '<tr>';

			tbody += '<td>' + v._nama_barang;
			tbody += '<input type="hidden" name="order_lengkap[' + i + '][id_barang]" value="' + v._barang + '" />';
			tbody += '</td>';

			tbody += '<td>' + v._nama_cuci;
			tbody += '<input type="hidden" name="order_lengkap[' + i + '][id_cuci]" value="' + v._cuci + '" />';
			tbody += '</td>';

			tbody += '<td class="text-center">' + v._banyaknya;
			tbody += '<input type="hidden" name="order_lengkap[' + i + '][banyaknya]" value="' + v._banyaknya + '" />';
			tbody += '</td>';

			tbody += '<td class="text-right">' + price_format(jumlah_tunai);
			tbody += '<input type="hidden" name="order_lengkap[' + i + '][harga_tunai]" value="' + v._tunai + '" />';
			tbody += '</td>';

			tbody += '<td class="text-right">' + price_format(jumlah_cicil);
			tbody += '<input type="hidden" name="order_lengkap[' + i + '][harga_cicil]" value="' + v._cicil + '" />';
			tbody += '</td>';

			tbody += '<td>';
			tbody += '<button type="button" class="btn btn-sm bgm-red btn-icon hapus" data-tunai="' + jumlah_tunai + '" data-cicil="' + jumlah_cicil + '">';
			tbody += '<i class="zmdi zmdi-close"></i></button>';
			tbody += '</td>';
			tbody += '</tr>';
			$('table#daftar tbody').append(tbody);
		});
	};

	$('table#daftar').on('click', '.hapus', function() {
		$(this).parents('tr').hide(function() {
			$(this).remove();
		});

		tunai.splice($.inArray($(this).data('tunai'), tunai), 1);
		cicil.splice($.inArray($(this).data('cicil'), cicil), 1);
		$('span.jumlah_tunai').text(price_format(total(tunai)));
		$('span.jumlah_cicil').text(price_format(total(cicil)));
		$('input[name="jumlah_tunai"]').val(total(tunai));
		$('input[name="jumlah_cicil"]').val(total(cicil));
	});

	// var index = 0,
	// 	id_barang,
	// 	nama_barang,
	// 	id_jasa,
	// 	nama_jasa,
	// 	banyaknya = 0,
	// 	harga_tunai,
	// 	harga_cicil,
	// 	jumlah_harga_tunai,
	// 	jumlah_harga_cicil,
	// 	order_tunai = [],
	// 	order_cicil = [],
	// 	jumlah_tunai = 0,
	// 	jumlah_cicil = 0;

	// var price_format = function(number) {
	// 	var regex = parseFloat(number, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	// 	return 'Rp. ' + regex.slice(0, -3);
	// };

	// var total = function(arr) {
	// 	var t = 0;
	// 	for(var i = 0; i < arr.length; i++) {
	// 		t += arr[i] << 0;
	// 	}

	// 	return parseInt(t, 10);
	// };

	// var clear = function() {
	// 	$('select[name="barang_"], select[name="jasa_"]').empty().selectpicker('refresh');
	// 	$('strong#jumlah_harga_tunai_teks, strong#jumlah_harga_cicil_teks').text(null);
	// 	$('input[name="jumlah_tunai"], input[name="jumlah_cicil"]').val(null);
	// 	$('table#daftar tbody > tr').hide(function() {
	// 		$(this).remove();
	// 	});

	// 	index = 0;
	// 	banyaknya = 0;
	// 	jumlah_harga_tunai = 0;
	// 	jumlah_harga_cicil = 0;
	// 	order_tunai.length = 0
	// 	order_cicil.length = 0;
	// };

	// if($('input[name=id_pelanggan]')[0]) {
	// 	$.getJSON(base_url + '/harga/' + $(this).val() + '/check', function(data) {
	// 		jasa_barang(data);
	// 	});
	// } else {
	// 	$('select[name="id_pelanggan"]').on('change', function() {
	// 		clear();
	// 		$.getJSON(base_url + '/harga/' + $(this).val() + '/check', function(data) {
	// 			jasa_barang(data);
	// 		});
	// 	});
	// }

	// var jasa_barang = function(data) {
	// 	$.each(data.barang, function(k, v) {
	// 		$('select[name="barang_"]').append('<option value="' + k + '">' + v + '</option>');
	// 	});

	// 	$('select[name="barang_"]').on('change', function() {
	// 		$('select[name="jasa_"]').empty().selectpicker('refresh');
	// 		id_barang = $('select[name="barang_"] option:selected').val();
	// 		nama_barang = $('select[name="barang_"] option:selected').text();
	// 		$.each(data.cuci[id_barang], function(index, row) {
	// 			$('select[name="jasa_"]').append('<option data-tunai="' + row.tunai + '" data-cicil="' + row.cicil + '" value="' + index + '">' + row.nama + '</option>');
	// 			$('select[name="jasa_"]').selectpicker('refresh');
	// 		});
	// 	});

	// 	$('.selectpicker').selectpicker('refresh');
	// };

	// $('select[name="jasa_"]').on('change', function() {
	// 	id_jasa = $('select[name="jasa_"] option:selected').val();
	// 	nama_jasa = $('select[name="jasa_"] option:selected').text();

	// 	harga_tunai = $('select[name="jasa_"] option:selected').data('tunai');
	// 	harga_cicil = $('select[name="jasa_"] option:selected').data('cicil');
	// });

	// $('button#tambah').on('click', function() {
	// 	index += 1;
	// 	banyaknya = $('input[name="banyaknya_"]').val();

	// 	jumlah_harga_tunai = harga_tunai * banyaknya;
	// 	jumlah_harga_cicil = harga_cicil * banyaknya;

	// 	order_tunai.push(jumlah_harga_tunai);
	// 	order_cicil.push(jumlah_harga_cicil);

	// 	var hapus = '<button type="button" data-tunai="' + jumlah_harga_tunai + '" data-cicil="' + jumlah_harga_cicil + '" class="btn btn-sm bgm-red btn-icon hapus">';
	// 		hapus += '<i class="zmdi zmdi-close"></i>';
	// 		hapus += '</button>';

	// 	var barang = '<td class="">' + nama_barang + '<input type="hidden" name="order_lengkap[' + index + '][id_barang]" value="' + id_barang + '" /></td>';
	// 	var jasa = '<td class="">' + nama_jasa + '<input type="hidden" name="order_lengkap[' + index + '][id_jasa]" value="' + id_jasa + '" /></td>';
	// 	var quantity = '<td class="text-center">' + banyaknya + '<input type="hidden" name="order_lengkap[' + index + '][banyaknya]" value="' + banyaknya + '" /></td>';
	// 	var tunai = '<td class="text-right">' + price_format(harga_tunai) + '<input type="hidden" name="order_lengkap[' + index + '][harga_tunai]" value="' + harga_tunai + '" /></td>';
	// 	var cicil = '<td class="text-right">' + price_format(harga_cicil) + '<input type="hidden" name="order_lengkap[' + index + '][harga_cicil]" value="' + harga_cicil + '" /></td>';
	// 	var subtotal_tunai = '<td class="text-right">' + price_format(jumlah_harga_tunai) + '<input type="hidden" name="order_lengkap[' + index + '][jumlah_harga_tunai]" value="' + jumlah_harga_tunai + '" /></td>';
	// 	var subtotal_cicil = '<td class="text-right">' + price_format(jumlah_harga_cicil) + '<input type="hidden" name="order_lengkap[' + index + '][jumlah_harga_cicil]" value="' + jumlah_harga_cicil + '" /></td>';
	// 	var control = '<td class="text-center">' + hapus + '</td>';

	// 	jumlah_tunai = total(order_tunai);
	// 	jumlah_cicil = total(order_cicil);

	// 	$('strong#jumlah_harga_tunai_teks').text(price_format(jumlah_tunai));
	// 	$('strong#jumlah_harga_cicil_teks').text(price_format(jumlah_cicil));
	// 	$('input[name="jumlah_tunai"]').val(jumlah_tunai);
	// 	$('input[name="jumlah_cicil"]').val(jumlah_cicil);

	// 	$('select[name="barang_"], select[name="jasa_"]').selectpicker('val', null);
	// 	$('input[name="banyaknya_"]').val(null).blur();

	// 	$('<tr>' + barang + jasa + quantity + tunai + cicil  + subtotal_tunai + subtotal_cicil + control + '</tr>').show(function() {
	// 		$('table#daftar tbody').append($(this));
	// 	});
	// });

	// $('table#daftar').on('click', '.hapus', function() {
	// 	var harga_tunai_dihapus = $(this).data('tunai');
	// 	var harga_cicil_dihapus = $(this).data('cicil');

	// 	order_tunai.splice($.inArray(harga_tunai_dihapus, order_tunai), 1);
	// 	order_cicil.splice($.inArray(harga_cicil_dihapus, order_cicil), 1);

	// 	jumlah_tunai = total(order_tunai);
	// 	jumlah_cicil = total(order_cicil);

	// 	if(order_tunai.length === 0) {
	// 		order_tunai.length = 0;
	// 		$('strong#jumlah_harga_tunai_teks').text(null);
	// 		$('input[name="jumlah_tunai"]').val(null);
	// 	} else {
	// 		$('strong#jumlah_harga_tunai_teks').text(price_format(jumlah_tunai));
	// 		$('input[name="jumlah_tunai"]').val(jumlah_tunai);
	// 	}

	// 	if(order_cicil.length === 0) {
	// 		order_cicil.length = 0;
	// 		$('strong#jumlah_harga_cicil_teks').text(null);
	// 		$('input[name="jumlah_cicil"]').val(null);
	// 	} else {
	// 		$('strong#jumlah_harga_cicil_teks').text(price_format(jumlah_cicil));
	// 		$('input[name="jumlah_cicil"]').val(jumlah_cicil);
	// 	}

	// 	$(this).parents('tr').hide(function() {
	// 		$(this).remove();
	// 	});

	// });

})(jQuery);
