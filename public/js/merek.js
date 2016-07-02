 $('#dummySubmitMerek').click(function(e) {
  $('.btn').attr('disabled', 'disabled');
  if($('input#merekOnMerek').val() == ''){
      $('.btn').removeAttr('disabled');
      validasi('input[name="merek"]', 'Harus Disi');
  } else {

    $.post(base + '/mereks/ajax/ajaxmerek', {'merek' : $('input#merekOnMerek').val(), 'endfix' : $('input#endFixOnMerek').val()}, function(data) {
        data = $.trim(data);
        if(data == '1'){
            $('.btn').removeAttr('disabled');
            validasi('input#merekOnMerek', 'Merek Sudah ada');
        } else {
          $('input#submitOnMerek')
          .removeAttr('disabled')
          .click();
        }
    });
  }
});
