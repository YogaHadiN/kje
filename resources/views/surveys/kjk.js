
            $('#txt"+ data[i].jenis_tarif.replace(/ /g, '') + i + "').keyup(function(event) {
                  var bhp = $(this).val();
                  
                  if(bhp == ''){
                        bhp = 0;
                  }
                  
                  $('#txtTotal').html(parseInt(totalAwal)+parseInt(bhp));
                  data[i].biaya = String(bhp);
                  updateTotal(data);
            });
