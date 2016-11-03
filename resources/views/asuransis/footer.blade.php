<script type='text/javascript'>
            var biaya = '';
            var dibayar_asuransi = '';
            var jasa_dokter = '';
            var tipe_tindakan = '';

            var tarifs = $('#tarifs').val();
            tarifs = $.parseJSON(tarifs);

            var temp = '';
                @foreach($tarifs as $key => $tarif)
                temp += '<tr>';
                temp += '<td nowrap>' + '{!! $tarif->jenisTarif->jenis_tarif !!}' + '</td>';
                temp += '<td nowrap>' + '{!! $tarif->biaya !!}' + '</td>';
                temp += '<td nowrap>' + '{!! $tarif->jasa_dokter !!}' + '</td>';
                @if($tarif->tipe_tindakan_id == 1)
                    temp += '<td>' + 'Non Paket' + '</td>';
                @elseif($tarif->tipe_tindakan_id == 2)
                    temp += '<td>' + 'Paket dengan Obat' + '</td>';
                @else
                    temp += '<td>' + 'Paket Jasa Dokter tanpa Obat' + '</td>';
                @endif
                temp += '<td>' + '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="{!! $key!!}">edit</buttom>' + '</td>';
                temp += '<td nowrap class="hide">' + '{!! $tarif->id !!}' + '</td>';
                temp += '</tr>';
            @endforeach

            $('#tblTarif').html(temp);
            </script>
            <script>
                function rowEdit(control){
                    var index = $(control).closest('tr').index() + 1;

                    biaya = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html();
                    jasa_dokter = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html();
                    tipe_tindakan = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html();
                    var tipe_tindakan_id = '';
                    if (tipe_tindakan == 'Non Paket') {
                        tipe_tindakan_id = '1';
                    } else if (tipe_tindakan == 'Paket dengan Obat'){
                        tipe_tindakan_id = '2';
                    }

                    var txtbiaya = '<div class="w"><input type="text" class="form-control" value="' +biaya+ '" id="txtbiaya" /></div>';
                    var txtjasadokter = '<div class="w"><input type="text" class="form-control" value="' +jasa_dokter+ '" id="txtjasadokter"/></div>';
                    var ddltipetindakan = '<select class="form-control" id="ddltipetindakan">';
                    if (tipe_tindakan_id == 1) {
                        ddltipetindakan += '<option value="1" selected>Non Paket</option><option value="2">Paket dengan Obat</option>'
                    } else if (tipe_tindakan_id == 2){
                        ddltipetindakan += '<option value="1">Non Paket</option><option value="2" selected>Paket dengan Obat</option>'
                    }
                    ddltipetindakan += '</select>';
                    console.log('keluar');
                    
                    var action = '';
                    action += '<button type="button" class="btn btn-info btn-block" onclick="rowUpdate(this);return false;">Update</button>';
                    action += '<button type="button" class="btn btn-danger btn-block" onclick="rowCancel(this);return false;">Cancel</button>';

                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(txtbiaya);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(txtjasadokter);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(ddltipetindakan);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(action);

                    $('#tblTarif tr:nth-child(' + index + ') input[type="text"]').on("click", function () {
                        $(this).select();
                    });

                    $('#tblTarif tr:nth-child(' + index + ') #txtbiaya').click();

                    $('.btn-warning').attr('disabled', 'disabled');

                    $("#tblTarif .form-control").keydown(function (e) {
                        console.log('masuk');
                        // Allow: backspace, delete, tab, escape, enter and .
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                             // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                             // Allow: Ctrl+C
                            (e.keyCode == 67 && e.ctrlKey === true) ||
                             // Allow: Ctrl+X
                            (e.keyCode == 88 && e.ctrlKey === true) ||
                             // Allow: home, end, left, right
                            (e.keyCode >= 35 && e.keyCode <= 39)) {
                                 // let it happen, don't do anything
                                 return;
                        }
                        // Ensure that it is a number and stop the keypress
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();
                        }
                    });

                }
            </script>
            <script>
                function rowCancel(control){

                    var index = $(control).closest('tr').index() + 1;

                    $('.btn-warning').removeAttr('disabled');

                  
                    var htmaction = '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="{!! $key!!}">edit</buttom>';

                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(biaya);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(jasa_dokter);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(tipe_tindakan);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(htmaction);

                }
            </script>

            <script>
                function rowUpdate(control){

                    var key = $(control).closest('tr').index();
                    var index = key + 1;

                    var id = $('#tblTarif tr:nth-child(' + index + ') td:last-child').html();

                    console.log('id = ' + id);


                    var biaya_update = $('#txtbiaya').val();
                    var jasa_dokter_update = $('#txtjasadokter').val();
                    var tipe_tindakan_update = $('#ddltipetindakan option:selected').text();
                    var tipe_tindakan_id_update = $('#ddltipetindakan').val();

                    console.log('biaya_update = ' + biaya_update);
                    console.log('jasa_dokter_update = ' + jasa_dokter_update);
                    console.log('tipe_tindakan_update = ' + tipe_tindakan_update);
                    console.log('tipe_tindakan_id_update = ' + tipe_tindakan_id_update);

                    tarifs[key]['biaya'] = empty(biaya_update);
                    tarifs[key]['jasa_dokter'] = empty(jasa_dokter_update);
                    tarifs[key]['tipe_tindakan_id'] = tipe_tindakan_id_update;

                    console.log(tarifs);

                    var htmaction = '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="{!! $key!!}">edit</buttom>';
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(empty(biaya_update));
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(empty(jasa_dokter_update));
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(tipe_tindakan_update);
                    $('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(htmaction);

                    $('#tarifs').val(JSON.stringify(tarifs));


                    $('.btn-warning').removeAttr('disabled');

                }

                function empty(val){

                    if (val == '') {
                        val = '0';
                    }

                    return val
                }
            </script>
