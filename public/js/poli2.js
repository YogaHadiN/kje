
    var addSatu = false;
    var id_formula_sirup_add = '';
    var gen_presc_index = 0;
    var gen_presc_json = '';
    var total_afi_count = 0;
    var temp_sop_terapi = [];
    var length_sop_terapi = '';
    var i_sop_terapi = 0;


     if($('#terapi').val() == '' || $('#terapi').val() == '[]'){

            var data = [];

        } else {

            var data = JSON.parse($('#terapi').val());
            viewResep(resepJson($('#terapi').val())[1]);
        }
     if($('#tindakan').val() == '' || $('#tindakan').val() == '[]'){

            var dataTindakan = [];

        } else {

            var dataTindakan = JSON.parse($('#tindakan').val());
            $('#ajaxTindakan').html(viewTindakan(dataTindakan));
        }

   jQuery(document).ready(function($) {

        $('#labelKecelakaanKerja').popover('show');

        $('#tab-status').on('shown.bs.tab', function (e) {
            $('#anamnesa').focus();
        });

        $('#tab-resep').on('shown.bs.tab', function (e) {
            namaObatFocus();
            var anamnesa = $('#anamnesa').val();
            var pf = $('#pemeriksaan_fisik').val();

            if (anamnesa != '' || pf != '' ) {
                var temp = '<div class="alert alert-warning">';
                temp += anamnesa + ' | ' + pf;
                temp += '</div>'
            }

            $('#resume').html(temp);
        });

        $('#keterangan_diagnosa').keypress(function(e) {
            var key = e.keyCode || e.which;

            if (key == 9) {
                $('#tab-resep').tab('show');
            }
        });

        $('#modalTindakan').on('shown.bs.modal', function () {
           $('#selectTindakan').closest('td').find('.btn-white').focus();
        });

        $('#btn_auto').click(function(e) {
            if ($('#bb_input').val() == '') {
                var bb_input = '55';
            } else {
                var bb_input = $('#bb_input').val();
            }
            $('#bb_aktif').val(bb_input);

            var bb = $('#bb_aktif').val();
            $('#berat_badan').val(bb);


            $.get(base + '/alloption2', {'bb': bb}, function(data) {
                data = $.parseJSON(data);
                var berat_badan = data.berat_badan;
                data = data.temp;
                data = JSON.stringify(data);
                customOption2a(data, berat_badan);
            });
        });

        $('#btn_auto_off').click(function(e) {
            optionSemua(getIdMerek());
        });

        $('#inputSigna').keyup(function(e) {
            var key = e.keyCode || e.which;
            if(key != 13 || key != 38 || key != 40 || key != 9){
                $.post(base + "/poli/ajax/selectsigna", {'signa' : $(this).val()}, function(data) {
                    data = JSON.parse(data);
                    var temp = '';
                    for (var i = data.length - 1; i >= 0; i--) {
                        temp += '<tr>';
                        temp += '<td>' + data[i].id + '</td>';
                        temp += '<td>' + data[i].signa + '</td>';
                        temp += '<td><button type="button" class="btn btn-success btn-xs" value="' + data[i].id + '" onclick="pilihSigna(this)">pilih</button></td>';
                        temp += '</tr>';
                    }

                    if(data.length == 0){
                        temp = '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>'
                    }
                    $('#tblSigna tbody').html(temp);
                });
            }
        });

        $('#inputAturanMinum').keyup(function(e) {
            var key = e.keyCode || e.which;
            if(key != 13 || key != 38 || key != 40 || key != 9){
                $.post(base + "/poli/ajax/selectatur", {'aturan' : $(this).val()}, function(data) {
                    data = JSON.parse(data);
                    var temp = '';
                    for (var i = data.length - 1; i >= 0; i--) {
                        temp += '<tr>';
                        temp += '<td>' + data[i].id + '</td>';
                        temp += '<td>' + data[i].aturan_minum + '</td>';
                        temp += '<td><button type="button" class="btn btn-success  btn-xs" value="' + data[i].id + '" onclick="pilihAturanMinum(this)">pilih</button></td>';
                        temp += '</tr>';
                    }

                    if(data.length == 0){
                        temp = '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>'
                    }
                    $('#tblAturanMinum tbody').html(temp);
                });
            }
        });

        // untuk mencari ICD 10 diagnosa
        $('.search').keyup(function(e) {
            var key = e.keyCode || e.which;
            if(key != 38 && key != 40 && key != 13){
                table_ICD();
            }
        });

        //keypress pencarian modal diagnosa pertama
        $('.search').on('keypress', function (e) {
            var rowI = $('table#GridView4 tbody tr').filter(function () {
                var match = 'rgb(51, 122, 183)';
                return ($(this).css('background-color') == match);
            }).index();
            var key = e.keyCode || e.which;
            if (key == 13 && rowI != -1) {
               confirmICD();
            } else if (key == 40 && rowI == -1) {
    
                $('table#GridView4 tbody tr:first-child').toggleClass('rowHighlight');
            } else if (key == 40 && rowI != -1 && rowI != 9) {
                var rowI = $('table#GridView4 tbody tr').filter(function () {
                    var match = 'rgb(51, 122, 183)';
                    return ($(this).css('background-color') == match);
                }).index();
                var rowBefore = parseInt(rowI) + 1;
                var rowAfter = parseInt(rowI) + 2;

                $('table#GridView4 tbody tr:nth-child(' + rowBefore + ')').toggleClass('rowHighlight');
                $('table#GridView4 tbody tr:nth-child(' + rowAfter + ')').toggleClass('rowHighlight');
            } else if (key == 38 && rowI != -1 && rowI != 0) {
                var rowI = $('table#GridView4 tbody tr').filter(function () {
                    var match = 'rgb(51, 122, 183)';
                    return ($(this).css('background-color') == match);
                }).index();
                var rowBefore = parseInt(rowI) + 1;
                var rowAfter = rowI;
                $('table#GridView4 tbody tr:nth-child(' + rowBefore + ')').toggleClass('rowHighlight');
                $('table#GridView4 tbody tr:nth-child(' + rowAfter + ')').toggleClass('rowHighlight');
            }
        });

        //keypress pencarian modal diagnosa kedua untuk mencari / menginput Diagnosa baru
        $('#tambahDiagnosa').on('keypress', function (e) {
            var rowI = $('table#GridView2 tbody tr').filter(function () {
                var match = 'rgb(51, 122, 183)';
                return ($(this).css('background-color') == match);
            }).index();

            var $ini = $(this);
            var last = parseInt($('table#GridView2 tbody tr:last').index());

            var key = e.keyCode || e.which;

            if (key == 13 && rowI == -1 && $ini.val() != '') {
                insertDiagnosa();
            } else if(key == 13 && rowI == -1 && $ini.val() == ''){

                alert("Untuk masukkan diagnosa input harus diisi");
                $ini.focus();
                return false;

            } else if (key == 13 && rowI != -1) {

                confirmDiagnosa();

            } else if (key == 40 && rowI == -1) {
                $('table#GridView2 tbody tr:first-child').toggleClass('rowHighlight');
                $('#tambahDiagnosa').val('');
            } else if (key == 40 && rowI != last) {

                var rowBefore = parseInt(rowI) + 1;
                var rowAfter = parseInt(rowI) + 2;

                $('table#GridView2 tbody tr:nth-child(' + rowBefore + ')').toggleClass('rowHighlight');
                $('table#GridView2 tbody tr:nth-child(' + rowAfter + ')').toggleClass('rowHighlight');
                $('#tambahDiagnosa').val('');

            } else if (key == 40 && rowI == last) {

                return false;

            } else if (key == 38 && rowI != -1 && rowI != 0) {
                var rowI = $('table#GridView2 tbody tr').filter(function () {
                    var match = 'rgb(51, 122, 183)';
                    return ($(this).css('background-color') == match);
                }).index();

                var rowBefore = parseInt(rowI) + 1;
                var rowAfter = rowI;

                $('table#GridView2 tbody tr:nth-child(' + rowBefore + ')').toggleClass('rowHighlight');
                $('table#GridView2 tbody tr:nth-child(' + rowAfter + ')').toggleClass('rowHighlight');
                $('#tambahDiagnosa').val('');

            } else if (key == 38 && rowI == 0) {
                return false;

            } else {
                var rowI = $('table#GridView2 tbody tr').filter(function () {
                    var match = 'rgb(51, 122, 183)';
                    return ($(this).css('background-color') == match);
                }).index();

                var rowHighlight = parseInt(rowI) + 1;
                $('table#GridView2 tbody tr:nth-child(' + rowHighlight + ')').toggleClass('rowHighlight');
            }
        });
       // Validasi jika anamnesa dan diagnosa belum diisi, maka gagal menginput
    $('#LinkButton2').click(function () {
        var puyer = $('#puyer').val();
        var boolAdd = $('#boolAdd').val();

        if (boolAdd == '1' || puyer == '1') {

            alert('Puyer atau Add Sirup belum selesai. Resep tidak bisa dilanjutkan sebelum diselesaikan');
            return false

        }

        if ($('#anamnesa').val() == '' || $('#ddlDiagnosa').val() == '') {
            alert('Anamnesa dan Diagnosa tidak boleh dikosongkan!!');
            $('#tab-status').tab('show');
            if($('#anamnesa').val() == '' ){
                validasi('#anamnesa', 'Harus Diisi!');
            }
            if($('#ddlDiagnosa').val() == '' ){
                validasi2('#ddlDiagnosa', 'Harus Diisi!');
            }
            return false;
        } else {
            // submit berhasil
            $('#submitFormPeriksa').click();
        }
    });

    //ketika exampleModal ditutup mereset example Modal = memilih ICD
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('#byICD').val('');
        $('#byDiagnosa').val('').focus();
        table_ICD();
    });

    //ketika di klik, maka tabel di exampleModal = pencarian ICD akan menyala (highlight)
    $(document).on('click', 'table#GridView4 tbody tr', function(e) {
        $('.rowHighlight').toggleClass('rowHighlight');
        $(this).toggleClass('rowHighlight');
        $('#byDiagnosa').focus();
    });

    //ketika di klik, maka tabel di pencarian diagnosa akan menyala (highlight)
    $(document).on('click', 'table#GridView2 tbody tr', function(e) {
        $('.rowHighlight').toggleClass('rowHighlight');
        $(this).toggleClass('rowHighlight');
        $('#tambahDiagnosa').focus();
    });

    //ketika di klik untuk konfirmasi memilih ICD, maka ICD telah dipilih, tapi kalau belum dipilih, munculkan alert
    $(document).on('click', '#confirmICD', function(e) {
        var rowI = $('table#GridView4 tbody tr').filter(function () {
            var match = 'rgb(51, 122, 183)';
            return ($(this).css('background-color') == match);
        }).index();
        if(rowI != -1){
            confirmICD();
        } else {
            alert('pilih dulu ICD nya');
        }
    });
    
    //ketika memunculkan modal diagnosa yang kedua, kosongkan dulu isinya
    $('#exampleModal1').on('show.bs.modal', function () {
        $('input#tambahDiagnosa').val('').keyup().focus();
    });

    $('#inputTindakanSubmit').keypress(function(e) {
        var key = e.keyCode || e.which;
        if( key == 9 ){
             $('#inputTindakanSubmit').click();
             return false;
        }
    });
    // valueTextArea();
    $('#modalTindakan').on('hidden.bs.modal', function () {

        var MyArray = dataTindakan;
        var temp = '';

        for (var i = 0; i < MyArray.length; i++) {
            temp += MyArray[i].jenis_tarif + ' : ' + MyArray[i].keterangan_tindakan + ', \n';
        }

        $('#pemeriksaan_penunjang').val(temp).focus();
    });
    $('#selectTindakan').change(function(event) {
        /* Act on the event */
        if($(this).val() == '2398' && $('#ID_ASURANSI').val() == '32' && $('#sudahGDS').val()){
            alert('Pasien sudah pernah periksa GDS dengan menggunakan BPJS bulan ini pada tanggal ' + $('#sudahGDS').val() + ', beban biaya sebesar Rp.15.000,- akan dibayar tunai oleh pasien di kasir jika ingin melanjutkan');
        } else if ($('#ID_ASURANSI').val() == '32' ) {
            $.ajax({
                url: 'cekBPJSDitanggung.php',
                type: 'POST',
                data: {ID_TARIF: $('#selectTindakan').val()},
            })
            .done(function(result) {
                result = $.trim(result);
                if (result != ''){
                    alert(result);
                }
            })
            .fail(function() {
                console.log("error");
            })
            .complete(function() {
                console.log("complete");
            });
            return false;
        }
    });

    //BUAT supaya tab kontraindikasi terpilih saat load
        //Tampilkan resep yang sudah pernah dibuat
       // tabelTerapi();
       //ketika modal ditutup secara otomatis akan focus di Select Pilihan Obat
       // $('#modal').on('hidden.bs.modal', function () {
       //     namaObatFocus(); 
       //  });

       //ketika load otomatis focus ada di select pilihan obat
       //perintah untuk menampilkan modal untuk memasukkan signa baru

       $('#modalSigna').on('hidden.bs.modal', function (e) {
            $('#ddlsigna').closest('div').find('.btn-white').focus();
        });

        $('#modalAturanMinum').on('hidden.bs.modal', function (e) {
            $('#ddlAturanMinum').closest('div').find('.btn-white').focus();
        });


       //perintah untuk memberikan perintah klik bila tombol Tab ditekan dan focus ada di tombol
      $('#inputResep').keypress(function(e) {
        var $ini = $(this);
        var key = e.keyCode || e.which;

        if( key == 9 || key == 13 ){
            $ini.click();
        }
        return false;
      });

      //perintah yang diberikan bila Select tipe resep diganti opsi nya
  $('#tipeResep').change(function() {
        var tipe = $(this).val();
        var id = getIdMerek();
    

        // bila dirubah ke tipe 1 adalah puyer
        if(tipe == "1") {
            //hilangkan signa dan aturan minum obat, isian jumlah tetap dipertahankan
            //signa -1 adalah puyer
            hideTipeResepPuyer(id);

        // bila dirubah ke tipe 2 adalah add sirup
        } else if (tipe == "2"){
            hideTipeResepSirup(id);
        // bila dirubah ke tipe 0 adalah standar resep dewasa
        } else if (tipe == "0") {
            // direset pilihan signa, aturanminum, dan jummlah
            $('#ddlsigna').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#ddlAturanMinum').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);
            //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
            optionSemua(id);
        }
  });
    //perintah yang diberikan jika pilihan obat berubah
     $('#ddlNamaObat').change(function() {
        //i adalah ID_MEREK yang terpilih dari pilihan obat
        var dataObat = JSON.parse($(this).val());
        var i = dataObat.merek_id;


        // tipe resep 1 = puyer, ID_MEREK -1 DAN -3 ADALAH kertas puyer biasa dan sablon
        if($('#tipeResep').val() == "1" && (i == "-1" || i == "-3")) {
            //jika kertas puyer (-3/-1) terpilih pada tipe resep puyer (1), maka, 
            //tampilkan kembali semua item
            //dan tipe resep dikembalikan lagi menjadi tipe resep standar (0)
            $('#ddlsigna').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#tipeResep').val('0').selectpicker('refresh');
            //kembalikan lagi opsi pilihan obat sehingga semua obat bisa diakses
            optionSemua(i);
            // jika item selesaikan puyer ada dalam html. maka kembalikan semua ke standar
            if($('#selesaikanPuyer').html()){
                selesaiPuyer($('#selesaikanPuyer'));
            }
        } else if($('#tipeResep').val() == "2" && i == "-2") {
            $('#txtjumlah').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            $('#ddlsigna').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#tipeResep').val('0').selectpicker('refresh');
            optionSemua(i);
            if($('#selesaikanAdd').html()){
                selesaiAdd($('#selesaikanAdd'));
            }
        }
        //Kode untuk Automator
        var aturan_minum_id = getAturanMinumId();
        console.log(aturan_minum_id);
        $('#ddlAturanMinum').val(aturan_minum_id).selectpicker('refresh');


        if ($('#bb_aktif').val() != '' && $('#ddlNamaObat').val() != '') {

            var dose = $('#ddlNamaObat option:selected').attr('data-dose');
            dose = $.parseJSON(dose);
            var signa_id = dose.signa_id;
            var jumlah = dose.jumlah;

            $('#txtjumlah').val(jumlah);
            $('#ddlsigna').val(signa_id).selectpicker('refresh');


            console.log('signa_id = ' + signa_id);
            console.log('jumlah = ' + jumlah);
            console.log('aturan_minum_id = ' + aturan_minum_id);
        }
        // Munculkan peringatan obat
        if($(this).val() != ''){

            var peringatan = $('#ddlNamaObat option:selected').attr('data-peringatan');
            var ingat = '';

            if (peringatan != 'null') {

                ingat = peringatan;

                var merek = $('#ddlNamaObat option:selected').text();

                var pesan = '<div class="panel panel-danger" id="isi_pesan"><div class="panel-heading"><h1 class="panel-title">' + merek + '</h1></div><div class="panel-body">' + ingat + '</div></div>';

                $('#peringatan').html(pesan);

                $('#isi_pesan').hide().slideDown(500);

            } else {

                $('#isi_pesan').slideUp(500, function(){
                    $(this).remove();
                });
            }

        }
        //Munculkan peringatan kalau obat tidak ditanggung BPJS
        if ($('#asuransi_id').val() == '32') {
            if($(this).val() != ''){
                var merek = $('#ddlNamaObat option:selected').text();
                var fornas = $('#ddlNamaObat option:selected').attr('data-fornas');
                if (fornas == '0') {
                    $('#isi_pesan_fornas').remove();
                    var text = '<div class="alert alert-danger" id="isi_pesan_fornas">' + merek + ' <strong>tidak ditanggung BPJS</strong></div>';
                    $('#peringatan').prepend(text);
                    $('#isi_pesan_fornas').hide().fadeIn(500);
                } else {
                    $('#isi_pesan_fornas').fadeOut(500, function() {
                        $(this).remove();
                    });
                }
            }
        }

        if ($('#hamil').val() == '1') {
            $.post( base + '/poli/ajax/pregsafe', {'merek_id': $(this).val() }, function(data) {
                data = $.trim(data);
                if (data != '') {
                    console.log(data);
                    data = $.parseJSON(data);

                    $('#legendpop').attr({
                        'title'  : $('#ddlNamaObat option:selected').text(),
                        'data-original-title'  : $('#ddlNamaObat option:selected').text(),
                        'data-content': 'Obat memiliki kandungan ' + data.generik + ' pregnancy safety index = ' + data.pregnancy_safety_index
                    }); 

                    $('#legendpop').popover('show');
                } else {
                    $('#legendpop').popover('hide');
                }
            });
        } else if ($(this).val() == '150805003'){
            $('#legendpop').attr({

                'title'  : 'Decafil tabet 150 mg',
                'data-original-title'  : 'Decafil tabet 150 mg',
                'data-content': 'Jika pasien sudah biasa/sering sesak nafas, decafil diberikan 20 tablet agar pasien tidak perlu bolak-balik ke klinik, termasuk dan terutama pasien BPJS'
            }); 
            $('#legendpop').popover('show');
        }else {
            $('#legendpop').popover('hide');
        }

      });

    $('[data-toggle="popover"]').popover()
    

    sesuaikanResep();

    $('#pemeriksaan_penunjang').keypress(function(e) {
        var key = e.keyCode || e.which;
        if ( key != 9 ){
            $('#modalTindakan').modal('show');
            $(this).blur();
            return false;
        }
    });
     setTimeout(function(){ 
       $('#anamnesa').focus();
     }, 500);

     $('.afi_count').keyup(function(e) {
        afiCount();
     });




}); //end document.ready

