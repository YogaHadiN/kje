var input_nama            = '';
var input_image           = '';
var input_nama_asuransi   = '';
var input_option_asuransi = '';
var input_ID              = '';
var input_asuransi_id     = '';
var input_prolanis_dm     = '';
var input_prolanis_ht     = '';

function rowEntry(control) {
    resetEntry();
    input_nama             = $(control).closest('tr').find('td:nth-child(2) div').html();
    input_image            = base_s3 + '/' + $(control).closest('tr').find('.pasien_image div').html();
    input_nama_asuransi    = $(control).closest('tr').find('.nama_asuransi div').html();

    input_ID               = $(control).closest('tr').find('td:first-child div').html();
    input_asuransi_id      = $(control).closest('tr').find('.asuransi_id div').html();
    input_prolanis_dm      = $(control).closest('tr').find('.prolanis_dm div').html();
    input_prolanis_ht      = $(control).closest('tr').find('.prolanis_ht div').html();
    return processEntry();
}

function resetEntry() {
    input_option_asuransi  = '<option value="">- Pilih Pembayaran -</option>';
    input_option_asuransi += '<option value="0">Biaya Pribadi</option>';
    $('#antrianpoli_poli').val('');
    $('#antrianpoli_tanggal').val('');
    $('#cekBPJSkontrol').hide();
    $('#cekGDSBPJS').hide();
    $('#cekProlanisDM').hide();
    $('#cekProlanisHT').hide();
}

function processEntry() {
    console.log('input_nama : ' + input_nama);
    console.log('input_image : ' + input_image);
    console.log('input_nama_asuransi : ' + input_nama_asuransi);
    console.log('input_ID : ' + input_ID);
    console.log('input_asuransi_id : ' + input_asuransi_id);
    console.log('input_prolanis_dm : ' + input_prolanis_dm);
    console.log('input_prolanis_ht : ' + input_prolanis_ht);

    if (input_prolanis_dm == '1') {
        $('#cekProlanisDM').show();

        $.get( base + '/pasiens/ajax/status_cel_gds_bulan_ini',
            { 
                pasien_id: input_ID
            },
            function (data, textStatus, jqXHR) {
                data = $.trim(data);
                if (data > 0) {
                    $('#gds_prolanis_status').html('Sudah ');
                } else {
                    $('#gds_prolanis_status').html('Harus ');
                }
            }
        );

    }
    if (input_prolanis_ht == '1') {
        $('#cekProlanisHT').show();
    }

    cekBPJSkontrol(input_ID, input_asuransi_id);

    imgError();

    if (input_asuransi_id != '0') {
        input_option_asuransi += '<option value="' + input_asuransi_id + '">' + input_nama_asuransi + '</option>'
    };

    $('#lblInputNamaPasien').html(input_ID + ' - ' + input_nama)
        .closest('.form-group')
        .removeClass('has-error')
        .find('code')
        .remove();
    $('#namaPasien').val(input_nama);
    $('#imageForm').attr('src', input_image);
    $('#ID_PASIEN').val(input_ID);
    $("#ddlPembayaran").html(input_option_asuransi);
    resetComplain();
    $('#exampleModal').modal('show');
    return false;
}
function chosenEntry(control) {
    resetEntry();
    input_nama             = $(control).closest('div').find('.nama').html();
    input_image            = base + '/' + $(control).closest('div').find('.image').html();
    input_nama_asuransi    = $(control).closest('div').find('.nama_asuransi').html();
    input_ID               = $(control).closest('div').find('.pasien_id').html();
    input_asuransi_id      = $(control).closest('div').find('.asuransi_id').html();
    input_prolanis_dm      = $(control).closest('div').find('.prolanis_dm').html();
    input_prolanis_ht      = $(control).closest('div').find('.prolanis_ht').html();
    return processEntry();
}
