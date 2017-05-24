(function($) {

	var index = 0,
		id_barang, 
		nama_barang,
		id_jasa,
		nama_jasa,
		banyaknya = 0,
		harga_tunai,
		harga_cicil,
		jumlah_harga_tunai,
		jumlah_harga_cicil,
		order_tunai = [],
		order_cicil = [],
		jumlah_tunai = 0,
		jumlah_cicil = 0;

	var price_format = function(number) {
		var regex = parseFloat(number, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
		return 'Rp. ' + regex.slice(0, -3);
	};

	var total = function(arr) {
		var t = 0;
		for(var i = 0; i < arr.length; i++) {
			t += arr[i] << 0;
		}

		return parseInt(t, 10);
	};

	var clear = function() {
		$('select[name="barang_"], select[name="jasa_"]').empty().selectpicker('refresh');
		$('strong#jumlah_harga_tunai_teks, strong#jumlah_harga_cicil_teks').text(null);
		$('input[name="jumlah_tunai"], input[name="jumlah_cicil"]').val(null);
		$('table#daftar tbody > tr').hide(function() {
			$(this).remove();	
		});

		index = 0;
		banyaknya = 0;
		jumlah_harga_tunai = 0;
		jumlah_harga_cicil = 0;
		order_tunai.length = 0
		order_cicil.length = 0;
	};

	if($('input[name=id_pelanggan]')[0]) {
		$.getJSON(base_url + '/harga/' + $(this).val() + '/check', function(data) {
			jasa_barang(data);
		});
	} else {
		$('select[name="id_pelanggan"]').on('change', function() {
			clear();
			$.getJSON(base_url + '/harga/' + $(this).val() + '/check', function(data) {
				jasa_barang(data);
			});
		});
	}		

	var jasa_barang = function(data) {
		$.each(data.barang, function(k, v) {
			$('select[name="barang_"]').append('<option value="' + k + '">' + v + '</option>');
		});

		$('select[name="barang_"]').on('change', function() {
			$('select[name="jasa_"]').empty().selectpicker('refresh');
			id_barang = $('select[name="barang_"] option:selected').val();
			nama_barang = $('select[name="barang_"] option:selected').text();
			$.each(data.jasa[id_barang], function(index, row) {
				$('select[name="jasa_"]').append('<option data-tunai="' + row.tunai + '" data-cicil="' + row.cicil + '" value="' + index + '">' + row.nama + '</option>');	
				$('select[name="jasa_"]').selectpicker('refresh');
			});
		});

		$('.selectpicker').selectpicker('refresh');
	};

	$('select[name="jasa_"]').on('change', function() {
		id_jasa = $('select[name="jasa_"] option:selected').val();
		nama_jasa = $('select[name="jasa_"] option:selected').text();

		harga_tunai = $('select[name="jasa_"] option:selected').data('tunai');
		harga_cicil = $('select[name="jasa_"] option:selected').data('cicil');
	});

	$('button#tambah').on('click', function() {
		index += 1;
		banyaknya = $('input[name="banyaknya_"]').val();

		jumlah_harga_tunai = harga_tunai * banyaknya;
		jumlah_harga_cicil = harga_cicil * banyaknya;

		order_tunai.push(jumlah_harga_tunai);
		order_cicil.push(jumlah_harga_cicil);

		var hapus = '<button type="button" data-tunai="' + jumlah_harga_tunai + '" data-cicil="' + jumlah_harga_cicil + '" class="btn btn-sm bgm-red btn-icon hapus">';
			hapus += '<i class="zmdi zmdi-close"></i>';
			hapus += '</button>';

		var barang = '<td class="">' + nama_barang + '<input type="hidden" name="order_lengkap[' + index + '][id_barang]" value="' + id_barang + '" /></td>';
		var jasa = '<td class="">' + nama_jasa + '<input type="hidden" name="order_lengkap[' + index + '][id_jasa]" value="' + id_jasa + '" /></td>';
		var quantity = '<td class="text-center">' + banyaknya + '<input type="hidden" name="order_lengkap[' + index + '][banyaknya]" value="' + banyaknya + '" /></td>';
		var tunai = '<td class="text-right">' + price_format(harga_tunai) + '<input type="hidden" name="order_lengkap[' + index + '][harga_tunai]" value="' + harga_tunai + '" /></td>';
		var cicil = '<td class="text-right">' + price_format(harga_cicil) + '<input type="hidden" name="order_lengkap[' + index + '][harga_cicil]" value="' + harga_cicil + '" /></td>';
		var subtotal_tunai = '<td class="text-right">' + price_format(jumlah_harga_tunai) + '<input type="hidden" name="order_lengkap[' + index + '][jumlah_harga_tunai]" value="' + jumlah_harga_tunai + '" /></td>';
		var subtotal_cicil = '<td class="text-right">' + price_format(jumlah_harga_cicil) + '<input type="hidden" name="order_lengkap[' + index + '][jumlah_harga_cicil]" value="' + jumlah_harga_cicil + '" /></td>';
		var control = '<td class="text-center">' + hapus + '</td>';

		$('<tr>' + barang + jasa + quantity + tunai + cicil  + subtotal_tunai + subtotal_cicil + control + '</tr>').show(function() {
			$('table#daftar tbody').append($(this));
		});

		jumlah_tunai = total(order_tunai);
		jumlah_cicil = total(order_cicil);

		$('strong#jumlah_harga_tunai_teks').text(price_format(jumlah_tunai));
		$('strong#jumlah_harga_cicil_teks').text(price_format(jumlah_cicil));
		$('input[name="jumlah_tunai"]').val(jumlah_tunai);
		$('input[name="jumlah_cicil"]').val(jumlah_cicil);

		$('select[name="barang_"], select[name="jasa_"]').selectpicker('val', null);
		$('input[name="banyaknya_"]').val(null).blur();
	});

	$('table#daftar').on('click', '.hapus', function() {
		var harga_tunai_dihapus = $(this).data('tunai');
		var harga_cicil_dihapus = $(this).data('cicil');

		order_tunai.splice($.inArray(harga_tunai_dihapus, order_tunai), 1);
		order_cicil.splice($.inArray(harga_cicil_dihapus, order_cicil), 1);

		jumlah_tunai = total(order_tunai);
		jumlah_cicil = total(order_cicil);

		if(order_tunai.length === 0) {
			order_tunai.length = 0;
			$('strong#jumlah_harga_tunai_teks').text(null);
			$('input[name="jumlah_tunai"]').val(null);
		} else {
			$('strong#jumlah_harga_tunai_teks').text(price_format(jumlah_tunai));
			$('input[name="jumlah_tunai"]').val(jumlah_tunai);
		}

		if(order_cicil.length === 0) {
			order_cicil.length = 0;
			$('strong#jumlah_harga_cicil_teks').text(null);
			$('input[name="jumlah_cicil"]').val(null);
		} else {
			$('strong#jumlah_harga_cicil_teks').text(price_format(jumlah_cicil));
			$('input[name="jumlah_cicil"]').val(jumlah_cicil);
		}

		$(this).parents('tr').hide(function() {
			$(this).remove();
		});

	});

})(jQuery);