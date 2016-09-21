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
            viewTindakan(dataTindakan);
            // $('#ajaxTindakan').html(viewTindakan(dataTindakan));
        }

    $('.hide-panel').closest('.panel').find('.panel-heading').css('border', '3px border red');
    $('.hide-panel').closest('.panel').find('.panel-heading').css('cursor', 'pointer');
    $('.hide-panel').closest('.panel').find('.panel-heading').click(function(e) {
        $(this).closest('.panel').find('.hide-panel').slideToggle();
    });;


   jQuery(document).ready(function($) {
        alert('uooooooiii');
        $('#cekFoto').modal({backdrop: 'static', keyboard: false});

        uk_exec('uk', 'hpht');
        if ($('#kesimpulan').val() == '') {
            hasil();
        }
        riwObsG();
        $('.hasil').on('keyup change', function(e) {
            hasil();
        });

        $('#G').keyup(function(e) {
           riwObsG();
        });

        view();
        uk('umur_kehamilan', 'HPHT');
        uk('uk', 'hpht');

        $('#tab-status').on('shown.bs.tab', function (e) {
            $('#anamnesa').focus();
        });

        $('#usg_presentasi').blur(function(e) {
            if ($(this).val().indexOf('kepala') > -1) {
                $('.presentasi').val('2');
            } else if($(this).val().indexOf('lintang') > -1){
                $('.presentasi').val('3');
            } else if($(this).val().indexOf('bokong') > -1){
                $('.presentasi').val('4');
            }
        });

        $('#usg_djj').blur(function(e) {
            $('#djj').val($(this).val())
        });

        $('#tab-usg').on('shown.bs.tab', function (e) {
            $('#usg_presentasi').focus();
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


            $.get(base + '/DdlMerek/alloption2', {'bb': bb}, function(data) {
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
                $.post(base + "/poli/ajax/selectsigna", {'signa' : $(this).val(), '_token' : $('#token').val()}, function(data) {
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
        var puyer    = $('#puyer').val();
        var boolAdd  = $('#boolAdd').val();
        
        var tindakan  = $('#adatindakan').val();
        var tindakans = $.parseJSON($('#tindakan').val());

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
        } else if(tindakan == '1'){
            var tindakanTambahan = 0;
            for (var i = 0; i < tindakans.length; i++) {
                if (
                    tindakans[i]['jenis_tarif_id'] != '1' &&
                    tindakans[i]['jenis_tarif_id'] != '9' &&
                    tindakans[i]['jenis_tarif_id'] != '140'
                ){
                    tindakanTambahan++;
                }
            }
            if (tindakanTambahan == 0) {
                var r = confirm('Apa Anda lupa isi kolom tindakan? Jika anda yakin bahwa tidak ada tindakan tambahan, tekan tombol OK');
                if (r) {
                    $('#submitFormPeriksa').click();
                } else {
                    return false;
                }
            };
        } else {
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
        if ($(this).val != '') {
            var isi = true;
        } else {
            var isi = false;
        }


        //if ($(this).val == '150802011' || $(this).val() == '150802068') {};
        //i adalah ID_MEREK yang terpilih dari pilihan obat
        var dataObat = JSON.parse($(this).val());
        var i = dataObat.merek_id;

        var sediaan = getSediaan();
        var merek = getMerek();
        var formula_id = getIdFormula();;
        var tidakDipuyer = getTidakDipuyer();
        var tipeResep = $('#tipeResep').val();

        if (sediaan == 'syrup' && tipeResep == 2 ) {
            alert('obat ' + merek + ', tidak boleh dicampur dengan obat lain karena bukan dry syrup seperti \nAmoxilin Syr \nThiamphenicol syr \n Cefadroksil syr \n atau cefixim syr \nYang bisa dicampur dengan obat lain');
            $('#ddlNamaObat').val('').selectpicker('refresh');
            namaObatFocus();
            return false;   
        }

        if (tidakDipuyer == '1' && (tipeResep == 1 || tipeResep == 2) ) {
            alert('obat ' + merek + ', tidak boleh dipuyer ataupun dicampur ke dalam sirup');
            $('#ddlNamaObat').val('').selectpicker('refresh');
            namaObatFocus();
            return false;   
        }




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
            if($(this).val() != ''){//jika pilihan nama obat tidak kosong
                var rak_id = getIdRak();
                var tipe_resep = $('#tipeResep').val(); 
                var merek      = $('#ddlNamaObat option:selected').text();
                var fornas     = $('#ddlNamaObat option:selected').attr('data-fornas');

                if (rak_id == 'D7' && tipe_resep == '1')  {
                } else {
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
        }

        $.post(base +'/poli/ajax/ibusafe', {'merek_id': $(this).val(), 'umur' : $('#umur').html(), '_token' : $('#token').val()}, function(data) {
            /*optional stuff to do after success */
            data = $.trim(data);
            if (data == '1') {
                alert('Ibuprofen syrup / tablet tidak boleh digunakan untuk anak dibawah umur 1 tahun, gunakan ibuprofen suppositoria dalam kondisi darurat!! Optimalkan pemberian paracetamol 15 mg/kgbb tiap 4 jam, disertai dengan ibuprofen supp bila kepepet !!');
                $('#ddlNamaObat').val('').selectpicker('refresh');
            }
        });

        if ($('#hamil').val() == '1') {
            $.post( base + '/poli/ajax/pregsafe', {'merek_id': $(this).val()}, function(data) {
                data = $.trim(data);
                if (data != '') {
                    data = $.parseJSON(data);
                    var temp = '<h4 class="text-center">Peringatan keamanan</h4>';
                    temp += '<h4 class="text-center">dalam kehamilan</h4>';
                    temp += '<table class="table table-condensed table-bordered font-kecil">';
                    temp += '<thead><tr><th class="bg-red">Generik</th><th class="bg-red">Safety Index</th></tr></thead>';
                    temp += '<tbody>'
                    for (var i = 0; i < data.length; i++) {
                        temp += '<tr>';
                        temp += '<td>' + data[i].generik + ' ' + data[i].bobot + '</td>';
                        temp += '<td>' + data[i].pregnancy_safety_index + '</td>';
                        temp += '</tr>';
                    }
                    temp += '</tbody></table>';

                    $('#legendpop').attr({
                        'title'  : $('#ddlNamaObat option:selected').text(),
                        'data-original-title'  : $('#ddlNamaObat option:selected').text(),
                        'data-content': temp
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
        } else if (formula_id == '150802046' && $('#asuransi_id').val()  == '32' ) {
            $('#legendpop').attr({

                'title'  : 'Levofloxacine tabet 500 mg',
                'data-original-title'  : 'Levofloxacine tabet 500 mg',
                'data-content': 'Pada pasien BPJS dengan Typhoid fever, obat ini diberikan selama 6 hari, obat simtomatik lain diberikan selama 3 hari, diharapkan pasien tidak kontrol kalau keadaan membaik dan tinggal habiskan antibiotiknya saja'
            }); 
            $('#legendpop').popover('show');

        } else {
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
     hasil();
     total_afi_count = 0;
}

function getDiagnosaByICD(ICD){
     $.ajax({
            url: base + "/poli/ajax/diag", 
            type: 'GET',
            data: {icd10 : ICD  } 
        })
        .done(function(messages) {
            messages = JSON.parse(messages);
            var temp = "";

            for (var i = 0; i < messages.length; i++) {
                temp += '<tr class="anchor2">';
                temp += '<td>' + messages[i].id + '</td>';
                temp += '<td>' + messages[i].diagnosa + '</td>';
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
            data: {icd10 : ICD, diagnosa : diagnosaUmum, _token : $('#token').val()}
        })
        .done(function(result) {
            result = $.trim(result);
            if(result == '0'){
                alert(diagnosaUmum + ' GAGAL diinput');

            } else if(result == '01'){

                validasi('#tambahDiagnosa', 'Sudah ada!!');
                
            } else {

                result = JSON.parse(result);
                alert(diagnosaUmum + ' berhasil diinput');
                getDiagnosaByICD(ICD);
                var opt = '<option value="' + result.id +'">' + result.diagnosa + ' - ' + result.diagnosaICD + '</option>';
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
    $.post(base + '/poli/ajax/pilih', {'byICD': $('#byICD').val(), 'byDiagnosa' : $('#byDiagnosa').val(), '_token' : $('#token').val()}, function(data) {

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


    function formSigna(){
        $.ajax({
            url: 'ajaxSigna.php',
            type: 'POST',
            data: {_token : $('#token').val()},
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
                data: {signa : signa, _token:$('#token').val()},
            })
            .done(function(result) {

                result = JSON.parse(result);

                if(result.warning != ''){
                    validasi('#inputSigna', result.warning);
                }else{
                    var opt = '<option value="' + result.id + '">' + signa + '</option>';
                    var MyArray = result.temp;
                    $('#ddlsigna').append(opt).val(MyArray.id).selectpicker('refresh');
                    var temp = '';
                    temp += '<tr>';
                    temp += '<td>' + MyArray.id + '</td>';
                    temp += '<td>' + MyArray.signa + '</td>';
                    temp += '<td><button class="btn btn-success btn-xs" value="' + MyArray.id + '" onclick="pilihSigna(this)">Pilih</button></td>';
                    temp += '</tr>';
                    $('#tblSigna tbody').html(temp).hide().fadeIn(300, function() {
                        $('#modalSigna').modal('hide');
                    });;
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
                data: {'aturan' : $('#inputAturanMinum').val(), '_token' : $('#token').val()},
            })
            .done(function(result) {
            
                result = JSON.parse(result);

                if(result.warning != ''){
                    validasi('#inputAturanMinum', result.warning);
                }else{
                    var opt = '<option value="' + result.id + '">' + aturan + '</option>';
                    var MyArray = result.temp;
                    $('#ddlAturanMinum').append(opt).val(MyArray.id).selectpicker('refresh');
                    var temp = '';
                    temp += '<tr>';
                    temp += '<td>' + MyArray.id + '</td>';
                    temp += '<td>' + MyArray.aturan_minum + '</td>';
                    temp += '<td><button class="btn btn-success btn-xs" value="' + MyArray.id + '" onclick="pilihAturanMinum(this)">Pilih</button></td>';
                    temp += '</tr>';

                    $('#tblAturanMinum tbody').html(temp).hide().fadeIn(300, function() {
                        $('#modalAturanMinum').modal('hide');
                    });
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
            data: {ID_SIGNA : sign, _token:$('#token').val()},
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
        var asuransi_id = $('#asuransi_id').val();
        $('#tipeResep').val('0').selectpicker('refresh');
        $(control).fadeOut('400', function() {
            $('#tipeResep').closest('div').find('.btn-white').closest('div').fadeIn('400');
        });
        if(asuransi_id == '32' || asuransi_id == '15' || asuransi_id == '3'){
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

    var asuransi_id = $('#asuransi_id').val();
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
        url: base + "/DdlMerek/optionsyrup",
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
            url: base + "/DdlMerek/optionpuyer",
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
            url: base + "/DdlMerek/alloption",
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
        alert('reset all');
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

        var ID_MER     = getIdMerek();
        var ID_FOR     = getIdFormula();
        var ID_RAK     = getIdRak();
        var fornas     = getFornas();
        var harga_jual = getHargaJual();
        var tipe_resep = $('#tipeResep').val();

        if (ID_RAK == 'D7' && tipe_resep == '1')  {
            fornas = '1';
        }

        var MER    = $('#ddlNamaObat option:selected').text();
        var juml   = $('#txtjumlah').val();
        var ID_SIG = $('#ddlsigna').val();
        var ID_ATU = $('#ddlAturanMinum').val();

        $('#legendpop').popover('hide');

        data[data.length] = {
            
            'jumlah'   : juml,
            'merek_id' : ID_MER,
            'rak_id' : ID_RAK,
            'harga_jual_ini' : harga_jual,
            'formula_id' : ID_FOR,
            'merek_obat' : MER,
            'fornas' : fornas,
            'signa'   : $('#ddlsigna option:selected').text(),
            'aturan_minum'   : $('#ddlAturanMinum option:selected').text()

        };

        var string = JSON.stringify(data);
        $('#terapi').val(string);

        sesuaikanInputResep(ID_MER);
        var resep = resepJson(string);
        viewResep(resep[1]);// container untuk perscription generator
        namaObatFocus();
        $('.kosong').val('');
        $('select.kosong').selectpicker('refresh');
        if ($('#ddlsigna').val() > 0){
            resetSignaAturanMinum();
            alert('kosongkan');
        }
    }

    function customOption(dataMerek){
        console.log('customOption');
        var id = getIdMerek()

        dataMerek = JSON.parse(dataMerek);
        var temp = '';


        for (var i = 0; i < dataMerek.length; i++) {

            if(dataMerek[i].merek_id == id){
                temp += '<option data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\'  data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
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
        console.log('customOption2');

        var id = getIdMerek();

        dataMerek = JSON.parse(dataMerek);
        var temp = '';
        for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

            if(dataMerek[i].merek_id == id){
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
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
        console.log('customOption2a');

        var id = getIdMerek()

        dataMerek = JSON.parse(dataMerek);
        var temp = '';
        for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

            if(dataMerek[i].merek_id == id){
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' selected="selected" data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
            } else {
                temp += '<option data-dose=\'' + doses + '\' data-custom-value=\'{ "formula_id" : "' + dataMerek[i].formula_id +'", "rak_id" : "' + dataMerek[i].rak_id + '", "merek_id" : "'  + dataMerek[i].merek_id +  '", "harga_beli" : "'  + dataMerek[i].harga_beli +  '" , "aturan_minum_id" : "'  + dataMerek[i].aturan_minum_id +  '" , "harga_jual" : "'  + dataMerek[i].harga_jual +  '" , "sediaan" : "'  + dataMerek[i].sediaan +  '" , "tidak_dipuyer" : "'  + dataMerek[i].tidak_dipuyer +  '" }\' data-subtext=\'' + dataMerek[i].komposisi + '\' value=\'' + dataMerek[i].merek_id + '\' data-peringatan=\'' + dataMerek[i].peringatan + '\' data-fornas=\'' + dataMerek[i].fornas + '\' data-alternatif=\'' + dataMerek[i].alternatif + '\'>' + dataMerek[i].merek + '</option>';
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
            var kali_obat = $('#kali_obat').val();
            var harga_jual = merek.harga_jual * parseInt(kali_obat);
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
    function getMerek(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var id = $('#ddlNamaObat option:selected').text();
        } else {
            var id = '';
        }
        return id;
    }
    function getSediaan(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.sediaan;
        } else {
            var id = '';
        }
        return id;
    }
    function getTidakDipuyer(){
        var merek = $('#ddlNamaObat').val();
        if(merek != ''){
            var data_custom = $('#ddlNamaObat option:selected').attr("data-custom-value");
            merek = JSON.parse(data_custom);
            var id = merek.tidak_dipuyer;
        } else {
            var id = '';
        }
        return id;
    }

    function panggil(control){
        alert('panggil');
    }

    function rowdel(control){

        var MyArray = JSON.parse($(control).val());
        $('#legendpop').popover('hide');

        data.splice(MyArray[0].id, MyArray.length);

        var string = JSON.stringify(data);
        $('#terapi').val(string);
        var resep = resepJson(string);
        viewResep(resep[1]);
        if($('#puyer').val() == '0' && $('#boolAdd').val() == '0'){
            $('#boolSirupPuyer').val('0');
        }

        var sig = '';

        if(data.length > 0){
            sig = data[data.length - 1].signa;
        }


        if ( sig == 'Puyer' && $('#boolSirupPuyer').val() == '0') {
            $('#tipeResep').val('1');
            hideTipeResepPuyer(null);
            tipePuyer();
        } else if ( sig == 'Add' && $('#boolSirupPuyer').val() == '0'){
            $('#tipeResep').val('2');
            hideTipeResepSirup2(null);
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
               //tipe resep 2 = add
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
    function hideTipeResepSirup2(id){
            //signa -2 adalah add sirup
            $('#ddlsigna').val('-2').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //jumlah dihilangkan dan ditentukan nilainya adalah 1, karena tidak mungkin add banyak sirup
            $('#txtjumlah').val('1').selectpicker('refresh').fadeOut(500);
            //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
            $('#ddlAturanMinum').val('1').selectpicker('refresh').closest('.input-group').fadeOut(500);
            //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
            optionPuyer(id);
    }

    function submitTindakan(){
        var valJsonAwal = $('#selectTindakan').val();
        valJson         = $.parseJSON(valJsonAwal);
        var biaya               = valJson.biaya;
        var jenis_tarif_id      = valJson.jenis_tarif_id;
        var tarif               = $('#selectTindakan option:selected').text();
        var keterangan_tindakan = $('#keteranganTindakan').val();


        if (valJsonAwal != '') {
            dataTindakan[dataTindakan.length] = {
                'jenis_tarif_id' : jenis_tarif_id,
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

        optionBilaNebuBpjs();

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
        var temp = '';
        var biaya = 0;
        for (var i = 0; i < MyArray.length; i++) {
            if(MyArray[i].biaya > 0){
                temp += '<tr>';
                temp += '<td>' + MyArray[i].jenis_tarif+ '</td>';
                temp += '<td class="uang">' + MyArray[i].biaya+ '</td>';
                temp += '</tr>';

                biaya += MyArray[i].biaya;
            }
        }

        console.log(temp);
        $('#dibayarTIndakanBpjs').html(temp);
        $('#TotalDibayarTindakanBPJS').html(biaya)
        rupiah();
        bpjsBayar();
    }

    function tindakanDel(control) {

        var i = $(control).val();

        dataTindakan.splice(i, 1);

        viewTindakan(dataTindakan);
        resetInputTIndakan();
        optionBilaNebuBpjs();
    }

    function resetInputTIndakan(){
        $('#keteranganTindakan').val('');
        $('#selectTindakan').val(null).selectpicker('refresh').closest('tr').find('.btn-white').focus();
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
        var berat_badan = $('#bb_input').val();
        var diagnosa_id = $('#ddlDiagnosa').val();
        var staf_id = $('#staf_id').val();



        if (asuransi_id == '32') {
            $.post( base + "/poli/ajax/diagcha", {'diagnosa_id': $('#ddlDiagnosa').val()}, function(data) {
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
        // AUTO perscription generator untuk mengenerate SOP terapi
        generate();
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
        data=[];
        viewResep('');
        namaObatFocus();
    }
    function generatePerscription(){
        var result_array = temp_sop_terapi;
        i_sop_terapi = i_sop_terapi + 1;
        var i = parseInt(i_sop_terapi) + 1;
        var terapi = result_array[i_sop_terapi]['terapi'];
        terapi = JSON.stringify(terapi);
        if (i == length_sop_terapi) {
            i_sop_terapi = -1;
        }
        data = JSON.parse(terapi);
        $('#terapi').val(terapi);
        viewResep(resepJson(terapi)[1]);
        $('#tampungan_sop_terapi').html(i + '/' + length_sop_terapi);

    }

    function viewResep(control){
        console.log(viewResep);
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
            console.log('plafon = ' + plafon);
            console.log('plafon.val = ' + $('#plafon_total').val());
            console.log('totalBiayaObat = ' + totalBiayaObat);
            $('#plafon').html(Math.abs(plafon));

            if (plafon < 0) {

                $('#uangKekuranganFlat').html(rataAtas5000(abs(plafon)));

                if ($('#kekuranganFlat').hasClass('hide')) {
                    $('#kekuranganFlat').removeClass('hide');
                }
            } else {
                if (!$('#kekuranganFlat').hasClass('hide')) {
                    $('#kekuranganFlat').addClass('hide');
                }
            }

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
                    tempDibayarBPJS += '<td>' + data[i].merek_obat + '</td>';
                    tempDibayarBPJS += '<td>' + data[i].jumlah + '</td>';
                    tempDibayarBPJS += '</tr>';
                }
            }

            totalBiaya = rataAtas5000(totalBiaya);

            $('#bilaTipeBPJS').html(tempDibayarBPJS);
            $('#totalBilaTipeBPJS').html(totalBiaya);
            rupiah();
            bpjsBayar();

         }
        $('#peringatan').empty();
    }

    function generate(){
        var dataEntry = {
            'asuransi_id' : $('#asuransi_id').val(),
            'berat_badan' : $('#bb_input').val(),
            'diagnosa_id' : $('#ddlDiagnosa').val(),
            'staf_id' : $('#staf_id').val(),
            '_token' :  $('#token').val()
        }

        var terapi = $('#terapi').val();
        if ($('#hamil').val() != '1' && $('#dibantu').val() == '1' && ( terapi == '' || terapi == '[]') ) {
            $.post(base + '/poli/ajax/sopterapi', dataEntry, function(result) {
                result = $.trim(result);
                var result_array = JSON.parse(result);
                temp_sop_terapi = result_array;
                length_sop_terapi = result_array.length;

                if(result_array[0]){
                    
                    var terapi = result_array[0]['terapi'];
                    terapi = JSON.stringify(terapi);
                    data = JSON.parse(terapi);
                    $('#terapi').val(terapi);
                    viewResep(resepJson(terapi)[1]);
                    $('#tampungan_sop_terapi').html('1/' + length_sop_terapi);
                    i_sop_terapi = 0;
                } else {
                    var terapi = '[]';
                    $('#terapi').val(terapi);
                    viewResep(resepJson(terapi)[1]);
                    temp_sop_terapi = [];
                    $('#tampungan_sop_terapi').html('0');
                    i_sop_terapi = 0;
                }
            }).fail(function(data){

                console.log(data);
    // Error...
                var errors = $.parseJSON(data.responseText);

                console.log(errors);

                $.each(errors, function(index, value) {
                    $.gritter.add({
                        title: 'Error',
                        text: value
                    });
                });
            });
        };
    }
    function generate2(){
        var dataEntry = {
            'asuransi_id' : $('#asuransi_id').val(),
            'berat_badan' : $('#bb_input').val(),
            'diagnosa_id' : $('#ddlDiagnosa').val(),
            'staf_id' : $('#staf_id').val(),
            '_token' :  $('#token').val()
        }

        var terapi = $('#terapi').val();
        if ($('#hamil').val() != '1' && $('#dibantu').val() == '1' ) {
            $.post(base + '/poli/ajax/sopterapi', dataEntry, function(result) {
                result = $.trim(result);

                var result_array = JSON.parse(result);
                temp_sop_terapi = result_array;
                length_sop_terapi = result_array.length;

                if(result_array[0]){
                    
                    var terapi = result_array[0]['terapi'];
                    terapi = JSON.stringify(terapi);
                    data = JSON.parse(terapi);
                    $('#terapi').val(terapi);
                    viewResep(resepJson(terapi)[1]);
                    $('#tampungan_sop_terapi').html('1/' + length_sop_terapi);
                    i_sop_terapi = 0;
                } else {
                    var terapi = '[]';
                    $('#terapi').val(terapi);
                    viewResep(resepJson(terapi)[1]);
                    temp_sop_terapi = [];
                    $('#tampungan_sop_terapi').html('0');
                    i_sop_terapi = 0;
                }
            });
        };
    }
    function hasil(){
        var presentasi = $('#usg_presentasi').val();
            var patologis = ''
            var sex = $('#usg_sex').val();
            var plasenta = $('#usg_plasenta').val();
            var ltp = $('#usg_ltp').val();
            var umur_kehamilan = $('#uk').val();
            var efw = $('#usg_efw').val();
            var djj = $('#usg_djj').val();
            var riw_obs = 'G' + $('#G').val() +'P' + $('#P').val()+'A' + $('#A').val()
            var afi = $('#total_afi').val();
            var uk_usg = '';

            var minggu = $.trim(umur_kehamilan.split('minggu')[0]);
            console.log('umur_kehamilan = ' + umur_kehamilan );
            console.log('minggu = ' + minggu );
            if (minggu >=12 && minggu <=24) {
                uk_usg = $('#BPD_w').val() + ' minggu ' + $('#BPD_d').val() + ' hari';
            } else if (minggu >=24){
                uk_usg = $('#FL_w').val() + ' minggu ' + $('#FL_d').val() + ' hari';
            }
            console.log('uk_usg = ' + uk_usg);
            var status_afi = 'cukup';
            if (parseInt(afi) > 8) {
                status_afi = 'berlebihan';
                patologis += 'polihydramnion, ';
            } else if (parseInt(afi) < 2){
               status_afi =  'kurang';
                patologis += 'oligohydramnion, ';

            }
            var djj_status = 'normal'
            if (parseInt(djj) > 160) {
                djj_status = 'tinggi';
                patologis += 'takikardia fungsional dd/ Gawat Janin, ';

            } else if( parseInt(djj) < 120){
                djj_status = 'rendah';
                patologis += 'Gawat Janin, ';
            }

            if (ltp == '0') {
                ltp = 'tidak ada'
            };
            var temp = 'Janin presentasi ' + presentasi + ', denyut jantung janin ' + djj_status + ' '  + djj + ' x/mnt, ' + ltp +' lilitan tali pusat, perikiraan berat janin ' + efw + ' gr';
            temp += ', umur kehamilan menurut USG saat ini = ' + uk_usg;
            temp += ', jenis kelamin ' + sex + ', plasenta di ' + plasenta + ', cairan ketuban 1 kantong terdalam ' + afi + ', ' + status_afi + ', ' + riw_obs + 'H' +  umur_kehamilan + ', Janin presentasi ' + presentasi +', ' + patologis;

            var periksa_lagi = '4 minggu lagi';
            if (minggu >= 37) {
                periksa_lagi = '1 minggu lagi';
            } else if(minggu >=32){
                periksa_lagi = '2 minggu lagi';
            }

            $('#saran').val('periksa lagi ' + periksa_lagi);

            console.log(temp);
            $('#kesimpulan').val(temp)
    }

    function riwObsG(){
     if ($('#G').val() != '' && $('#G').val() < 10) {
            var pasien_id = $('#pasien_id').val();
            $.post(base + '/anc/registerhamil', {'G': $('#G').val(), 'pasien_id' : pasien_id}, function(data, textStatus, xhr) {
                if (data != '') {
                    console.log(data);
                    if (data.buku != null) {
                        var buku = data.buku.id
                    } else {
                        var buku = 3;
                    }
                    $('#hpht').val(data.hpht);
                    $('#uk').val(data.uk);
                    $('#P').val(data.p);
                    $('#A').val(data.a);
                    $('#tanggal_lahir_anak_terakhir').val(data.tanggal_lahir_anak_terakhir);
                    $('#golongan_darah').val(data.golongan_darah);
                    $('#rencana_penolong').val(data.rencana_penolong);
                    $('#rencana_tempat').val(data.rencana_tempat);
                    $('#rencana_pendamping').val(data.rencana_pendamping);
                    $('#rencana_transportasi').val(data.rencana_transportasi);2
                    $('#rencana_pendonor').val(data.rencana_pendonor);
                    $('#tb').val(data.tb);
                    $('#jumlah_janin').val(data.jumlah_janin);
                    $('#status_imunisasi_tt_id').val(data.status_imunisasi_tt_id);
                    $('#nama_suami').val(data.nama_suami);
                    $('#buku').val(buku);
                    $('#bb_sebelum_hamil').val(data.bb_sebelum_hamil);
                    $('#riwayat_kehamilan').val(data.riwayat_kehamilan_sebelumnya);
                    uk_exec('uk', 'hpht');
                    viewNoFocus();
                }
            });
        } else {
          $('.gpa2').val('');
            $('.panelRiwayat').val('');
            $('#riwayat_kehamilan').val('[]');
            viewNoFocus();
        }
    }
function fokusKeAnemnesa(){
    $('#cekFoto').modal('hide');
    $('#cekFoto').on('hidden.bs.modal', function (e) {
        $('#anamnesa').focus();
        $('#labelKecelakaanKerja').on('shown.bs.popover', function(){
            setTimeout(function(){ 
                $('#labelKecelakaanKerja').popover('hide');
             }, 8000);
        });
        $('#labelKecelakaanKerja').popover('show');
    });

}

function showFotoZoom(){
    $('#fotozoom').modal('show');
}

function rupiah(){
    $('.uang:not(:contains("Rp."))').each(function() {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html('Rp. ' + number + ' ,-');
    });
}

function kecelakaanKerjaChange(control){
    var asuransi_id = $('#asuransi_id').val();
    var kklkk = $(control).val();
    var antrianperiksa_id = $('#antrianperiksa_id').val();
    if (asuransi_id == '32' && kklkk == '1') {
    $('#pleaseWaitDialog').modal({backdrop: 'static', keyboard: false});
        $.ajax({
            url: base + '/poli/ajax/kkchange',
            type: 'POST',
            data: {'antrianperiksa_id': antrianperiksa_id},
        })
        .done(function() {
            location.reload(true);
        })
        .fail(function() {
            $('#pleaseWaitDialog').modal('hide');
            console.log("error");
        });
    }
}

function asuransiIdChange(control){
    var asuransi_id = $(control).val();
    var antrianperiksa_id = $('#antrianperiksa_id').val();
    $('#pleaseWaitDialog').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: base + '/poli/ajax/asuridchange',
        type: 'POST',
        data: {
            'asuransi_id': asuransi_id,
            'antrianperiksa_id': antrianperiksa_id
        },
    })
    .done(function() {
        location.reload(true);
    })
    .fail(function() {
        $('#pleaseWaitDialog').modal('hide');
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
function bpjsBayar(){
    var asuransi_id = $('#asuransi_id').val();
    if (asuransi_id == '32') {
        var tindakan = $('#TotalDibayarTindakanBPJS').html();
        var obat = $('#totalBilaTipeBPJS').html();
        if (obat == 'Rp. ,-') {
            obat = 'Rp. 0,-';
        }
        if (tindakan == 'Rp. ,-') {
            tindakan = 'Rp. 0,-';
        }
        var total = parseInt(cleanUang(tindakan)) + parseInt(cleanUang(obat));
        $('#jumlahDibayarBpjs').html(total);
        if (total > 0) {
            $('#adaYangDibayar').hide().fadeIn(500);
        } else {
            $('#adaYangDibayar').hide();
        }
        rupiah();
    }
}


function bukanAsmaAkut(){
    var bool = false;
    apakahAsmaAkut(bool);
    var ket = 'Tindakan BPJS pasien ini tidak ditanggung BPJS, karena bukan asma akut. Tekan pilihan di bawah ini untuk mengubah'
    updateKeteranganNebuBpjs(ket, bool);
}
function asmaAkut(){
    var bool = true;
    apakahAsmaAkut(bool);
    var ket = 'Nebulizer ditanggung BPJS karena asma akut. Tekan pilihan di bawah ini untuk mengubah '
    updateKeteranganNebuBpjs(ket, bool);
}

function optionBilaNebuBpjs(){
    var tindakans = tindakansArray();
    var ada_nebu  = false;
    for (var i = 0; i < tindakans.length; i++) {
        if (tindakans[i].jenis_tarif_id == '102' || tindakans[i].jenis_tarif_id == '103') {
            ada_nebu = true;
            break;
        }
    }
    if (ada_nebu && $('#asuransi_id').val() == '32') {
        $('#option_bila_nebu_bpjs').hide().fadeIn(500);
    } else {
        $('#option_bila_nebu_bpjs').fadeOut(500);
    }
}

function tindakansArray(){
    var tindakans = $('#tindakan').val();
    tindakans     = $.parseJSON(tindakans);
    return tindakans;
}

function apakahAsmaAkut(ditanggung){
    if (ditanggung) {
        var keterangan = '(ditanggung)';
        var biaya_anak = 0;
        var biaya_dewasa = 0;
    } else {
        var keterangan = ' (TIDAK DITANGGUNG BPJS)'
        var biaya_anak = 45000;
        var biaya_dewasa = 40000;
    }
    var tindakans = tindakansArray();
    for (var i = 0; i < tindakans.length; i++) {
        if (tindakans[i].jenis_tarif_id == '102' || tindakans[i].jenis_tarif_id == '103' ) {
            var keterangan = tindakans[i].keterangan;
            var jenis_tarif_id = tindakans[i].jenis_tarif_id
            tindakans.splice(i, 1);
            if (jenis_tarif_id == '102') {
                var tindakan = {
                    "jenis_tarif_id"        :  "102",
                    "jenis_tarif"           :  "Nebulizer Anak " + keterangan,
                    "biaya"                 :  biaya_anak,
                    "keterangan_tindakan"   :  keterangan
                }
            } else {
                var tindakan = {
                    "jenis_tarif_id"        :  "103",
                    "jenis_tarif"           :  "Nebulizer Dewasa " + keterangan,
                    "biaya"                 :  biaya_dewasa,
                    "keterangan_tindakan"   :  keterangan
                }
            }
            tindakans[tindakans.length] = tindakan;
        }
    }

    var string = JSON.stringify(tindakans);
    $('#tindakan').val(string);
}
function updateKeteranganNebuBpjs(ket, bool){
    $('#keterangan_nebu_bpjs').html(ket);
    var e = $('#option_bila_nebu_bpjs');
    if (bool) {
        if (e.hasClass('alert-danger') || e.hasClass('alert-warning')) {
            e.removeClass('alert-danger');
            e.removeClass('alert-warning');
            e.addClass('alert-success');
        }
    } else if (e.hasClass('alert-warning') || e.hasClass('alert-success')){
            e.removeClass('alert-success');
            e.removeClass('alert-warning');
            e.addClass('alert-danger');
    }
    $('#option_bila_nebu_bpjs').hide().fadeIn(500);

}
