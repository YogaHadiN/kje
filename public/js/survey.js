var base = '{{ url("/") }}';
    var totalBiaya = 0;
    var totalAwal = 0;
	var tipe_asuransi = $('#tipe_asuransi').val();


    var data = $('#txtTarif').val();
    data = JSON.parse(data);

    $(document).ready(function() {
		$(window).bind('beforeunload', function(e){
			alert('dada');
		});
        viewTarif(data);
        totalAwal = totalHarga();
        $('.tabelTerapi2 td').click(function(e) {
            $(this).css('color', 'red');
            $(this).append(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
        });

        var dibayar_asuransi_awal = $('#dibayar_asuransi').val();
        asuransiKeyup2(dibayar_asuransi_awal, '#dibayar_pasien');

        formatUangIni();

    });

    function rowDel(control){
        
        data.splice($(control).val(), 1);
        viewTarif(data);
    }

    function viewTarif(data){

        var temp = '';
        var total = 0;

        for (var i = 0; i < data.length; i++) {
			if( parseInt( data[i].biaya ) < 0 ){
				temp += '<tr class="danger">';
			} else {
				temp += '<tr>';
			}
            temp += '<td><label>' + data[i].jenis_tarif + '</label></td>';
            temp += '<td><input class="form-control money" dir="rtl" autocomplete="off" value="' + data[i].biaya + '" id="txt' + data[i].jenis_tarif.replace(/ /g, '') + i + '" onkeyup="inputTarif(this);" /></td>';
            if(data[i].jenis_tarif == 'Biaya Obat'){
                temp += '<td class="text-center"><button type="button" class="btn btn-danger btn-xs" disabled="disabled" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }else{
                temp += '<td class="text-center"><button type="button" class="btn btn-danger btn-xs" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }
        }

		$('.money').autoNumeric('init', {
			aSep: '.',
			aDec: ',', 
			aSign: 'Rp. ',
			vMin: '-9999999999999.99' ,
			mDec: 0
		});

        total = totalHarga();

        $('#tarif').html(temp);
        temp = JSON.stringify(data);
        $('#txtTarif').val(temp);

        var dibayar_asuransi = parseInt(clean( $('#dibayar_asuransi').val() ));
        console.log('view_tarif dibayar asuransi' + dibayar_asuransi);
        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        console.log('total = ' + total);
        totalBiaya = parseInt(total);
        console.log('totalBiaya = ' + totalBiaya);
 
       $('.total').html(totalBiaya);

        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(totalBiaya);
        } else {
            $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        }

        var id = $('#dibayar_pasien').attr('id');
        rupiahDibayarPasien("#" + id);
        $('#dibayar_asuransi').focus();


        $('.total').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number);
        });

        formatUangIni();

         


    }

    function insertTindakan(control){

        var value = $(control).closest('tr').find('select').val();
        var jenis = $(control).closest('tr').find('select option:selected').text();
        value = JSON.parse(value);

        var biaya = value.biaya;
        var periksa_id = $('#periksa_id').html();
        var tarif_id = value.tarif_id;
        var keterangan = null;
        var jenis_tarif = jenis;
        var jenis_tarif_id = value.jenis_tarif_id;

        data[data.length] = {
            'biaya' : biaya,
            'jenis_tarif' : jenis_tarif,
            'jenis_tarif_id' : jenis_tarif_id
        }
        viewTarif(data);
    }



    function asuransiKeyup(control){
        var dibayar_asuransi = $(control).val();
        var BHP = 0;

        dibayar_asuransi = clean(dibayar_asuransi);

        if($('#txtBHP').val() == '0' || $('#txtBHP').val() == undefined || $('#txtBHP').val() == null ){
            BHP = 0;
        } else {
            BHP = $('#txtBHP').val();
        }

        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        
        $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        var dibayar_pasien_baru = $('#dibayar_pasien').val();
        if (dibayar_pasien_baru > 0) {
            $('#pembayaran_pasien').removeAttr('readonly');
        } else if ( dibayar_pasien_baru == 0  ){
            $('#pembayaran_pasien')
            .val(0)
            .attr('readonly', 'readonly');
            rupiahDibayarPasien('#pembayaran_pasien');
            $('#kembalian_pasien').val(0).attr('readonly', 'readonly');;
            rupiahDibayarPasien('#kembalian_pasien');
        } else {
            $('#pembayaran_pasien')
            .val(0)
            .attr('readonly', 'readonly');
        } 
        rupiahDibayarPasien(control);
        rupiahDibayarPasien('#dibayar_pasien');
        formatUangIni();

    }

    function pembayaranKeyup(control){
        var pembayaran = $(control).val();
        pembayaran = cleanUangIni(pembayaran);
        var dibayar_pasien = clean($('#dibayar_pasien').val());
        console.log('dibayar_pasien = ' + $('#dibayar_pasien').val());
        console.log('dibayar_pasien = ' + dibayar_pasien);
        console.log('pembayaran = ' + pembayaran);
        if(pembayaran == ''){
            pembayaran = 0;
        }
        $('#kembalian_pasien').val(parseInt(pembayaran) - parseInt(dibayar_pasien));
        rupiahDibayarPasien(control);
        rupiahDibayarPasien('#kembalian_pasien');
    }

    function dummyClick()
    {
        if($('#dibayar_asuransi').val() == ''){
            validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
        } else {
            $('input[type="submit"]').click();
        }
    }

    function updateTotal(data){
        var temp = '';
        var total = 0;

        total = totalHarga();

        totalBiaya = parseInt(total);

        temp = JSON.stringify(data);
        $('#txtTarif').val(temp);
        var bhp = $('#txtBHP').val();

        var dibayar_asuransi = parseInt($('#dibayar_asuransi').val());
        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
 
       $('.total').html(total);

        var dibayar_asuransi = $('#dibayar_asuransi').val();

        console.log('number dibayar asuransi = ' + dibayar_asuransi);
        console.log('number dibayar total = ' + total);
        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(total);
        } else {
            $('#dibayar_pasien').val(parseInt(total) - parseInt(clean( dibayar_asuransi )));
        }
        console.log($('#dibayar_pasien').val());
        rupiahDibayarPasien('#dibayar_pasien');


        $('.total').each(function() {
            var number = $(this).html();
            console.log('number before = ' + number);
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            number = 'Rp. ' + number;
            console.log('number after = ' + number);
            $(this).html(number);
        });
        formatUangIni();
         
    }

    function totalHarga(){
        var total = 0;
        for (var i = 0; i < data.length; i++) {
            total += parseInt(data[i].biaya);
        }
        return total;
    }

    function submitPage(){
        var submit = true;
        var dibayar_pasien = $('#dibayar_pasien').val();
        dibayar_pasien = cleanUang(dibayar_pasien);
        var pembayaran_pasien = $('#pembayaran_pasien').val();
        var pembayaran_pasien_clean = cleanUang(pembayaran_pasien);

		if( 
			parseInt( $('#asuransi_id').val() ) != 0 &&
			parseInt( $('#asuransi_id').val() ) != 32 &&
			parseInt( cleanUang( $('#dibayar_asuransi').val() ) ) < 1 &&
			parseInt( cleanUang( $('#pembayaran_pasien').val() ) ) > 0
		){
			alert('Tidak bisa dilanjutkan, Kalau Pasien bayar semua sendiri rubah dulu asuransi pasien menjadi Biaya Pribadi');
			return false;
		}
		

        $('.tabelTerapi2 td').each(function(e) {
            if($(this).css('color') !='rgb(255, 0, 0)' ){
                submit = false;
                return false;
            }
        });

		$.get(base + '/periksas/' + periksa_id + '/cek/jumlah/berkas',
			{ periksa_id: periksa_id },
			function (data, textStatus, jqXHR) {
				var jumlah_berkas = $.trim(data)
				if(submit){
					if($('#dibayar_asuransi').val() == ''){
						alert('Asuransi harus diisi walaupun dengan angka 0 ..');
						validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
					}else if(dibayar_pasien > 0 && pembayaran_pasien == '' ){
						alert('Pembayaran harus diisi walaupun dengan angka 0 ..');
						validasi('#pembayaran_pasien', 'harus diisi walau dengan 0');
					}else if( parseInt( dibayar_pasien ) > parseInt( pembayaran_pasien_clean ) ) {
						alert('Pembayaran Pasien tidak benar');
						validasi('#pembayaran_pasien', 'Pembayaran Pasien tidak benar');
					}else if( tipe_asuransi == '3' && parseInt(jumlah_berkas) <1 ) {
						alert('Asuransi Admedika harus diupload Bukti Pemeriksaan Asuransi Yang sudah ditandatangani');
						validasi(':file', 'Harus diupload Bukti Pemeriksaan Asuransi');
					}else { 
						$('#print').click();
						$('.btn').attr('disabled','disabled');
					}
				} else {
				   alert('Mohon Periksa / Cek ulang apakah obat yang akan diberikan sesuai dengan resep!');
				}
			}
		);


    }

    function inputTarif(control) {
      var bhp = $(control).val();
      bhp = clean(bhp);
      var i = $(control).closest('tr').find('button').val();

      if(bhp == ''){
            bhp = 0;
      }

      $('.total').html(parseInt(totalAwal)+parseInt(bhp));
      data[i].biaya = String(bhp);
      updateTotal(data);
    }

    function clean(num) {

        var num = num.replace(/\./g, "");
        num = num.substring(3);
        return num;

    }


    function asuransiKeyup2(control, choose){

        dibayar_asuransi = clean(control);

        if($('#txtBHP').val() == '0' || $('#txtBHP').val() == undefined || $('#txtBHP').val() == null ){
            BHP = 0;
        } else {
            BHP = $('#txtBHP').val();
        }

        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        
        $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        rupiahDibayarPasien(choose);
        formatUangIni();

    }

    function testPrint(){
        var dibayar_pasien = cleanUang($('#dibayar_pasien').val());
        var biaya = 0;
        if (dibayar_pasien != 0) {
            var json = $('#txtTarif').val();
            var MyArray = $.parseJSON(json);
            var temp = '';

            for (var i = 0; i < MyArray.length; i++) {
                temp += '<tr>';
                temp += '<td>' + MyArray[i].jenis_tarif + '</td>'
                temp += '<td>:</td>';
                temp += '<td class="uang text-right">' + MyArray[i].biaya + '</td>';
                temp += '</tr>';

                biaya += parseInt( MyArray[i].biaya );
            }

            var pembayaran = $('#pembayaran_pasien').val();
            var kembalian = $('#kembalian_pasien').val();
            var dibayar_asuransi = cleanUang( $('#dibayar_asuransi').val() );
            console.log('dibayar asuransi =   +++' + dibayar_asuransi);

            if(dibayar_asuransi > 0){
                $('#dibayarAsuransi-print').html(dibayar_asuransi);
            } else {
                $('#dibayarAsuransi-print').closest('tr').addClass('hide');
            }
            
            $('#transaksi-print').html(temp);
            $('#biaya-print').html(biaya);
            $('#pembayaran-print').html(pembayaran +  ',-');
            $('#kembalian-print').html(kembalian +  ',-');
            formatUangIni();
            $('#submitthis').click();

        } else {
            $('#transaksi-print').html('');
            $('#biaya-print').html('');
            $('#submitthis').click();
        }
    
    }
function formatUangIni(){
    $('.uang:not(:contains("Rp."))').each(function() {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html('Rp. ' + number);
    });
}

function cleanUangIni(uang){
    uang = uang.replace(/\./g,'');
    uang = uang.split(" ")[1];
    if (uang == 0) {
        uang = 0;
    }
    return uang;
}


