		var lewat_antrian = $('#memproses_antrian').length;
		var antrian_id = $('#antrian_id').html();
		antrian_id = $.trim(antrian_id);

		loaderGif();
        $('#confirm_staf').on('show.bs.modal', function(){
            $('#confirm_staf input[type!="hidden"]').val('');
        });
        $('#confirm_staf').on('shown.bs.modal', function(){
            $('#email').focus();
        });
		$('#antrianpoli_tanggal').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'dd-mm-yyyy'
            }).on('changeDate', function(e) {
			tanggalChange();
		});

		$('#antrianpoli_tanggal').closest('form').attr('autocomplete', 'off');

		$('#ddlPembayaran').change(function(){
			var val = $(this).val();
			if (val == '32') {
				$('#bukan_peserta select').val('');
				$('#bukan_peserta')
					.removeClass('hide')
					.hide()
					.fadeIn(500);
				console.log($('#bukan_peserta select').val());
			} else {
				$('#bukan_peserta').fadeOut(500);
				$('#bukan_peserta select').val('0');
				console.log($('#bukan_peserta select').val());
			}
		});

       var request;
        $('#dummyButton').click(function(e) {
			if ( $('#antrianpoli_poli').val() == 'usg' ) {
				var r = confirm('Pastikan pasien diperiksa dalam keadaan kandung kencing penuh, UNTUK PASIEN USG DENGAN UMUMR KEHAMILAN 12 MINGGU');
				if (!r) {
					return false;
				}
			}
			if ( $('#antrianpoli_poli').val() == 'usgabdomen' ) {
				var r = confirm('Pastikan pasien diperiksa dalam keadaan kandung kencing penuh');
				if (!r) {
					return false;
				}
			}
			 if(
				$('#antrianpoli_staf_id').val() == '' ||
				$('select#ddlPembayaran').val() == '' ||
				$('#bukan_peserta select').val() == '' ||
				$('#antrianpoli_poli').val() == '' ||
				$('#antrianpoli_tanggal').val() == '' ||
				$('#antrianpoli_antrian').val() == '' ){
				if($('#antrianpoli_staf_id').val() == '' ){
					validasi('#antrianpoli_staf_id', 'Harus Diisi');
				}
				if($('#bukan_peserta select').val() == '' ){
					validasi('#bukan_peserta select', 'Harus Diisi');
				}
				if($('#antrianpoli_poli').val() == '' ){
					validasi('#antrianpoli_poli', 'Harus Diisi');
				}
				if($('#antrianpoli_antrian').val() == '' ){
					validasi('#antrianpoli_antrian', 'Harus Diisi');
				}
				if($('#antrianpoli_tanggal').val() == '' ){
					validasi('#antrianpoli_tanggal', 'Harus Diisi');
				}
				if($('select#ddlPembayaran').val() == '' ){

					console.log('asuransi_id = ' + $('select#ddlPembayaran').val());
					validasi('select#ddlPembayaran', 'Harus Diisi');
				}
			} else {
			   lanjutSubmit(e);
            }
        });

        $('#pasienInsert').on('shown.bs.modal', function () {
            $('.hh').val('');
            $('#CheckBox1').prop('checked', false); // Unchecks it
        });

        $('#submitPasien').click(function(e){
            e.preventDefault();
            var data = $('#pasienInsertForm').serializeArray();
            var url = $('#pasienInsertForm').attr('action');

            if($('#pasienInsertForm input[name="nama"]').val() == '' || $('#pasienInsertForm select[name="sex"]').val() == '' || $('#pasienInsertForm select[name="panggilan"]').val() == ''){

                if($('#pasienInsertForm input[name="nama"]').val() == ''){
                    validasi('#pasienInsertForm input[name="nama"]', '<code>Harus Diisi</code>');
                }
                if($('#pasienInsertForm select[name="sex"]').val() == ''){
                    validasi('#pasienInsertForm select[name="sex"]', '<code>Harus Diisi</code>');
                }
                if($('#pasienInsertForm select[name="panggilan"]').val() == ''){
                    validasi('#pasienInsertForm select[name="panggilan"]', '<code>Harus Diisi</code>');
                }
                // $(this).closest('.form-group').find('code').hide().fadeIn(500);
            } else {
                $.post(url, data, function(result) {
                    var DDID_PASIEN     = $('#id').closest('th').hasClass('displayNone');
                    var DDID_ASURANSI   = $('#nama_asuransi').closest('th').hasClass('displayNone');
                    var DDnomorAsuransi = $('#nomor_asuransi').closest('th').hasClass('displayNone');
                    var DDnamaPeserta   = $('#nama_peserta').closest('th').hasClass('displayNone');
                    var DDnamaIbu       = $('#nama_ibu').closest('th').hasClass('displayNone');
                    var DDnamaAyah      = $('#nama_ayah_Input').closest('th').hasClass('displayNone');

                    console.log(result);

                    $('#closeModal').click();
                    $('form#pasienInsertForm').find("input, textarea, select").val("");
                    $('.transition').hide();

                    temp = "<tr style='background-color:orange;'>";

                    if(DDID_PASIEN){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].id + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].id + "</div></td>";
                    }
                    temp += "<td class='nama_pasien'><div class='invisible'>" + caseNama( result[0].nama ) + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].alamat ) + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].tanggal_lahir + "</div></td>";
                    temp += "<td nowrap class='no_telp'><div class='invisible'>" + result[0].no_telp + "</div></td>";
                    if(DDID_ASURANSI){
                        temp += "<td nowrap class='displayNone'><div>" + caseNama( result[0].nama_asuransi ) + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].nama_asuransi ) + "</div></td>";
                    }
                    if(DDnomorAsuransi){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nomor_asuransi + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].nomor_asuransi + "</div></td>";
                    }
                    if(DDnamaPeserta){
                        temp += "<td nowrap class='displayNone'><div>" + caseNama( result[0].nama_peserta ) + "</div></td>";
                    } else{
                        temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].nama_peserta ) + "</div></td>";
                    }
                    if(DDnamaIbu){
                        temp += "<td nowrap class='displayNone'><div>" + caseNama( result[0].nama_ibu ) + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].nama_ibu ) + "</div></td>";
                    }
                    if(DDnamaAyah){
                        temp += "<td nowrap class='displayNone'><div>" + caseNama( result[0].nama_ayah ) + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].nama_ayah ) + "</div></td>";
                    }

                    temp += "<td nowrap class='displayNone'><div>" + result[0].asuransi_id + "</div></td>";
                    temp += "<td nowrap class='displayNone'><div>" + result[0].image + "</div></td>";
                    temp += "<td nowrap nowrap><div class='invisible'><a href=\"#\" style=\"color: green; font-size: large;\" onclick=\"rowEntry(this);return false;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk periksa pasien\"><span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span></a>";

					if ( lewat_antrian > 0) {
						temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + result[0].id + "/edit/" + antrian_id + "\" style=\"color: ##337AB7; font-size: large;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk ubah data pasien\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
					} else {
						temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + result[0].id + "/edit\" style=\"color: ##337AB7; font-size: large;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk ubah data pasien\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
					}
                    temp += "&nbsp;&nbsp;&nbsp;<a onclick='confirmStafModal();' data-value=\"pasiens/" + result[0].id + "\" style=\"color: orange; font-size: large;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk melihat riwayat pasien\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span></a>";

                    temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + MyArray[i].ID_PASIEN + "/transaksi\" style=\"color: ##337AB7; font-size: large;\"><i class='fas fa-money-bill-wave-alt'></i></a>";
					temp += '</td>';
                   temp += "</tr>";

                    $('#ajax').prepend(temp);
                    $('#ajax tr:first-child td div').hide().removeClass('invisible').slideDown('500', function() {
                        $('#ajax tr:first-child').addClass('loaded');
                    });
                });
            }
        });
        $('.required').keypress(function(e) {
            $(this).closest('.form-group').removeClass('has-error');
            $(this).closest('.form-group').find('code').fadeOut('500', function() {
                $(this).closest('.form-group').find('code').remove();
            });
        });

        selectPasien();
		var timeout;
		$("body").on('keyup', '.ajaxselectpasien', function () {
			$('#processing-warning').html('<i class="fa fa-refresh fa-spin fa-fw"></i> <span class="sr-only">Loading...</span> Processing').removeAttr('class').addClass('btn btn-default');
			loaderGif();
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function(){
				clearAndSelectPasien();
			},600);
		});

        $('input[type="radio"][name="opt"]').change(function(e) {
            var $id = $('#id').closest('th');
            var $nama_asuransi = $('#nama_asuransi').closest('th');
            var $nomor_asuransi = $('#nomor_asuransi').closest('th');
            var $nama_peserta = $('#nama_peserta').closest('th');
            var $nama_ibu = $('#nama_ibu').closest('th');
            var $nama_ayah = $('#nama_ayah_Input').closest('th');

            if(this.value == "Nomor Status") {

                $id.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();

            } else if (this.value == "Nama Asuransi") {

                $nama_asuransi.toggleClass('displayNone');

                if(!$id.hasClass('displayNone')){
                   $id.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nomor Asuransi") {

                $nomor_asuransi.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                   $id.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Peserta") {

                $nama_peserta.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Ibu") {

                $nama_ibu.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Ayah") {

                $nama_ayah.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } 
        });
	
	function dummySubmit(control){

		if(
			validatePass2(control)
		){
			$('#submit').click();
		}
	}
	function clearAndSelectPasien(key = 0){
		if($('#paging').data("twbs-pagination")){
			$('#paging').twbsPagination('destroy');
		}
		selectPasien(key);
	}

function selectPasien(key = 0){
	var url = $('form#ajaxkeyup').attr('action');
	var data = $('form#ajaxkeyup').serializeArray();
	data[data.length] = {
		'name' : 'key',
		'value' : key
	};
	var displayed_rows  = $('#displayed_rows').val();
	var DDID_PASIEN     = $('#id').closest('th').hasClass('displayNone');
	var DDID_ASURANSI   = $('#nama_asuransi').closest('th').hasClass('displayNone');
	var DDnomorAsuransi = $('#nomor_asuransi').closest('th').hasClass('displayNone');
	var DDnamaPeserta   = $('#nama_peserta').closest('th').hasClass('displayNone');
	var DDnamaIbu       = $('#nama_ibu').closest('th').hasClass('displayNone');
	var DDnamaAyah      = $('#nama_ayah_Input').closest('th').hasClass('displayNone');


	$.get(url, data, function(hasil) {
		var MyArray = hasil.data;
		console.log('MyArray');
		console.log(MyArray);
		var pages = hasil.pages;
		var rows = hasil.rows;
		var temp = "";
		 for (var i = 0; i < MyArray.length; i++) {
			temp += "<tr";
			if ( MyArray[i].sudah_berobat_bulan_ini ) {
				temp += " class='info' ";
			}
			temp += '>';
			if(DDID_PASIEN){
				temp += "<td nowrap class='displayNone'><div>" + MyArray[i].ID_PASIEN + "</div></td>";
			} else {
				temp += "<td nowrap class=''><div>" + MyArray[i].ID_PASIEN + "</div></td>";
			}
			temp += "<td nowrap><div>" + caseNama( MyArray[i].namaPasien ) + "</div></td>";
			temp += "<td class='kolom_2'><div>" + caseNama( MyArray[i].alamat ) + "</div></td>";
			temp += "<td nowrap class='kolom_3'><div>" + MyArray[i].tanggalLahir + "</div></td>";
			temp += "<td nowrap><div>" + MyArray[i].noTelp + "</div></td>";
			if(DDID_ASURANSI){
				temp += "<td nowrap class='displayNone nama_asuransi'><div>" + caseNama( MyArray[i].namaAsuransi ) + "</div></td>";
			} else {
				temp += "<td nowrap class='nama_asuransi'><div>" + caseNama( MyArray[i].namaAsuransi ) + "</div></td>";
			}
			if(DDnomorAsuransi){
				temp += "<td nowrap class='displayNone'><div>" + MyArray[i].nomorAsuransi + "</div></td>";
			} else {
				temp += "<td nowrap class=''><div>" + MyArray[i].nomorAsuransi + "</div></td>";
			}
			if(DDnamaPeserta){
				temp += "<td nowrap class='displayNone'><div>" + caseNama( MyArray[i].namaPeserta ) + "</div></td>";
			} else{
				temp += "<td nowrap class=''><div>" + caseNama( MyArray[i].namaPeserta ) + "</div></td>";
			}
			if(DDnamaIbu){
				temp += "<td nowrap class='displayNone'><div>" + caseNama( MyArray[i].namaIbu ) + "</div></td>";
			} else {
				temp += "<td nowrap class=''><div>" + caseNama( MyArray[i].namaIbu ) + "</div></td>";
			}
			if(DDnamaAyah){
				temp += "<td nowrap class='displayNone'><div>" + caseNama( MyArray[i].namaAyah ) + "</div></td>";
			} else {
				temp += "<td nowrap class=''><div>" + caseNama( MyArray[i].namaAyah ) + "</div></td>";
			}
			temp += "<td nowrap class='displayNone prolanis_dm'><div>" + MyArray[i].prolanis_dm + "</div></td>";
			temp += "<td nowrap class='displayNone prolanis_ht'><div>" + MyArray[i].prolanis_ht + "</div></td>";
			temp += "<td nowrap class='displayNone asuransi_id'><div>" + MyArray[i].asuransi_id + "</div></td>";
			temp += "<td nowrap class='displayNone pasien_image'><div>" + MyArray[i].image + "</div></td>";
			temp += "<td nowrap nowrap><div><a href=\"#\" style=\"color: green; font-size: large;\" onclick=\"rowEntry(this);return false;\"><span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span></a>";

			if ( lewat_antrian ) {
				temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + MyArray[i].ID_PASIEN + "/edit/" + antrian_id + "\" style=\"color: ##337AB7; font-size: large;\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
			} else {
				temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + MyArray[i].ID_PASIEN + "/edit\" style=\"color: ##337AB7; font-size: large;\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
			}
			temp += "&nbsp;&nbsp;&nbsp;<a data-value='" + MyArray[i].ID_PASIEN + "' onclick='confirmStafModal(this);' href='#' style=\"color: orange; font-size: large;\" ><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span></a> ";
			temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + MyArray[i].ID_PASIEN + "/transaksi\" style=\"color: ##337AB7; font-size: large;\"><i class='fas fa-money-bill-wave-alt'></i></a>";
 
			temp += "</td></tr>";
		 }
		 $('#ajax').html(temp);
		$('#paging').twbsPagination({
			startPage: parseInt(key) +1,
			totalPages: pages,
			visiblePages: 7,
			onPageClick: function (event, page) {
				selectPasien(parseInt( page ) -1);
			}
		});
		$('#rows').html(numeral( rows ).format('0,0'));
		$('.ajax-error-pasien').fadeOut(500);
	}).fail(function(){
		$('.ajax-error-pasien').removeClass('hide').hide()
								.fadeIn(500);
		$('#processing-warning').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error').removeAttr('class').addClass('btn btn-danger');
	}).done(function(){
		$('.ajax-error-pasien').fadeOut(500);

		$('#processing-warning').html('<i class="fa fa-check" aria-hidden="true"></i> Sukses').removeAttr('class').addClass('btn btn-info');
	});
}
        // function rowEntry(control) {


        //     $('#cekBPJSkontrol').hide();
        //     $('#cekGDSBPJS').hide();

			// var nama             = $(control).closest('tr').find('td:nth-child(2) div').html();
			// var image            = $(control).closest('tr').find('td:nth-child(12) div').html();
			// var nama_asuransi    = $(control).closest('tr').find('td:nth-child(6) div').html();
			// var option_asuransi  = '<option value="">- Pilih Pembayaran -</option>';
			// option_asuransi     += '<option value="0">Biaya Pribadi</option>';


			// return false;

			// var ID = $(control).closest('tr').find('td:first-child div').html();

			// var asuransi_id = $(control).closest('tr').find('td:nth-child(11) div').html();

			// cekBPJSkontrol(ID, asuransi_id);

        //     imgError();

        //     if (asuransi_id != '0') {
        //         option_asuransi += '<option value="' + asuransi_id + '">' + nama_asuransi + '</option>'
        //     };

        //     $('#lblInputNamaPasien').html(ID + ' - ' + nama)
        //         .closest('.form-group')
        //         .removeClass('has-error')
        //         .find('code')
        //         .remove();
        //     $('#namaPasien').val(nama);
        //     $('#imageForm').attr('src', image);
        //     $('#ID_PASIEN').val(ID);
        //     $("#ddlPembayaran").html(option_asuransi);
        //     resetComplain();
        //     $('#exampleModal').modal('show');
        //     return false;
        // }
        function resetComplain(){
            $('#timbul').hide();
            $('#modal-footer').show();
            $('#btnComplain').show();
            $('#complain').val('');
            $('#staf_id_complain').val('').selectpicker('refresh');
        }

        function adaComplain(control){
            $(control).hide(0, function(){
                $('#timbul').slideDown(500, function() {
                    $('#staf_id_complain').closest('div').find('.btn-white').focus();
                });
            });
            $('#modal-footer').hide();

        }

        function dummy2(e){

             if($('#antrianpoli_staf_id').val() == '' ||
				$('select#ddlPembayaran').val() == '' ||
				$('#antrianpoli_poli').val() == '' ||
				$('#antrianpoli_antrian').val() == '' ||
				$('#staf_id_complain').val() == '' ||
				$('#komplain').val() == ''

                ){

                    if($('#antrianpoli_staf_id').val() == '' ){
                        validasi('#antrianpoli_staf_id', 'Harus Diisi');
                    }

                    if($('#antrianpoli_poli').val() == '' ){
                        validasi('#antrianpoli_poli', 'Harus Diisi');
                    }

                    if($('#antrianpoli_antrian').val() == '' ){
                        validasi('#antrianpoli_antrian', 'Harus Diisi');
                    }

                    if($('select#ddlPembayaran').val() == '' ){

                        console.log('asuransi_id = ' + $('select#ddlPembayaran').val());
                        validasi('select#ddlPembayaran', 'Harus Diisi');
                    }

                                        if ($('#staf_id_complain').val() == '') {
                        validasi('#staf_id_complain', 'Harus Diisi!')
                    }
                    if ($('#staf_id_complain').val() == '') {
                        validasi('#komplain', 'Harus Diisi!')
                    }
             } else {

               lanjutSubmit(e);
             }
        }

        function lanjutSubmit(e){
			e.preventDefault();
			var pasien_id = $('#ID_PASIEN').val();
			var asuransi_id = $('#ddlPembayaran').val();

			var param = {
				'antrian'		: $('#antrianpoli_antrian').val(), 
				'pasien_id'		: pasien_id,
				'tanggal'		: $('#antrianpoli_tanggal').val()
			};
			$.post(base + '/pasiens/ajax/ajaxpasien', param, function(data) {
				data = JSON.parse(data);
				if(data.antrian == '' && data.pasien == ''){
					if ( $('#antrianpoli_poli').val() == 'usg' ) {
						//window.open(base + "/pdfs/formulir/usg/" + pasien_id + '/'+ asuransi_id);
					}
					$('#submit').click();
				} else {
					if(data.antrian != ''){
						validasi('#antrianpoli_antrian', 'sudah ada antrian <br /> nama : ' + data.antrian);
					}
					if(data.pasien != ''){
						validasi('input[name="pasien_id"]', 'pasien sudah di antrian');
					}
				}
			});
        }

        function modalClose(){
             $('#dummyButton').show();
             $('#dummyButton2').hide();
        }

        function cancelComplain(){
            $('#timbul').hide(0, function(){
                $('#modal-footer').slideDown(500);
                $('#btnComplain').slideDown(500);
                $('#complain').val('');
                $('#staf_id_complain').val('').selectpicker('refresh');
            });
        }
        function confirmStafModal(control){
            var pasien_id = $(control).attr('data-value');
            $('#confirm_staf').modal('show');
            $('#pasien_id_stafs').val(pasien_id);
        }
function confirmStaf(){
    if(validatePass2()){
       $('#submit_confirm_staf').click(); 
    }    
}

function caseNama(nama){
	if (nama == null) {
		return null;
	} else {
		str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
			return letter.toUpperCase();
		}); 
		return str;
	}
}
function cekPromo(control){

	var no_ktp = $(control).val();
	if (no_ktp.length == 16) {
		$.get(base + '/pasiens/ajax/cekPromo',
			{ 'no_ktp' : no_ktp  },
			function (data, textStatus, jqXHR) {
				data = $.trim(data);
				if (parseInt( data ) > 0) {
					$(control).closest('.form-group').find('code').remove();
					$(control).closest('.form-group').removeAttr('class').addClass('form-group has-error');
					$(control).closest('.form-group').append('<span class="help-block">No KTP sudah digunakan Tahun ini</span>')
				} else {
					$(control).closest('.form-group').find('span').remove();
					$(control).closest('.form-group').removeAttr('class').addClass('form-group has-success');
					$(control).closest('.form-group').append('<span class="help-block">Promo bisa digunakan untuk No KTP ini</span>')
				}
			}
		);
	} else {
		$(control).closest('.form-group').find('span').remove();
		$(control).closest('.form-group').removeAttr('class').addClass('form-group has-warning');
		$(control).closest('.form-group').append('<span class="help-block">KTP harus 16 digit</span>')
	}
	 
}
function loaderGif(){
	var colspan = $('#ajax').closest('table').find('thead tr').find('th:not(.displayNone)').length;
	$('#ajax').html(
		"<td colspan='" +colspan+ "'><img class='loader' src='" +base_s3+ "/img/loader.gif' /></td>"
	)
}
function tanggalChange(){
}
    
