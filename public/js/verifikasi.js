    $(document).ready(function() {

        $('#confirm_staf').on('show.bs.modal', function(){
            $('#confirm_staf input[type!="hidden"]').val('');
        });

        $('#confirm_staf').on('shown.bs.modal', function(){
            $('#email').focus();
            // setTimeout(function(){ $('#email').focus(); }, 300);
        });

       var request;
        $('#dummyButton').click(function(e) {
                 if(
                    $('select[name="staf_id"]').val() == '' ||
                    $('select#ddlPembayaran').val() == '' ||
                    $('select[name="poli"]').val() == '' ||
                    $('input[name="antrian"]').val() == '' ){

                    if($('select[name="staf_id"]').val() == '' ){
                        validasi('select[name="staf_id"]', 'Harus Diisi');
                    }

                    if($('select[name="poli"]').val() == '' ){
                        validasi('select[name="poli"]', 'Harus Diisi');
                    }

                    if($('input[name="antrian"]').val() == '' ){
                        validasi('input[name="antrian"]', 'Harus Diisi');
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
                    temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].nama ) + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + caseNama( result[0].alamat ) + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].tanggal_lahir + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].no_telp + "</div></td>";
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
                    temp += "<td nowrap nowrap><a href=\"" + base + "/facebook/verified/" + $('#facebook_id').html()  + "/" + result[0].ID_PASIEN + "\" class='btn btn-success btn-block btn-sm' >verifikasi</a></td>";
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

        $('.ajaxselectpasien').keyup(function(e) {
            selectPasien();
        });

        $('#CheckBox1').click(function () {
            if ($(this).is(':checked')) {
                $('.transition').hide().removeClass('displayNone').slideDown('fast', function() {
                    $('#asuransi_id').focus();
                });
            } else if (!$(this).is(':checked')) {
                $('.transition').slideUp(300);
                $('.tog').val('');
            }
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
    });

    function selectPasien(){

            var url = $('form#ajaxkeyup').attr('action');
            var data = $('form#ajaxkeyup').serializeArray();

            var DDID_PASIEN = $('#id').closest('th').hasClass('displayNone');
            var DDID_ASURANSI = $('#nama_asuransi').closest('th').hasClass('displayNone');
            var DDnomorAsuransi = $('#nomor_asuransi').closest('th').hasClass('displayNone');
            var DDnamaPeserta = $('#nama_peserta').closest('th').hasClass('displayNone');
            var DDnamaIbu = $('#nama_ibu').closest('th').hasClass('displayNone');
            var DDnamaAyah = $('#nama_ayah_Input').closest('th').hasClass('displayNone');

            $.get(url, data, function(MyArray) {
                MyArray = $.parseJSON(MyArray);
                var temp = "";
                 for (var i = 0; i < MyArray.length; i++) {
                    temp += "<tr>";
                    if(DDID_PASIEN){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].ID_PASIEN + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].ID_PASIEN + "</div></td>";
                    }
                    temp += "<td nowrap><div>" + caseNama( MyArray[i].namaPasien ) + "</div></td>";
                    temp += "<td><div>" + caseNama( MyArray[i].alamat ) + "</div></td>";
                    temp += "<td nowrap><div>" + MyArray[i].tanggalLahir + "</div></td>";
                    temp += "<td nowrap><div>" + MyArray[i].noTelp + "</div></td>";
                    if(DDID_ASURANSI){
                        temp += "<td nowrap class='displayNone'><div>" + caseNama( MyArray[i].namaAsuransi ) + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + caseNama( MyArray[i].namaAsuransi ) + "</div></td>";
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

                    temp += "<td nowrap class='displayNone'><div>" + MyArray[i].asuransi_id + "</div></td>";
                    temp += "<td nowrap class='displayNone'><div>" + MyArray[i].image + "</div></td>";
                    temp += "<td nowrap nowrap><div><a href=\"" + base + "/facebook/verified/" + $('#facebook_id').html()  + "/" + MyArray[i].ID_PASIEN + "\" class='btn btn-success btn-block btn-sm'>verifikasi</a></td>";
         
                    temp += "</tr>";
                 }
                 $('#ajax').html(temp);
            });
    }
        function rowEntry(control) {
            var ID = $(control).closest('tr').find('td:first-child div').html();
            var nama = $(control).closest('tr').find('td:nth-child(2) div').html();
            var asuransi_id = $(control).closest('tr').find('td:nth-child(11) div').html();
            var image = $(control).closest('tr').find('td:nth-child(12) div').html();
            var nama_asuransi = $(control).closest('tr').find('td:nth-child(6) div').html();
            var option_asuransi = '<option value="">- Pilih Pembayaran -</option>';
            option_asuransi += '<option value="0">Biaya Pribadi</option>';

            $('#cekBPJSkontrol').hide();
            $('#cekGDSBPJS').hide();
             console.log('ID = ' + ID);
             console.log('nama = ' + nama);
             console.log('asuransi_id = ' + asuransi_id);
             console.log('image = ' + image);
             console.log('nama_asuransi = ' + nama_asuransi);
             console.log('option_asuransi = ' + option_asuransi);

             if (asuransi_id == '32') {
                $.post(base + '/pasiens/ajax/cekbpjskontrol', {'pasien_id': ID, 'asuransi_id' : asuransi_id}, function(data, textStatus, xhr) {
                  /*optional stuff to do after success */
                  MyArray = $.parseJSON(data);
                  var data = MyArray.kode;
                  var tanggal = MyArray.tanggal;
                  if (tanggal == '') {
                    var text = 'GDS gratis untuk BPJS hanya untuk riwayat kencing manis atau usia > 50 tahun usia pasien saat ini ' + MyArray.tanggal_lahir;
                  } else {
                    var text = 'Pasien sudah periksa GDS bulan ini tanggal ' + tanggal;
                  }
                  $('#karena').html(text)

                  if (data == '3') {
                    $('#cekBPJSkontrol').show();
                    $('#cekGDSBPJS').show();
                  } else if(data == '2'){
                    $('#cekBPJSkontrol').show();
                    $('#cekGDSBPJS').hide();
                  } else if(data == '1'){
                    $('#cekBPJSkontrol').hide();
                    $('#cekGDSBPJS').show();
                  } else {
                    $('#cekBPJSkontrol').hide();
                    $('#cekGDSBPJS').hide();
                  }
                });
             } else {
              $('#cekBPJSkontrol').hide();
             }

             imgError();

            if (asuransi_id != '0') {
                option_asuransi += '<option value="' + asuransi_id + '">' + nama_asuransi + '</option>'
            };

            $('#lblInputNamaPasien').html(ID + ' - ' + nama)
                .closest('.form-group')
                .removeClass('has-error')
                .find('code')
                .remove();
            $('#namaPasien').val(nama);
            $('#imageForm').attr('src', image);
            $('#ID_PASIEN').val(ID);
            $("#ddlPembayaran").html(option_asuransi);
            resetComplain();
            $('#exampleModal').modal('show');
            return false;


        }
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

             if($('select[name="staf_id"]').val() == '' ||
                    $('select#ddlPembayaran').val() == '' ||
                    $('select[name="poli"]').val() == '' ||
                    $('input[name="antrian"]').val() == '' ||
                    $('#staf_id_complain').val() == '' ||
                    $('#komplain').val() == ''

                ){

                    if($('select[name="staf_id"]').val() == '' ){
                        validasi('select[name="staf_id"]', 'Harus Diisi');
                    }

                    if($('select[name="poli"]').val() == '' ){
                        validasi('select[name="poli"]', 'Harus Diisi');
                    }

                    if($('input[name="antrian"]').val() == '' ){
                        validasi('input[name="antrian"]', 'Harus Diisi');
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
                $.post(base + '/pasiens/ajax/ajaxpasien', {antrian: $('input[name="antrian"]').val(), 'pasien_id' : $('#ID_PASIEN').val()}, function(data) {

                    data = JSON.parse(data);
                    if(data.antrian == '' && data.pasien == ''){
                        $('#submit').click();
                    } else {
                        if(data.antrian != ''){
                            validasi('input[name="antrian"]', 'Sudah ada antrian <br /> nama : ' + data.antrian);
                        }
                        if(data.pasien != ''){
                            validasi('input[name="pasien_id"]', 'Pasien sudah di antrian');
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
    if(validatePass()){
       $('#submit_confirm_staf').click(); 
    }    
}

function caseNama(nama){
	str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	}); 
	return str;
}


    
