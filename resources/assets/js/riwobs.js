var riwayat = [];

$('#input_riwayat').keydown(function(e) {
    var key = e.keyCode || e.which;
    if (key == 9) {
        $('#input_riwayat').click();
        return false;
    }
});

function inputRiwayatKehamilan(control){
        var riwayat = riwayat_obs();
            if ($('#inputSpontanSC').val() != '') {

                var jenis_kelamin = $('#inputJenisKelamin').val();
                var berat_lahir = $('#inputBeratLahir').val();
                var tahun_lahir = $('#inputTahunLahir').val();
                var lahir_di = $('#inputLahirDi').val();
                var spontan_sc = $('#inputSpontanSC').val();

                riwayat[riwayat.length] = {
                    'jenis_kelamin' : jenis_kelamin,
                    'berat_lahir'   : berat_lahir + ' gr',
                    'tahun_lahir'   : tahun_lahir,
                    'lahir_di'      : lahir_di,
                    'spontan_sc'    : spontan_sc
                } 
                string_obs(riwayat);
               view();
            } else {
                validasi('#inputSpontanSC', 'Hapus Diisi!!');
            }
        }

        function rowDel(control){

            riwayat = riwayat_obs();
            var i = $(control).closest('tr').find('td:first-child');
            i = parseInt(i) - 1 ;

            riwayat.splice(i, 1);
            string_obs(riwayat);
            view();
        }

        function viewNoFocus(){

            var temp = '';
            riwayat = riwayat_obs();
            for (var i = 0; i < riwayat.length; i++) {
                n = parseInt(i) + 1;

                var maks = parseInt(riwayat.length) - 1;

                temp += '<tr>';
                temp += '<td>' + n + '</td>';
                temp += '<td>' + riwayat[i].jenis_kelamin + '</td>';
                temp += '<td>' + riwayat[i].berat_lahir + '</td>';
                temp += '<td>' + riwayat[i].tahun_lahir + '</td>';
                temp += '<td>' + riwayat[i].lahir_di + '</td>';
                temp += '<td>' + riwayat[i].spontan_sc + '</td>';
                if(i == maks){
                    temp += '<td>' + '<button type="button" class="btn btn-danger btn-xs" onclick="rowDel(this);return false;">hapus</button>' + '</td>';
                } else {
                    temp += '<td></td>';
                }
                temp += '</tr>';
            }

            var keyini = parseInt(riwayat.length) + 1

            temp            +='<tr>';
            temp            +='<td>' + keyini + '</td>';
            temp            +='<td>ini<td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='</tr>';

            $('.inp').val('');
            $('#table_riwayat_kehamilan').html(temp);

            var string = JSON.stringify(riwayat);
            $('#riwayat_kehamilan').val(string);

        }
         function view(){

            viewNoFocus();
            $('#inputJenisKelamin').focus();    


        }

        function riwayat_obs(){
            riwayat = $('#riwayat_kehamilan').val();
            if (riwayat == '') {
                riwayat = '[]';
            }
            return JSON.parse(riwayat);
        }

        function string_obs(riwayat){
            riwayat = JSON.stringify(riwayat);
            $('#riwayat_kehamilan').val(riwayat);
        }