function afiCount(){
     $('.afi_count').each(function(index, el) {
        var count = $(this).val();
        console.log('count before = ' + count)
        count = count.replace(",", "."); // sudah bisa mereplace karakter ','
        count = count.replace(' ', ''); // sudah bisa mereplace karakter spasi (' ')
        if (count == '') {
            count = 0;
        }
        total_afi_count += parseFloat(count);
     });
     $('#total_afi').val(total_afi_count + ' cm');
     total_afi_count = 0;
}

function getDiagnosaByICD(ICD){
     $.ajax({
            url: base + "/poli/ajax/diag", 
            type: 'GET',
            data: {icd10 : ICD  } 
        })
        .done(function(messages) {
            data = JSON.parse(messages);
            var temp = "";

            for (var i = 0; i < data.length; i++) {
                temp += '<tr class="anchor2">';
                temp += '<td>' + data[i].id + '</td>';
                temp += '<td>' + data[i].diagnosa + '</td>';
                temp += '</tr>';
            }

            $('#ajax4').html(temp);
            $('#tambahDiagnosa').val('').focus();
        })
        .fail(function() {
            alert("Error!");
        });
}

function insertDiagnosa(){
    var ICD = $('#lblICD').html();
    var diagnosaUmum = $('#tambahDiagnosa').val();
     $.ajax({
            url: base + "/poli/ajax/indiag",
            type: 'POST',
            data: {icd10 : ICD, diagnosa : diagnosaUmum}
        })
        .done(function(data) {
            data = $.trim(data);
            if(data == '0'){
                alert(diagnosaUmum + ' GAGAL diinput');

            } else if(data == '01'){

                validasi('#tambahDiagnosa', 'Sudah ada!!');
                
            } else {

                data = JSON.parse(data);
                alert(diagnosaUmum + ' berhasil diinput');
                getDiagnosaByICD(ICD);
                var opt = '<option value="' + data.id +'">' + data.diagnosa + ' - ' + data.diagnosaICD + '</option>';
                $('#ddlDiagnosa').append(opt).selectpicker('refresh');

            }
        })
        .fail(function() {
            alert("Error!");
        });
}

