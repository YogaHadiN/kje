   function resepJson(result){
        if(result != ""){
                var MyArray = JSON.parse(result);
            } else {
                var MyArray = "";
            }
            var temp = '<table width="100%">';
          if (MyArray.length > 0){
            for (var i = 0; i < MyArray.length - 1; i++) {
                //Untuk menghitung urutan add sirup yang terakhir
                
                if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="text-align:left; width:150px;" nowrap>' + MyArray[i].merek_obat + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="text-align:left; width:150px;" nowrap>' + MyArray[i].merek_obat + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek_obat + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
                    temp += '<td> fls No : ' + MyArray[i].jumlah + '</td>';
                    temp += '</tr>';
                    temp += '<tr>';
                    temp += '<td style="text-align:center;" colspan="3">ADD</td>';
                    temp += '</tr>';

                    $('#boolAdd').val('1');


                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek_obat + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[i].merek_obat + ' <strong>[  ' + MyArray[i].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="width:150px;" nowrap>' + MyArray[a].merek_obat + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="width:150px;" nowrap>' + MyArray[a].merek_obat + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
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
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek_obat + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    temp += '<tr>';
                    temp += '<td style="width:15px"></td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek_obat + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
                    temp += '<td> No : ' + MyArray[a].jumlah + '</td>';
                } else {

                    temp += '<tr>';
                    temp += '<td style="width:15px">R/</td>';
                    temp += '<td style="width:150px;text-align:left;" nowrap>' + MyArray[a].merek_obat + ' <strong>[  ' + MyArray[a].rak_id + '  ]</strong></td>';
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
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
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
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
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
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '</tr>';

                    $('#puyer').val('0');
                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {


                    ID_TERAPIGroup = []
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>'  ;
                    temp2 += '<td> fls No : ' + MyArray[i].jumlah + '</td>';
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
                    temp2 += '<td style="text-align:left;"><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
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
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += '</tr>';

                    $('#puyer').val('0');
                } else {
                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
                    temp2 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr><tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[i].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp2 += '<td class="displayNone"></td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
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
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
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
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';

                    $('#boolAdd').val('0');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {
                    console.log(MyArray[a].merek_id + ' = 3');


                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp2 += '<td> fls No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr>';
                    temp2 += '<tr>';
                    temp2 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                    $('#boolAdd').val('1');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    console.log(MyArray[a].merek_id + ' = 4');

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
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
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    $('#puyer').val('1');
                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    console.log(MyArray[a].merek_id + ' = 6');

                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                } else {

                    console.log(MyArray[a].merek_id + ' = 7');

                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp2 += '<tr>';
                    temp2 += '<td style="width:15px">R/</td>';
                    temp2 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp2 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp2 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp2 += '<td></td>';
                    temp2 += '</tr><tr>';
                    temp2 += '<td style="width:15px"></td>';
                    temp2 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[a].signa + '</td>';
                    temp2 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    temp2 += "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" + JSON.stringify(ID_TERAPIGroup) + "'>hapus</button></td>";
                    temp2 += '<td class="displayNone"></td>';
                }
                temp2 += '</tr></tbody></table>';
             } else {
                temp2 = "";
                temp = "";
             }
                    //=============================================================
            //=============================================================
            //=============================================================
           $('#puyer').val('0');
            $('#boolAdd').val('0');
            var temp3 = '<table class="RESEP table table-condensed"><tbody>';

            var ID_TERAPIGroup = [];

            //lert(MyArray[0].signa);
          if (MyArray.length > 0){
            for (var i = 0; i < MyArray.length - 1; i++) {
                if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '0') {
                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
                    temp3 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr>';


                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }
                } else if (MyArray[i].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {




                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
                    temp3 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr>';

                    if (MyArray[i].signa == MyArray[i + 1].signa) {
                        $('#puyer').val('1');
                    } else {
                        $('#puyer').val('0');
                    }
                } else if (MyArray[i].merek_id == -1 || MyArray[i].merek_id == -3) {



                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' + MyArray[i].jumlah + ' puyer ' + MyArray[i].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr>';

                    $('#puyer').val('0');
                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {


                    ID_TERAPIGroup = []
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };
                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>'  ;
                    temp3 += '<td> fls No : ' + MyArray[i].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr>';
                    temp3 += '<tr>';
                    temp3 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                    temp3 += '<td class="displayNone"></td>';
                    temp3 += '</tr>';


                    id_formula_sirup_add = MyArray[i].formula_id;
                    addSatu = false;
                    console.log('id_formula_sirup_add = ' + id_formula_sirup_add);

                    $('#boolAdd').val('1');
                } else if (MyArray[i].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {


                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="text-align:left;"><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
                    temp3 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr>';

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

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' + MyArray[i].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                    temp3 += '<td class="displayNone"></td>';
                    temp3 += '</tr>';

                    $('#puyer').val('0');
                } else {
                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : i };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[i].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[i].merek_obat + '</a></t[d>  ';
                    temp3 += '<td>   No : ' + MyArray[i].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[i].merek_id + '</td>';
                    temp3 += '</tr><tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[i].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[i].aturan_minum + '</td>';
                    temp3 += '<td class="displayNone"></td>';
                    temp3 += '</tr>';
                }
            }
                var a = MyArray.length - 1;

                if (MyArray[a].merek_id == -1 || MyArray[a].merek_id == -3) {
                    console.log(MyArray[a].merek_id + ' = 1');


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };


                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' + MyArray[a].jumlah + ' puyer ' + MyArray[a].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    temp3 += '<td class="displayNone"></td>';

                    $('#puyer').val('0');
                } else if (MyArray[a].merek_id == -2) {
                    console.log(MyArray[a].merek_id + ' = 2');


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' + MyArray[a].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                    temp3 += '<td class="displayNone"></td>';

                    $('#boolAdd').val('0');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '0') {
                    console.log(MyArray[a].merek_id + ' = 3');


                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp3 += '<td> fls No : ' + MyArray[a].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp3 += '</tr>';
                    temp3 += '<tr>';
                    temp3 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                    temp3 += '<td class="displayNone"></td>';
                    $('#boolAdd').val('1');
                } else if (MyArray[a].signa.substring(0, 3) == "Add" && $('#boolAdd').val() == '1') {


                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    console.log(MyArray[a].merek_id + ' = 4');

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp3 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';


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

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp3 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    $('#puyer').val('1');
                } else if (MyArray[a].signa.substring(0, 5) == "Puyer" && $('#puyer').val() == '1') {

                    console.log(MyArray[a].merek_id + ' = 6');

                    ID_TERAPIGroup = [];
                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp3 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                } else {

                    console.log(MyArray[a].merek_id + ' = 7');

                    ID_TERAPIGroup = [];

                    ID_TERAPIGroup[ID_TERAPIGroup.length] = { "id" : a };

                    temp3 += '<tr>';
                    temp3 += '<td style="width:15px">R/</td>';
                    temp3 += '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' + MyArray[a].merek_id + '" onclick="informasi(this); return false; " href="#" nowrap>' + MyArray[a].merek_obat + '</a></td>';
                    temp3 += '<td> No : ' + MyArray[a].jumlah + '</td>';
                    temp3 += '<td class="displayNone">' + MyArray[a].merek_id + '</td>';
                    temp3 += '</tr><tr>';
                    temp3 += '<td style="width:15px"></td>';
                    temp3 += '<td style="border-bottom:1px solid #000;"> S ' + MyArray[a].signa + '</td>';
                    temp3 += '<td style="border-bottom:1px solid #000;" nowrap>' + MyArray[a].aturan_minum + '</td>';
                    temp3 += '<td class="displayNone"></td>';
                }
                temp3 += '</tr></tbody></table>';
             } else {
                temp2 = "";
                temp3 = "";
                temp = "";
             }
             return [temp, temp2, temp3];
    }