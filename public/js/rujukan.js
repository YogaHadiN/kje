jQuery(document).ready(function($) {
      hideOff();
      tagsAutocomplete();

      uk('umur_kehamilan', 'HPHT');

      if ($('#register_hamil_id').val() != '') {
        $('.inputObs').attr('readonly', 'readonly');
      }
      
      if ($('#jenis_rumah_sakit').val() == '') {
        $('#rumah_sakit').val('').attr('disabled', 'disabled');
      }
      $('#tujuan_rujuk').autocomplete({
        source : tujuan_rujuk_tags
      });

      $('#dummySubmit').click(function(e) {
        var tujuan_rujuk = $('#tujuan_rujuk').val();
        var rumah_sakit = $('#rumah_sakit').val();
        var hamil_id = $('#hamil_id').val();

        if (tujuan_rujuk == '' || rumah_sakit == '' || hamil_id == '' ) {// kenapa yang ini false?
          alert('kehamilan, rumah sakit dan spesialis harus diisi');
          if ($('#tujuan_rujuk').val() == '') { 
            validasi('#tujuan_rujuk', 'Harus Diisi!!');
          }
          if ($('#rumah_sakit').val() == '') {
            validasi('#rumah_sakit', 'Harus Diisi!!');
          }
          if ($('#hamil_id').val() == '') {
            validasi('#hamil_id', 'Harus Dipilih!!');
          }
        } else if(hamil_id == '1' && ($('.inputObs').val() == '' || $('.gpa').val() == '')){
          alert('harap isi dengan lengkap informasi kehamilan')
          if ($('.inputObs').val() == '') {
            validasi3('.inputObs', 'Harus Diisi!!');
          }
          if ($('.gpa').val() == '') {
            validasi3('.gpa', 'Harus Diisi!!');
          }
        } else {
          $('#submit').click();
        }
      });

      $('#jenis_rumah_sakit').change(function(e) {
        tagsAutocomplete();
        $('#rumah_sakit').val('');
      });

      $('#hamil_id').change(function(e) { 
        hideOff();
      });

      $('#G').keyup(function(e) {
        if ($(this).val() != '' && $(this).val() < 10) {
          $.post(base+'/anc/registerhamil', {'G': $(this).val(), 'pasien_id' : $('#pasien_id').val() }, function(data) {
                $('#HPHT').val(data.hpht);
                $('#umur_kehamilan').val(data.uk);
                $('#P').val(data.p);
                $('#A').val(data.a);
          });
        } else {
          $('.gpa2').val('');
          emptyObs();
        }
      });

    });

    function hideOff(){
        if ($('#hamil_id').val() == '1') {
            $('#riwobs').removeClass('hide').hide().fadeIn(500);
        } else {
            emptyObs();
            $('#riwobs').removeClass('hide').fadeOut(500);
        }
    }
    function emptyObs(){
          $('.inputObs').val('').removeAttr('readonly');
          $('#register_hamil_id').val('');
    }
    function tagsAutocomplete(){
       var tipe = $('#jenis_rumah_sakit').val();
        if (tipe != '') {
          var tags;
          $('#rumah_sakit').removeAttr('disabled');
          $.post(base+ '/rujuajax/rs', {'tipe_rumah_sakit_id': tipe }, function(data, textStatus, xhr) {
              tags = $.parseJSON(data);
              $('#rumah_sakit').autocomplete({
                source : tags
              });
          });
        } else {
          $('#rumah_sakit').val('').attr('disabled', 'disabled')
        }
    }

    function tujuanChange(control){
      var tujuan_rujuk = $(control).val();
      if (tujuan_rujuk != '') {
        $.post(base + '/rujuajax/tujurujuk', {'tujuan_rujuk': tujuan_rujuk, 'asuransi_id' : asuransi_id}, function(data, textStatus, xhr) {
          var temp = '';
          if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              temp += '<tr>';
              temp += '<td>' + data[i].nama + '</td>';
              temp += '<td>' + data[i].rayon + '</td>';
              temp += '<td>' + data[i].jenis_rumah_sakit + '</td>';
              temp += '<td>' + data[i].tipe_rumah_sakit + '</td>';
              temp += '</tr>';
            }
          } else {
            temp += '<td> Tidak Ada Data, atau pilih yang lain yang ada </td>'
          }
          var text = '<div class="panel panel-default"><div class="panel-body">';
          text += '<h3>Ketersediaan ' + $('#tujuan_rujuk').val() + '</h3>';
          if (asuransi_id == '32') {
            text += '<div class"text-red text-center">Khusus untuk Pasien BPJS harus Rumah Sakit tipe C (atau D) kecuali spesialis tersebut tidak ada</div><br />';
          }
          text += '<table class="table table-condensed table-bordered DTaja"><tbody>';
          text += '<thead><tr>';
          text += '<th>' + 'Nama' + '</th>';
          text += '<th>' + 'Rayon' + '</th>';
          text += '<th>' + 'Jenis' + '</th>';
          text += '<th>' + 'tipe' + '</th>';
          text += temp;
          text += '</tbody></table></div></div>';

          $('#info-ketersediaan').html(text).hide();
          $('#info-ketersediaan').fadeIn(600);

        })
      };
    }

    function rschange(control){
      var rumah_sakit = $(control).val();

      if (rumah_sakit != '') {
        $.post(base+'/rujuajax/rschange', {'rumah_sakit': rumah_sakit}, function(data, textStatus, xhr) {

            if (data.ugd != null) {
              ugd = data.ugd;
            } else {
              ugd = '';
            }

            var temp = '';
            temp += '<h3>Informasi ' + rumah_sakit+ ' </h3>';
            temp += '<div class="form-group">';
            temp += '<label for="rumah_sakit_alamat">Alamat</label>';
            temp += '<textarea class="form-control" type="text" placeholder="Cari Info di Internet" name="rumah_sakit_alamat">' +data.alamat+ '</textarea>';
            temp += '</div>';
            temp += '<div class="form-group">';
            temp += '<label for="rumah_sakit_telepon">Telepon</label>';
            temp += '<input  type="text" class="form-control" value="' +data.telepon+ '" placeholder="Cari Info di Internet" name="rumah_sakit_telepon" />';
            temp += '</div>';
            temp += '<div class="form-group">';
            temp += '<label for="rumah_sakit_ugd">UGD</label>';
            temp += '<input  type="text" class="form-control" value="' +ugd+ '" placeholder="Cari Info di Internet" name="rumah_sakit_ugd" />';
            temp += '</div>';
            temp += '<br /><div class="alert alert-success"><h4>Isian ini secara otomatis akan tertulis di surat rujukan</h4></div>';
            var text = '<div class="panel panel-default"><div class="panel-body">';


            text += temp;
            text += '</div></div>';
            console.log(text);
          $('#info-ketersediaan').html(text).hide().fadeIn(600);

        });
      };
    }