function confirmICD(){
    var ICD = $('table#GridView4 tbody tr').filter(function () {
        var match = 'rgb(51, 122, 183)';
        return ($(this).css('background-color') == match);
    }).find('td:first-child').html();
    var Diag = $('table#GridView4 tbody tr').filter(function () {
        var match = 'rgb(51, 122, 183)';
        return ($(this).css('background-color') == match);
    }).find('td:nth-child(2)').html();
    $('#lblICD').html(ICD);
    $('#lblDiagnosaICD').html(Diag);
    getDiagnosaByICD(ICD);
    $('#showModal2').click();
    $('#hideModal1').click();
}

function confirmDiagnosa(){
    var idDiagnosa = $('table#GridView2 tbody tr').filter(function () {
        var match = 'rgb(51, 122, 183)';
        return ($(this).css('background-color') == match);
    }).find('td:first-child').html();
    $('#ddlDiagnosa')
        .val(idDiagnosa)
        .selectpicker('refresh');
    $('#diagnosa').val(idDiagnosa);
    $('#hideModal2').click();
    $('#keterangan_diagnosa').focus();
}

function table_ICD(){
    $.post(base + '/poli/ajax/pilih', {'byICD': $('#byICD').val(), 'byDiagnosa' : $('#byDiagnosa').val()}, function(data) {

        var temp = '';
        for (var i = 0; i < data.length; i++) {
            temp += '<tr class="anchor2">';
            temp += '<td>' + data[i].id + '</td>';
            temp += '<td>' + data[i].diagnosaICD + '</td>';
            temp += '</tr>';
        };
        $('#temp').html(temp);
    });
}

