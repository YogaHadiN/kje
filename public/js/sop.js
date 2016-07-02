if ($('#terapis').val() == '' || $('#terapis').val() == '[]') {
  var terapis = [];
} else {
  var terapis = $('#terapis').val();
  terapis = $.parseJSON(terapis);
}
  jQuery(document).ready(function($) {
    viewTerapis();
  });

  function submitResep(){
    if (data != '' || data != [] ) {
      terapis[terapis.length] = data;
      terapiString = JSON.stringify(terapis);
      $('#terapis').val(terapiString);
      viewTerapis();
      clear();
    }
  }

    function clear(){
      $('#ajax5').html('');
      $('#terapi').val('');
      data = [];
      namaObatFocus();
    }

    function viewTerapis(){
      if ($('#terapis').val() == '' || $('#terapis').val() == '[]' ) {
        $('#terapis').val('[]');
        var textKosong = "<h1 class='text-center'>Tidak Ada Terapi Untuk Ditampilkan</h1>"
        $('#terapisContainer').html(textKosong).hide().fadeIn(500);
      } else {

            var jsonTerapis = $('#terapis').val();
            var arrTerapis = $.parseJSON(jsonTerapis);

            var temp = '';
            for (var i = 0; i < arrTerapis.length; i++) {
              var terapi = arrTerapis[i];
              terapi = JSON.stringify(terapi);
              temp += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
              temp += '<div class="panel panel-default">';
              temp += '<div class="panel-body">';
              temp += resepJson(terapi)[0];
              temp += '<br /><button type="button" onclick="delTerapi(this);return false;" class="btn btn-danger btn-block" value="' + i + '">Delete</button>';
              temp += '</div>';
              temp += '</div>';
              temp += '</div>';
            }

            $('#terapisContainer').html(temp).hide().fadeIn(500);
      }
    }

    function delTerapi(control){
      var key = $(control).val();
      terapis.splice(key, 1);
      var terapiString = JSON.stringify(terapis);
      $('#terapis').val(terapiString);
      viewTerapis();


    }