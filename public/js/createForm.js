

        if($('#json').val() == '' || $('#json').val() == '[]'){

            var json = [];

        } else {

            var json = JSON.parse($('#json').val());
            select_json(json);
            $('#indikasi').focus();
        }

        console.log(json);

        $(document).ready(function() {

            $('#dosis_row').hide();

                $('#fornasHide').hide();


            if($('#fornas').val() == '0'){
                $('#fornasHide').hide().fadeIn(500);
            } else {
                $('#fornasHide').fadeOut(500);
            }

            $('#fornas').change(function(){

                if ($(this).val() == '0') {
                    $('#fornasHide').hide().fadeIn(500);
                } else {

                    $('#fornasHide').fadeOut(500);
                }

            });

            $('#inputKomposisi').keypress(function(e) {
                var key = e.keyCode || e.which;

                if (key == 9){
                    $(this).click();
                    return false;
                }
            });
            $('#inputKomposisi').click(function(e) {

                e.preventDefault();
                var generik = $('#ddlGenerik').val();
                var satuan = $('#slcSatuan').val();
                var bobot = $('#txtBobot').val() + ' ' + satuan;
                var generikText = $('#ddlGenerik option:selected').text();

                if(generik == '' || satuan == '' || $('#txtBobot').val() == '' ){

                    alert('semua kolom harus diisi!!');
                    re();

                } else if (!$.isNumeric($('#txtBobot').val())){
                        $('#txtBobot').closest('td').find('code').remove();
                        $('#txtBobot').closest('td').append('<code>Harus Angka</code>').hide().fadeIn(1000);


                        $('#txtBobot').keyup(function(e) {

                            $('#txtBobot').closest('td').find('code').fadeOut('500', function() {
                                $(this).remove();
                            });;

                        });


                } else {

                    // cek dulu jangan sampai memasukkan generik yang sama
                    var sama = false;
                    for (var i = 0; i < json.length; i++) {
                        if(generik == json[i].generik_id ){
                            sama = true;
                            alert('tidak boleh memasukkan generik yang sama dua kali');
                            re();
                            break;
                        }
                    }

                    if(sama == false ){
                        var data = {

                            "generik_id" : generik,
                            "bobot" : bobot,
                            "generik" : generikText

                        };
                        // input object json yang baru
                        json[json.length] = data;
                        select_json(json);
                    }
                }
            });

                $('#dummySubmitFormula').click(function(e) {
                    console.log('masuk dummySubmitFormula');
                    e.preventDefault();
                    $('select[name="dijual_bebas"]').closest('.form-group').find('code').remove();
                    $('textarea[name="efek_samping"]').closest('.form-group').find('code').remove();
                    $('select[name="sediaan"]').closest('.form-group').find('code').remove();
                    $('textarea[name="indikasi"]').closest('.form-group').find('code').remove();
                    $('input[name="rak_id"]').closest('.form-group').find('code').remove();
                    $('textarea[name="kontraindikasi"]').closest('.form-group').find('code').remove();
                    $('input[name="merek"]').closest('.form-group').find('code').remove();
                    $('select[name="fornas"]').closest('.form-group').find('code').remove();
                    $('select[name="aturan_minum_id"]').closest('.form-group').find('code').remove();
                    $('input[name="harga_jual"]').closest('.form-group').find('code').remove();
                    if(
                            $('select[name="dijual_bebas"]').val() == '' ||
                            $('textarea[name="efek_samping"]').val() == '' ||
                            $('select[name="sediaan"]').val() == '' ||
                            $('textarea[name="indikasi"]').val() == '' ||
                            $('input[name="rak_id"]').val() == '' ||
                            $('input[name="kontraindikasi"]').val() == '' ||
                            $('input[name="merek"]').val() == '' ||
                            $('select[name="fornas"]').val() == '' ||
                            $('select[name="aturan_minum_id"]').val() == '' ||
                            $('input[name="harga_jual"]').val() == ''
                       ){
                            if($('select[name="dijual_bebas"]').val() == '' ){
                                validasi('select[name="dijual_bebas"]', 'Harus diisi');
                            }
                            if($('input[name="rak_id"]').val() == '' ){
                                validasi('input[name="rak_id"]', 'Harus diisi');
                            }
                            if($('textarea[name="efek_samping"]').val() == '' ){
                                validasi('textarea[name="efek_samping"]', 'Harus diisi');
                            }
                            if($('select[name="sediaan"]').val() == '' ){
                                validasi('select[name="sediaan"]', 'Harus diisi');
                            }
                            if($('textarea[name="indikasi"]').val() == '' ){
                                validasi('textarea[name="indikasi"]', 'Harus diisi');
                            }
                            if($('textarea[name="kontraindikasi"]').val() == '' ){
                                validasi('textarea[name="kontraindikasi"]', 'Harus diisi');
                            }
                            if($('input[name="merek"]').val() == '' ){
                                validasi('input[name="merek"]', 'Harus diisi');
                            }
                            if($('select[name="fornas"]').val() == '' ){
                                validasi('select[name="fornas"]', 'Harus diisi');
                            }
                            if($('select[name="aturan_minum_id"]').val() == '' ){
                                validasi('select[name="aturan_minum_id"]', 'Harus diisi');
                            }
                            if($('input[name="harga_jual"]').val() == '' ){
                                validasi('input[name="harga_jual"]', 'Harus diisi');
                            }
                        } else {
                            $('.btn, form:input').attr('disabled', 'disabled');
                            $.post(base + "/formulas/ajax/ajaxformula", {'json': json, 'merek' : $('#merek').val(), 'sediaan' : $('#sediaan').val(), 'rak_id' : $('#rak_id').val(), '_token' : $('#token').val() }, function(data) {
                                data = JSON.parse(data);

                                if( data.formula == '1' || data.merek == '1' || data.rak == '1' ){
                                    if(data.formula == '1'){
                                        alert('formula sama');
                                        var lists = data.temp;
                                        $('.btn').removeAttr('disabled');

                                        var temp = '<div class="panel panel-warning">';
                                        temp += '<div class="panel-body">'
                                        temp += '<div id="tool"><div><code>Tidak bisa dilanjutkan!!</code></div>';
                                        temp += '<div><code>Komposisi yang sama sudah pernah dibuat. Untuk melanjutkan pilih salah satu</code></div>';
                                        temp += '<div><code>Buat <a href="' +base+ '/create/raks/' + lists[0].formula_id + '">Rak Baru</a> dengan formula yang sama</code></div>';
                                        temp += '<div><code>Buat <a href="' +base+ '/formulas/create">Formula Baru</a> dengan komposisi yang berbeda</code></div>';
                                        temp += '<div><code>Atau Buat merek yang sama di Rak yang diinginkan: </code></div><br>';
;
                                        temp += '<table class="table table-condensed table-bordered">';
                                        temp += '<thead>';
                                        temp += '<th>Merek</th>';
                                        temp += '<th>Rak</th>';
                                        temp += '<th>Harga Beli</th>';
                                        temp += '<th>Harga Jual</th>';
                                        temp += '<th>Action</th>';
                                        temp += '</thead>';
                                        temp += '<tbody>';
                                        for (var i = 0; i < lists.length; i++) {
                                            temp += '<tr>';
                                            temp += '<td>' + lists[i].merek + '</td>';
                                            temp += '<td>' + lists[i].rak_id + '</td>';
                                            temp += '<td>' + lists[i].harga_beli + '</td>';
                                            temp += '<td>' + lists[i].harga_jual + '</td>';
                                            temp += '<td><a href="' +base+ '/create/mereks/' +lists[i].rak_id+ '" class="btn btn-success btn-xs">merek baru</a></td>';
                                            temp += '</tr>';
                                        };
                                        temp += '</tbody>';
                                        temp += '</table>';
                                        temp += '</div>';
                                        temp += '</div>';
                                        temp += '</div>';
                                        $('.panel-success').after(temp);
                                        $('#tool').hide().fadeIn(1000);

                                    } else if (data.merek == '1' || data.rak == '1' ) {
                                        $('.btn, form:input').removeAttr('disabled');

                                        if(data.merek == '1'){
                                            validasi('#merek', 'Merek yang sama sudah ada');
                                            alert('Merek yang sama sudah ada');
                                            $('#merek').focus();
                                         }
                                        if(data.rak == '1'){
                                            validasi('#rak_id', 'Rak yang sama sudah ada');
                                            alert('Rak yang sama sudah ada');
                                            $('#rak_id').focus();
                                        }
                                    }

                                } else {

                                    $('#submitFormula')
                                    .removeAttr('disabled')
                                    .click();

                                }
                            });
                        }

            });
        });

        function row_delete(control) {

            var no = $(control).val();
            json.splice(no, 1);
            select_json(json);

        }

        function select_json(json) {

             var temp = '';

            for (var i = 0; i < json.length; i++) {

                temp += '<tr>';
                temp += '<td>' + json[i].generik + '</td>';
                temp += '<td colspan="2">' + json[i].bobot + '</td>';
                temp += '<td><button type="button" class="btn btn-danger btn-xs" value="' + i + '" onclick="row_delete(this); return false;">hapus</button></td>';
                temp += '</tr>';

            }
            var string = JSON.stringify(json);

            console.log('string = ' + string);
            $('#ajax1').html(temp);
            $('#json').val(string);

            console.log('json val = ' + $('#json').val());
            re();

        }

        function re(){

            $('#ddlGenerik')
                .val('')
                .selectpicker('refresh')
                .closest('td')
                .find('.btn-white')
                .focus();
            $('#txtBobot').val('');

        }

        function validasi(selector, pesan) {

            $(selector).closest('.form-group')
            .addClass('has-error')
            .append('<code>' + pesan + '</code>')
            .hide()
            .fadeIn(1000);


            if($(selector).prop('tagName').toLowerCase() == 'input' || $(selector).prop('tagName').toLowerCase() == 'textarea'){
                 $(selector).keyup(function(){
                    $(this).closest('.form-group')
                    .removeClass('has-error')
                    .find('code')
                    .fadeOut('1000', function() {
                        $(this).remove();
                    });
                 })   
             } 
              if($(selector).prop('tagName').toLowerCase() == 'select' || $(selector).attr('class') == 'form-control tanggal'){
                 $(selector).change(function(){
                    $(this).closest('.form-group')
                    .removeClass('has-error')
                    .find('code')
                    .fadeOut('1000', function() {
                        $(this).remove();
                    });
                 })   
             }

        }

        function show_dose(){
            $('#dosis_row').slideToggle(1000);
        }