//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================

 function insertTerapi(){

    var MER = $('#ddlNamaObat option:selected').text();
    var juml = $('#txtjumlah').val();
    var ID_SIG = $('#ddlsigna').val();
    var ID_ATU = $('#ddlAturanMinum').val();
    var pattern = /syrup/;
    var sirup = pattern.test(MER);
    var attr = $('#ddlNamaObat').attr('disabled');

    if (typeof attr !== typeof undefined && attr !== false) {
        $('#ddlNamaObat').removeAttr('disabled').selectpicker('refresh');
    }

    var attr = $('#tipeResep').attr('disabled');

    if (typeof attr !== typeof undefined && attr !== false) {
        $('#tipeResep').removeAttr('disabled').selectpicker('refresh');
    }

    if($('#ddlNamaObat').val() == '' || juml == '' || ID_SIG == '' || ID_ATU == ''){

        if($('#ddlNamaObat').val() == ''){
            validasi('#ddlNamaObat', 'Harus Diisi!');
        };
        if($('#txtjumlah').val() == ''){
            validasi('#txtjumlah', 'Harus Diisi!');
        };
        if($('#ddlsigna').val() == ''){
            validasi2('#ddlsigna', 'Harus Diisi!');
        };
        if($('#ddlAturanMinum').val() == ''){
            validasi2('#ddlAturanMinum', 'Harus Diisi!');
        };

    } else if(sirup && juml > 1) {

        var r = confirm('Anda akan menginput SIRUP DALAM JUMLAH BANYAK, hal ini tidak lazim dan bisa merupakan suatu kesalahan. Lanjutkan?');
        if(r){
            insert();
        }

    } else if(juml > 20) {

        var r = confirm('Jumlah nya bisa jadi terlalu banyak. Lanjutkan?');
        if(r){
            insert();
        }

    } else {

        var ID_FOR = getIdFormula();
        var Merek = '';

        var sama = false;
        if(data.length > 0){
            for (var i = 0; i < data.length; i++) {
                if(data[i].formula_id == ID_FOR){
                    sama = true;
                    Merek = data[i].merek;
                    break;
                }
            }
        }
        if(!sama){
            insert();
        } else {

            var r = confirm('Formula yang sama sudah dimasukkan dengan Nama = ' + Merek + ', Lanjutkan?');
            if (r){
                insert();
            }
        }
    }
    // bagian ini khusus dilakukan jika tipe_asuransi == 4 / flat
    // 


}
function informasi(control){
    var ID = $(control).data('value');


    $.post( base + '/poli/ajax/ajxobat', { 'merek_id' : ID }, function(data) {
        /*optional stuff to do after success */
        data = $.parseJSON(data);
        var MyArray = data.komposisis;
        var temp = '';

        for (var i = 0; i < MyArray.length; i++) {
            temp += '<tr>';
            temp += '<td>' + MyArray[i].komposisi + '</td>';
            temp += '<td>' + MyArray[i].pregnancy_safety_index + '</td>';
            temp += '</tr>';
        }

        $('#nama_obat').text($(control).text());

        $('#kontraindikasi').html(data.kontraindikasi);
        $('#indikasi').html(data.indikasi);
        $('#efek_samping').html(data.efek_samping);
        $('#tabel_komposisi').html(temp);

    });
}

    function formSigna(){
        $.ajax({
            url: 'ajaxSigna.php',
            type: 'POST',
            data: {},
        })
        .done(function(result) {
            result = $.trim(result);
            $('#ajax6').html(result);
        })
        .fail(function() {
            console.log("error");
        })
        .complete(function(){
           $('#GridView4').dataTable({
              responsive: true,
            });
            $('#inputSigna').val('');
            $('#modalSigna input.input-sm').keypress(function(e) {
               var key = e.keyCode || e.which;
               if ( key == 13 ) {
                    insertSigna();
                    console.log('enter');
               }
           });
        });
        return false;
    }

    //ajax5
    $('#inputAturanMinum').focus();

    var ID_SIGNA_BARU = "";
    function insertSigna(){
        var signa = $('#inputSigna').val();
        if(signa != ''){
            $.ajax({
                url: base + "/poli/ajax/insigna",
                type: 'POST',
                data: {signa : signa},
            })
            .done(function(result) {

                data = JSON.parse(result);

                if(data.warning != ''){
                    validasi('#inputSigna', data.warning);
                }else{
                    var opt = '<option value="' + data.id + '">' + signa + '</option>';
                    $('#ddlsigna').append(opt).selectpicker('refresh');
                    var MyArray = data.temp;
                    var temp = '';

                    for (var i = 0; i < MyArray.length; i++) {
                        temp += '<tr>';
                        temp += '<td>' + MyArray[i].id + '</td>';
                        temp += '<td>' + MyArray[i].signa + '</td>';
                        temp += '<td><button class="btn btn-success btn-xs" value="' + MyArray[i].id + '" onclick="pilihSigna(this)">Pilih</button></td>';
                        temp += '</tr>';
                    }

                    $('#tblSigna tbody').html(temp);
                }
            })
            .fail(function() {
                console.log("error");
            });
            return false;
        } else {
            validasi('#inputSigna', 'Input Tidak Boleh Kosong');
            $('#inputSigna').focus();
        }
    }

    //ajax5
    var ID_ATURAN_MINUM_BARU = "";
    function insertAturanMinum(){
        var aturan = $('#inputAturanMinum').val();
        if(aturan != ''){

            $.ajax({
                url: base + '/poli/ajax/inatur',
                type: 'POST',
                data: {'aturan' : $('#inputAturanMinum').val()},
            })
            .done(function(result) {
            
                data = JSON.parse(result);

                if(data.warning != ''){
                    validasi('#inputAturanMinum', data.warning);
                }else{
                    var opt = '<option value="' + data.id + '">' + aturan + '</option>';
                    $('#ddlAturanMinum').append(opt).selectpicker('refresh');
                    var MyArray = data.temp;
                    var temp = '';
                    for (var i = 0; i < MyArray.length; i++) {
                        temp += '<tr>';
                        temp += '<td>' + MyArray[i].id + '</td>';
                        temp += '<td>' + MyArray[i].aturan_minum + '</td>';
                        temp += '<td><button class="btn btn-success btn-xs" value="' + MyArray[i].id + '" onclick="pilihAturanMinum(this)">Pilih</button></td>';
                        temp += '</tr>';
                    }

                    $('#tblAturanMinum tbody').html(temp);
                }})
            .fail(function() {
                console.log("error");
            });
            return false;
        } else {
            alert('input tidak boleh kosong');
            return false;
        }
    }
    //ajax5
    function ddlSigna(sign){
        $.ajax({
            url: 'ddlSignaRuangPeriksa.php',
            type: 'POST',
            data: {ID_SIGNA : sign},
        })
        .done(function(result) {
            result = $.trim(result);
            $('#ddlsigna').html(result).selectpicker('refresh');
        })
        .fail(function() {
            console.log("error");
        });
        return false;
    }

    

    function selesaiPuyer(control) {
        var ID_ASURANSI = $('#ID_ASURANSI').val();
        $('#tipeResep').val('0').selectpicker('refresh');
        $(control).fadeOut('400', function() {
            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeIn('400');
        });
        if(ID_ASURANSI == '32' || ID_ASURANSI == '15' || ID_ASURANSI == '3'){
            $('#ddlNamaObat').val('-1').selectpicker('refresh').closest('div').fadeIn(400);
        } else {
            $('#ddlNamaObat').val('-3').selectpicker('refresh').closest('div').fadeIn(400);
        }

      $('#ddlNamaObat, #tipeResep')
      .prop('disabled',true)
      .selectpicker('refresh');
        $('#ddlsigna, #ddlAturanMinum').val('0').selectpicker('refresh')
        $('#ddlsigna, #ddlAturanMinum').closest('div').fadeIn(400);
        $('#txtjumlah').focus();
        return false;
    }

