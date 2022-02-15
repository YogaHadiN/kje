 $(document).ready(function() {

          fornasChange() ;
            $('#dummySubmitRak').click(function(e) {
              $('.btn').attr('disabled', 'disabled');
            if(
              $('input#expDateOnRak').val() == '' ||
              $('input#hargaBeliOnRak').val() == '' ||
              $('select#fornasOnRak').val() == '' ||
              $('input#hargaJualOnRak').val() == '' ||
              $('input#stokOnRak').val() == '' ||
              $('input#stokMinimalOnRak').val() == '' ||
              $('input#merekOnRak').val() == '' ||
              $('input#idOnRak').val() == ''){


                  if($('input#expDateOnRak').val() == ''){
                    validasi('input#expDateOnRak', 'Harus Diisi!');
                  }
                  if($('input#hargaBeliOnRak').val() == ''){
                    validasi('input#hargaBeliOnRak', 'Harus Diisi!');
                  }
                  if($('select#fornasOnRak').val() == ''){
                    validasi('select#fornasOnRak', 'Harus Diisi!');
                  }
                  if($('input#hargaJualOnRak').val() == ''){
                    validasi('input#hargaJualOnRak', 'Harus Diisi!');
                  }
                  if($('input#stokOnRak').val() == ''){
                    validasi('input#stokOnRak', 'Harus Diisi!');
                  }
                  if($('input#stokMinimalOnRak').val() == ''){
                    validasi('input#stokMinimalOnRak', 'Harus Diisi!');
                  }
                  if($('input#merekOnRak').val() == ''){
                    validasi('input#merekOnRak', 'Harus Diisi!');
                  }
                  if($('input#idOnRak').val() == ''){
                    validasi('input#idOnRak', 'Harus Diisi!');
                   }

            } else {

              $.post(base + "/raks/ajax/ajaxrak", {'formula_id': $('input#formulaIdOnRak').val(), 'merek' : $('input#merekOnRak').val(), 'rak' : $('input#idOnRak').val()}, function(data) {
                  data = JSON.parse(data);

                  console.log('rak = ' + data.rak);
                  console.log('merek = ' + data.merek);

                  if(data.merek == '1' || data.rak == '1'){


                    if(data.merek == '1'){
                      $('.btn').removeAttr('disabled');
                      alert('Merek Sudah ada');
                      validasi('input#merekOnRak', 'Merek Sudah ada');
                      $('#merekOnRak').focus();

                     }

                     if (data.rak == '1'){
                      $('.btn').removeAttr('disabled');
                      alert('Rak Sudah ada');
                      validasi('input#idOnRak', 'Rak Sudah ada');
                      $('#idOnRak').focus();
                    }

                  } else {
                    $('input#submitOnRak')
                    .removeAttr('disabled')
                    .click();
                  }
              });
            }
          });
            $('#fornasOnRak').change(function(e) {
                fornasChange();
            });

          $('input').keyup(function(e) {
            removeCode(this);
          });

          $('select').change(function(e) {
            removeCode(this);
          });

          $('.tanggal').change(function(e) {
            removeCode(this);
          });
  });

  function fornasChange(){
    if($('#fornasOnRak').val() == '1' || $('#fornasOnRak').val() == '' ){
        $('#alternatifFornasOnRak').val('0').attr('disabled', 'disabled').hide().fadeIn(500);
    } else {
        $('#alternatifFornasOnRak').removeAttr('disabled').hide().fadeIn(500);
    }

    $('#alternatifFornasOnRak').selectpicker('refresh');
  }

  function removeCode(code){
      $(code).closest('.form-group').find('code').fadeOut('1000', function() {
        $(this).remove();
      });
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