function selesaiAdd(control){

    var ID_ASURANSI = $('#ID_ASURANSI').val();
    $('#tipeResep').val('0').selectpicker('refresh');
    $(control).fadeOut('400', function() {
        $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeIn('400');
    });
    $('#ddlNamaObat').val('-2').selectpicker('refresh').closest('div').fadeIn(400);
    $('#ddlNamaObat, #tipeResep')
      .prop('disabled',true)
      .selectpicker('refresh');
    $('#ddlsigna, #ddlAturanMinum').val('0').selectpicker('refresh')
    $('#ddlsigna, #ddlAturanMinum').closest('div').fadeIn(400);
        if (addSatu) {
            $('#txtjumlah').val('1').hide();
        }else{
            $('#txtjumlah').val('0').hide();
        }
    $('#ddlsigna').closest('div').find('.btn-white').focus();
    return false;

}

function optionSyrup(ID_MEREK){
    $.ajax({
        url: base + "/optionsyrup",
        type: 'GET',
        data: {
            'ID_MEREK'    : ID_MEREK,
            'asuransi_id' : $('#asuransi_id').val() 
        },
    })
    .done(function(result) {
        customOption(result);
    })
    .fail(function() {
        console.log("error");
    })
    .complete(function() {
        $('#ddlNamaObat').selectpicker('refresh');
    });
}

    function optionPuyer(ID_MEREK){
        $.ajax({
            url: base + "/optionpuyer",
            type: 'GET',
            data: {
                'ID_MEREK'    : ID_MEREK,
                'asuransi_id' : $('#asuransi_id').val() 
            },
        })
        .done(function(result) {
            customOption(result);
        })
        .fail(function() {
            console.log("error");
        })
        .complete(function() {
            $('#ddlNamaObat').selectpicker('refresh');
        });
    }

    function optionSemua(merek_id){
        $.ajax({
            url: base + "/alloption",
            type: 'GET',
            data: { 'asuransi_id' : $('#asuransi_id').val() },
        })
        .done(function(dataMerek) {
            customOption(dataMerek);

        })
        .fail(function() {
            console.log("error");
        });
    }
    
    
    function resetSignaAturanMinum(){
        $('#ddlsigna').val('').selectpicker('refresh');
        $('#ddlAturanMinum').val('').selectpicker('refresh');
        $('#txtjumlah').val('')
    }
    function resetAll(){
        resetSignaAturanMinum();
        $('select.kosong').val('').selectpicker('refresh')
        namaObatFocus();
        console.log('1');

    }
    function resepJson(result){
        if(result != ""){
                var MyArray = JSON.parse(result);
            } else {
                var MyArray = "";
            }
            var temp = '<table width="100%">';
          if (MyArray.length > 0){
            for (var i = 0; i < MyArray.length - 1; i++) {
                if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="text-align:left; width:150px;" nowrap>' + MyArray[i].merek + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr>';

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }


                } else if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="text-align:left; width:150px;" nowrap>' + MyArray[i].merek + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr>';

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }

                } else if (MyArray[i].merek_id == -1 || MyArray[i].merek_id == -3) {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' + MyArray[i].jumlah + ' puyer ' + MyArray[i].signa + '</td>';
                    temp += '<td style="border-bottom:1px solid #000;"  nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp += '</tr>';

                    $('#puyer').val('0');

                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> fls No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr>';
                    temp += '<tr>';
                    temp += '<td style="text-align:center;" colspan="3">ADD</td>';
                    temp += '</tr>';

                    $('#boolAdd').val('1');


                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr>';

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#boolAdd').val('1');
                    } else {
                        $('#boolAdd').val('0');
                    }

                } else if (MyArray[i].merek_id == -2) {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' + MyArray[i].signa + ' </td>';
                    temp += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                    temp += '</tr>';

                    $('#puyer').val('0');

                } else {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr><tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;"> S ' + MyArray[i].signa + '</td>';
                    temp += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp += '</tr>';
                }
            }
                var a = MyArray.length - 1;
                if (MyArray[a].merek_id == -1 || MyArray[a].merek_id == -3) {
                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' + MyArray[a].jumlah + ' puyer ' + MyArray[a].signa + '</td>';
                    temp += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    $('#puyer').val('0');
                } else if (MyArray[a].merek_id == -2) {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' + MyArray[a].signa + '</td>';
                    temp += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';

                    $('#boolAdd').val('0');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;" nowrap>' + MyArray[a].merek + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> fls No : ' + MyArray[a].jumlah + '</td>';
                    temp += '</tr>';
                    temp += '<tr>';
                    temp += '<td  style="text-align:center;" colspan="3">ADD</td>';

                    $('#boolAdd').val('1');

                    id_formula_sirup_add = MyArray[a].formula_id;
                    console.log('id_formula_sirup_add = ' + id_formula_sirup_add);
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;" nowrap>' + MyArray[a].merek + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
                    if(
                        !(
                            (MyArray[a].formula_id == '150802040' && id_formula_sirup_add == '150803008') || // Cefadroksil capsul dan Cefadroksil syrup
                            (MyArray[a].formula_id == '150806007' && id_formula_sirup_add == '150803003') || // Brodamox tablet dan Decamox syrup
                            (MyArray[a].formula_id == '150803047' && id_formula_sirup_add == '150803006') || // Dexycol capsul dan Dionicol syr
                            (MyArray[a].formula_id == '150806005' && id_formula_sirup_add == '150921001')    // Cefixime capsul dan Cefixime syr
                        )
                    ){
                        addSatu = true;
                    }

                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                } else {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp += '</tr><tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;border-bottom:1px solid #000;"> S ' + MyArray[a].signa + '</td>';
                    temp += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                }
             }
            temp += '</tr></table>';
            //=============================================================
            //=============================================================
            //=============================================================
           $('#puyer').val('0');
            $('#boolAdd').val('0');
            var temp2 = '<table class="RESEP table table-condensed"><tbody>';

            var ID_TERAPIGroup = [];

            //lert(MyArray[0].signa);
          if (MyArray.length > 0){
            for (var i = 0; i < MyArray.length - 1; i++) {
                if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {
                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek + '</a></t[d>  ';
                    temp2 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';


                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }
                } else if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {




                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek + '</a></t[d>  ';
                    temp2 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }
                } else if (MyArray[i].merek_id == -1 || MyArray[i].merek_id == -3) {



                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' + MyArray[i].jumlah + ' puyer ' + MyArray[i].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '</tr>';

                    $('#puyer').val('0');
                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {


                    ID_TERAPIGroup = []
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek + '</a></t[d>'  ;
                    temp2 += '<td> f  ]ls No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';
                    temp2 += '<tr>';
                    temp2 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';


                    id_formula_sirup_add = MyArray[i].formula_id;
                    addSatu = false;
                    console.log('id_formula_sirup_add = ' + id_formula_sirup_add);

                    $('#boolAdd').val('1');
                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {


                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="text-align:left;"><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek + '</a></t[d>  ';
                    temp2 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';

                    // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
                    if(
                        !(
                            (MyArray[a].formula_id == '150802040' && id_formula_sirup_add == '150803008') || // Cefadroksil capsul dan Cefadroksil syrup
                            (MyArray[a].formula_id == '150806007' && id_formula_sirup_add == '150803003') || // Brodamox tablet dan Decamox syrup
                            (MyArray[a].formula_id == '150803047' && id_formula_sirup_add == '150803006') || // Dexycol capsul dan Dionicol syr
                            (MyArray[a].formula_id == '150806005' && id_formula_sirup_add == '150921001')    // Cefixime capsul dan Cefixime syr
                        )
                    ){
                        addSatu = true;
                    }

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#boolAdd').val('1');
                    } else {
                        $('#boolAdd').val('0');
                    }
                } else if (MyArray[i].merek_id == -2) {




                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' + MyArray[i].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += '</tr>';

                    $('#puyer').val('0');
                } else {
                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek + '</a></t[d>  ';
                    temp2 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr><tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[i].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '</tr>';
                }
            }
                var a = MyArray.length - 1;

                if (MyArray[a].merek_id == -1 || MyArray[a].merek_id == -3) {
                    console.log(MyArray[a].merek_id + ' = 1');


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };


                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' + MyArray[a].jumlah + ' puyer ' + MyArray[a].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += '<td></td>';

                    $('#puyer').val('0');
                } else if (MyArray[a].merek_id == -2) {
                    console.log(MyArray[a].merek_id + ' = 2');


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' + MyArray[a].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';

                    $('#boolAdd').val('0');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {
                    console.log(MyArray[a].merek_id + ' = 3');


                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek + '</a></td>';
                    temp2 += '<td> fls No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';
                    temp2 += '<tr>';
                    temp2 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                    $('#boolAdd').val('1');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    console.log(MyArray[a].merek_id + ' = 4');

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';


                    // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
                    if(
                        !(
                            (MyArray[a].formula_id == '150802040' && id_formula_sirup_add == '150803008') || // Cefadroksil capsul dan Cefadroksil syrup
                            (MyArray[a].formula_id == '150806007' && id_formula_sirup_add == '150803003') || // Brodamox tablet dan Decamox syrup
                            (MyArray[a].formula_id == '150803047' && id_formula_sirup_add == '150803006') || // Dexycol capsul dan Dionicol syr
                            (MyArray[a].formula_id == '150806005' && id_formula_sirup_add == '150921001')    // Cefixime capsul dan Cefixime syr
                        )
                    ){
                        addSatu = true;
                    }

                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {

                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };
                    console.log(MyArray[a].merek_id + ' = 5');

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    $('#puyer').val('1');
                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    console.log(MyArray[a].merek_id + ' = 6');

                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                } else {

                    console.log(MyArray[a].merek_id + ' = 7');

                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr><tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[a].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowDel(this);' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                }
                temp2 += '</tr></tbody></table>';
             } else {
                temp2 = "";
                temp = "";
             }
             return [temp, temp2];
    }

    function pilihSigna(control) {

        var id = $(control).val();      
        $('#ddlsigna').val(id).selectpicker('refresh');
        $('#hideModalSigna').click();
    }

    function pilihAturanMinum(control){
        var id = $(control).val();
        $('#ddlAturanMinum').val(id).selectpicker('refresh');
        $('#hideModalAturanMinum').click();

    }
    function insert(){

        var ID_MER = getIdMerek();
        var ID_FOR = getIdFormula();
        var ID_RAK = getIdRak();
        var fornas = getFornas();
        var harga_jual = getHargaJual();

        var MER = $('#ddlNamaObat option:selected').text();
        var juml = $('#txtjumlah').val();
        var ID_SIG = $('#ddlsigna').val();
        var ID_ATU = $('#ddlAturanMinum').val();

        $('#legendpop').popover('hide');


        data[data.length] = {

            'jumlah'   : juml,
            'merek_id' : ID_MER,
            'rak_id' : ID_RAK,
            'harga_jual_ini' : harga_jual,
            'formula_id' : ID_FOR,
            'signa_id'   : ID_SIG,
            'aturan_minum_id'   : ID_ATU,
            'merek' : MER,
            'fornas' : fornas,
            'signa'   : $('#ddlsigna option:selected').text(),
            'aturan_minum'   : $('#ddlAturanMinum option:selected').text()

        };

        var string = JSON.stringify(data);
        $('#terapi').val(string);

        sesuaikanInputResep(ID_MER);
        // Plafon Obat
        //=============================================================================================
        // $('#plafonObat').html($('#plafonObatBulanIni').val() - result.split('<br />===')[2]);
        // var result = result.split('<br />===')[3];
        // var temp = resepJson(result);
        //=============================================================================================
        var resep = resepJson(string);
        viewResep(resep[1]);// container untuk perscription generator

       


        //$('#ajaxFornas').html(result.split('<br />===')[4]);// container untuk obat yang tidak ditranggung bpjs dan apa alternatifnya
        //$('#bpjsBayarTunai').html(result.split('<br />===')[5]);// berapa pembayaran tunai yang harus dibayar peserta
        namaObatFocus();
        $('.kosong').val('');
        $('select.kosong').selectpicker('refresh');
        if ($('#ddlsigna').val() > 0){
            resetSignaAturanMinum();
        }




    }

    function customOption(dataMerek){

        var id = getIdMerek()

        dataMerek = JSON.parse(dataMerek);
        var temp = '';
        for (var i = 0; i < dataMerek.length; i++) {

            if(dataMerek[i].merek_id == id){
                temp += '<option data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\'  data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            }
        };

        $('#ddlNamaObat').html(temp).selectpicker('refresh');
        $('#bb_aktif').val('');
        $('#keterangan_auto_keterangan').hide();
        $('.auto').show(500);
        $('#btn_auto_off').hide(500);
        namaObatFocus();
        
    }

    function customOption2(dataMerek, berat_badan){

        var id = getIdMerek();

        dataMerek = JSON.parse(dataMerek);
        var temp = '';
        for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

            if(dataMerek[i].merek_id == id){
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            }
        };

        $('#ddlNamaObat').html(temp).selectpicker('refresh');

        $('#keterangan_auto').html(berat_badan);
        $('#keterangan_auto_keterangan').removeClass('hide').hide().slideDown(500);
        $('#ddlNamaObat').val('').selectpicker('refresh');
        $('#ddlAturanMinum').val('').selectpicker('refresh');
        $('#ddlsigna').val('').selectpicker('refresh');
        $('#txtjumlah').val('');
        $('.auto').hide(500);
        $('#btn_auto_off').show(500);
        namaObatFocus();
    }

    function customOption2a(dataMerek, berat_badan){

        var id = getIdMerek()

        dataMerek = JSON.parse(dataMerek);
        var temp = '';
        for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

            if(dataMerek[i].merek_id == id){
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            }
        };

        $('#ddlNamaObat').html(temp).selectpicker('refresh');

        $('#keterangan_auto').html(berat_badan);
        $('#keterangan_auto_keterangan').removeClass('hide').hide().slideDown(500);
        $('#ddlNamaObat').val('').selectpicker('refresh');
        $('#ddlAturanMinum').val('').selectpicker('refresh');
        $('#ddlsigna').val('').selectpicker('refresh');
        $('#txtjumlah').val('');
        $('.auto').hide(500);
        $('#btn_auto_off').show(500);
    }

    function getIdMerek(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.merek_id;
        } else {
            var id = '';
        }

        return id;
    }
    function getIdFormula(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.formula_id;
        } else {
            var id = '';
        }

        return id;
    }
    function getIdRak(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.rak_id;
        } else {
            var id = '';
        }

        return id;
    }
    function getFornas(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var fornas = $('#ddlNamaObat option:selected').attr("data-fornas");
        } else {
            var fornas = '';
        }

        return fornas;
    }
    function getHargaJual(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var harga_jual = merek.harga_jual * parseInt($('#kali_obat').val());
        } else {
            var harga_jual = '';
        }

        return harga_jual;
    }
    function getAturanMinumId(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.aturan_minum_id;
        } else {
            var id = '';
        }

        return id;
    }

    function rowDel(control){

        var MyArray = JSON.parse($(control).val());
        $('#legendpop').popover('show');

        data.splice(MyArray[0].id, MyArray.length);

        var string = JSON.stringify(data);
        $('#terapi').val(string);
        var resep = resepJson(string);
        viewResep(resep[1]);
        if($('#puyer').val() == '0' && $('#boolAdd').val() == '0'){
            alert
            $('#boolSirupPuyer').val('0');
        }

        var sig = '';

        if(data.length > 0){
            sig = data[data.length - 1].signa;
        }


        if ( sig == 'Puyer' && $('#boolSirupPuyer').val() == '0') {
            hideTipeResepPuyer(null);
            tipePuyer();
        } else if ( sig == 'Add' && $('#boolSirupPuyer').val() == '0'){
            hideTipeResepSirup(null);
            tipeSirup();
        } else if ( $('#boolSirupPuyer').val() == '0' ) {
            //bila yang terakhir adalah yang normal
            // direset pilihan signa, aturanminum, dan jummlah
            $('#tipeResep').closest('div').find('.btn-info').fadeOut('500', function() {
                $(this).remove();
            });;

            $('#tipeResep').closest('div').find('.btn-primary').fadeOut('500', function() {
                $(this).remove();
            });

            $('#ddlsigna').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#tipeResep').val('0').selectpicker('refresh').closest('div').find('.btn-white').closest('div').fadeIn(500);
            $('#ddlAturanMinum').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);
            //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
            optionSemua(null);
            $('#boolSirupPuyer').val('0');

        }
    }

    function sesuaikanInputResep(ID_MER) {

        if($('#tipeResep').val() == "0" && $('#ddlNamaObat option:selected').text() == "Add Sirup"){
            $('#txtjumlah').val('').fadeIn(500);
            optionSemua(ID_MER);
        }
                //tipe resep 1 = puyer
        if($('#tipeResep').val() == '1' && $('#boolSirupPuyer').val() == '0'){
               tipePuyer();
        } else if ($('#tipeResep').val() == '2' && $('#boolSirupPuyer').val() == '0'){
               tipeSirup();
        } else if ($('#tipeResep').val() == '0' && $('#boolSirupPuyer').val() == '1'){

            $('#boolSirupPuyer').val('0');
            resetSignaAturanMinum();
            optionSemua(ID_MER);
            console.log('2');


        } else if ($('#tipeResep').val() == '0' || $('#tipeResep').val() == ''){
            resetSignaAturanMinum();
            console.log('3');
        }
    }

    function sesuaikanResep() {
        // bila yang terakhir ditinggal kan Add Sirup
        if($('#boolAdd').val() == '1'){
            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeOut('400', function() {
                var button = '<button class="btn btn-primary btn-block" onclick="selesaiAdd(this);return false;" id="selesaikanAdd">Selesaikan Sirup</button>';
                $('#tipeResep').closest('div').prepend(button).hide().fadeIn(400);
            });
                        //signa -2 adalah add sirup
            $('#ddlsigna').val('-2').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
            optionPuyer(null);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);
            namaObatFocus();
        //Bila yang terakhir ditinggalkan adalah Puyer
        } else if ($('#puyer').val() == '1'){

            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeOut('400', function() {
                var button = '<button class="btn btn-info btn-block" onclick="selesaiPuyer(this);return false;" id="selesaikanPuyer">Selesaikan Puyer</button>';
                $('#tipeResep').closest('div').prepend(button).hide().fadeIn(400);
            });
            $('#ddlsigna').val('-1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);
            optionPuyer(null);
            namaObatFocus();

        } else {
            //bila yang terakhir adalah yang normal
            // direset pilihan signa, aturanminum, dan jummlah
            $('#tipeResep').closest('div').find('.btn-info').fadeOut('500', function() {
                $(this).remove();
            });;

            $('#tipeResep').closest('div').find('.btn-primary').fadeOut('500', function() {
                $(this).remove();
            });


            $('#ddlsigna').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#tipeResep').val('0').selectpicker('refresh').closest('div').find('.btn-white').closest('div').fadeIn(500);
            $('#ddlAturanMinum').val('').selectpicker('refresh').closest('.input-group').fadeIn(500);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);
            //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
            optionSemua(null);
            $('#boolSirupPuyer').val('0');
        }

    }


    function tipePuyer() {
         $('#boolSirupPuyer').val('1');
            $('#puyer').val('1');
            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeOut('400', function() {
                var button = '<button class="btn btn-info btn-block" onclick="selesaiPuyer(this);return false;" id="selesaikanPuyer">Selesaikan Puyer</button>';
                $('#tipeResep').closest('div').prepend(button).hide().fadeIn(400);
            });
    }

    function tipeSirup(){

            $('#boolSirupPuyer').val('1');
            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeOut('400', function() {
                var button = '<button class="btn btn-primary btn-block" onclick="selesaiAdd(this);return false;" id="selesaikanAdd">Selesaikan Sirup</button>';
                $('#tipeResep').closest('div').prepend(button).hide().fadeIn(400);
            });

            optionPuyer(null);
            $('#txtjumlah').val('').selectpicker('refresh').fadeIn(500);

    }

    function hideTipeResepPuyer(id){

            $('#ddlsigna').val('-1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            optionPuyer(id);
    }

    function hideTipeResepSirup(id){
            //signa -2 adalah add sirup
            $('#ddlsigna').val('-2').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //jumlah dihilangkan dan ditentukan nilainya adalah 1, karena tidak mungkin add banyak sirup
            $('#txtjumlah').val('1').selectpicker('refresh').fadeOut(500);
            //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
            optionSyrup(id);
    }

    function submitTindakan(){

        var valJson = $('#selectTindakan').val();
        valJson = $.parseJSON(valJson);

        var biaya = valJson.biaya;
        var tarif = $('#selectTindakan option:selected').text();
        var keterangan_tindakan = $('#keteranganTindakan').val();

        if (biaya != '') {
            dataTindakan[dataTindakan.length] = {
                'jenis_tarif' : tarif,
                'biaya' : biaya,
                'keterangan_tindakan' : keterangan_tindakan
            }

            var string = JSON.stringify(dataTindakan);
            $('#tindakan').val(string);

            viewTindakan(dataTindakan);
            resetInputTIndakan();

        } else {

            validasi('#selectTindakan', 'Harus Diisi!');
            resetInputTIndakan();

        }

        
    }

    function viewTindakan(MyArray){
        var temp ="";
        for (var i = 0; i < MyArray.length; i++) {
            temp += '<tr>';
            temp += '<td>' + MyArray[i].jenis_tarif+ '</td>';
            temp += '<td>' + MyArray[i].keterangan_tindakan+ '</td>';
            temp += '<td><button class="btn btn-danger btn-xs" value="' + i + '" onclick="tindakanDel(this)">hapus</button></td>';
            temp += '</tr>';
        }

        $('#ajaxTindakan').html(temp);
        $('#tindakan').val(JSON.stringify(dataTindakan));
    }

    function tindakanDel(control) {

        var i = $(control).val();

        dataTindakan.splice(i, 1);

        viewTindakan(dataTindakan);
        resetInputTIndakan();


    }

    function resetInputTIndakan(){
        $('#keteranganTindakan').val('');
        $('#selectTindakan').val(null).selectpicker('refresh').closest('tr').find('.btn-white').focus();
    }

    function generatePerscription(){
        var diagnosa_id = $('#ddlDiagnosa').val();
    }

    function dirujuk(){
        $('#confirmRujuk').hide();
        $('#infoRujuk').removeClass('hide').hide().slideDown(500);
        $('#tujuan_rujuk2').focus();

    }

    function tidakDirujuk(){
        clearRujuk();
        // submit berhasil
        $('#submitFormPeriksa').click();
    }

    function rujukanSelesai(){
        var tujuan = $('#tujuan_rujuk2').val();
        if (tujuan == '') {
            validasi('#tujuan_rujuk2', 'Harus Diisi!');
        } else {
            $('#tujuan_rujuk').val($('#tujuan_rujuk2').val());
            $('#alasan_rujuk').val($('#alasan_rujuk2').val());
            $('#submitFormPeriksa').click();
        }
    }

    function cancelRujukan(){
        $('#modal-id').modal('hide');
        clearRujuk();
    }

    function serial(){
        console.log($('#submitPeriksa').serializeArray());
    }

    function clearRujuk(){

        $('#tujuan_rujuk').val('');
        $('#alasan_rujuk').val('');
    }

    function tabResepActive(){
        console.log('yeya');
        namaObatFocus();

    }

    function diagnosaChange(){
        var asuransi_id = $('#asuransi_id').val();
        var berat_badan = $('#bb_aktif').val();
        var diagnosa_id = $('#ddlDiagnosa').val();
        if (asuransi_id == '32') {
            $.post( base + "/poli/ajax/diagcha", {'diagnosa_id': $('#ddlDiagnosa').val() }, function(data) {
                data = $.trim(data);
                if (data == '1') {
                    $('#keterangan_boleh_dirujuk').empty();
                    if ($('#ddlDiagnosa').val() != '' || $('#ddlDiagnosa').val() != null ) {
                        var diagnosa = $('#ddlDiagnosa option:selected').text();
                        var text = '<div class="alert alert-danger" id="isi_pesan_fornas">' + diagnosa + ' <strong>tidak boleh DIRUJUK </strong> pilih diagnosa lain (menurut ICD10) bila pasien memang benar2 harus dirujuk</div>';
                        $('#keterangan_boleh_dirujuk').prepend(text).hide().fadeIn(500);
                    }
                } else {
                    $('#keterangan_boleh_dirujuk').empty();
                }
            });
        }


        var dataEntry = {
            'asuransi_id' : asuransi_id,
            'berat_badan' : berat_badan,
            'diagnosa_id' : diagnosa_id
        }

        // AUTO perscription generator
        $.post(base + '/sopterapi', dataEntry, function(result) {
            result = $.trim(result);

            var result_array = JSON.parse(result);

            temp_sop_terapi = result_array;

            length_sop_terapi = result_array.length;


            if(result_array[0]){
                
                var terapi = result_array[0]['terapi'];
                console.log(terapi);
                data = JSON.parse(terapi);
                $('#terapi').val(terapi);
                viewResep(resepJson(terapi)[1]);
                $('#tampungan_sop_terapi').html('1/' + length_sop_terapi);
                i_sop_terapi = 0;
            }
        });

        var str1 = '';
        if ($('#ddlDiagnosa').val() != '') {
            str1 = $('#ddlDiagnosa option:selected').text();
        }
        // alert(str1);
        if(str1.indexOf('J45') != -1){
            $('#lblDiagnosa').attr({

                'title'  : 'Bila Asma Berat',
                'data-original-title'  : 'Bila Asma Berat',
                'data-content': 'Jika ASMA BERAT, berikan bersama dexa inj IV 2 ampul, dan prednison 40 tab hr 1-2 :3x3, hr 3-4 : 3x2, hr 5-7 : 3x1, Decafil 20 tablet, termasuk untuk pasien BPJS'
            });
            $('#lblDiagnosa').popover('show');
        } else {
            $('#lblDiagnosa').popover('hide');
        }
    }

    function namaObatFocus(){
        $('#ddlNamaObat').closest('div').find('.btn-white').focus();
    }

    function clearResep() {
        $('#terapi').val('[]');
        viewResep('');
        data=[];
        namaObatFocus();
    }

    function generatePerscription(){
        var result_array = temp_sop_terapi;
        i_sop_terapi = i_sop_terapi + 1;
        var i = parseInt(i_sop_terapi) + 1;
        var terapi = result_array[i_sop_terapi]['terapi'];
        if (i == length_sop_terapi) {
            i_sop_terapi = -1;
        }
        data = JSON.parse(terapi);
        $('#terapi').val(terapi);
        viewResep(resepJson(terapi)[1]);
        $('#tampungan_sop_terapi').html(i + '/' + length_sop_terapi);

    }

    function viewResep(control){
        $('#ajax5').html(control);
         //bagian ini khusus untuk tipe_asuransi == 4 / flat
         if ($('#plafon').length > 0) {
            var totalBiayaObat = 0;

            var resep = $('#terapi').val();
            resep = JSON.parse(resep);
            console.log(resep);
            var harga_jual = 0
            for (var i = 0; i < resep.length; i++) {
                harga_jual = resep[i].harga_jual_ini;
                totalBiayaObat += harga_jual * resep[i].jumlah * $('#kali_obat').val();
                console.log('harga dari ' + resep[i].merek + ' = ' + harga_jual)
            }
            var plafon = $('#plafon_total').val() - totalBiayaObat;
            console.log('totalBiayaObat = ' + totalBiayaObat);

            $('#plafon').html(plafon);

         }

        if ($('#bilaTipeBPJS').length > 0) {
            var tempDibayarBPJS = '';
            var totalBiaya = 0;
            var biaya_ini = 0;
            for (var i = 0; i < data.length; i++) {
                if (data[i].fornas == '0') {
                    biaya_ini = data[i].harga_jual_ini * data[i].jumlah * $('#kali_obat').val();
                    totalBiaya += biaya_ini;
                    tempDibayarBPJS += '<tr>';
                    tempDibayarBPJS += '<td>' + data[i].merek + '</td>';
                    tempDibayarBPJS += '<td>' + biaya_ini + '</td>';
                    tempDibayarBPJS += '</tr>';
                }
            }
            $('#bilaTipeBPJS').html(tempDibayarBPJS);
            $('#totalBilaTipeBPJS').html(totalBiaya);

         }
        $('#peringatan').empty();
    }


