setTimeout(function(){
    $('#supplier_id').closest('div').find('.btn-white').focus();
}, 300);
$('input[type="submit"]').click(function(){
   var nama = $('#nama').val();
   var alamat = $('#alamat').val();
   var telp = $('#telp').val();
   var hp_pic = $('#hp_pic').val();
   var pic = $('#pic').val();
   $.post( base + "/suppliers/ajax/create",
           {
                'nama' : nama,
                'alamat' : alamat,
                'telp' : telp,
                'pic' : pic,
                'hp_pic' : hp_pic
           },
       function (data, textStatus, jqXHR) {
           $('.btn').attr('disabled', 'disabled');
           data = $.parseJSON(data);
           console.log(data);
           var MyArray = data.options;
           if(data.selected != ''){
               var options = '';
               for (var i = 0; i < MyArray.length; i++) {
                   options += '<option value="' + MyArray[i].value + '">';
                   options += MyArray[i].text;
                   options += '</option>';
               }
               $('#supplier_id').html(options).val(data.selected).selectpicker('refresh');
               $('#create_supplier').modal('hide');
           }
       }
   );
});

$('#create_supplier').on('shown.bs.modal', function(){
  $('#nama').focus();
});

$('#create_supplier').on('hidden.bs.modal', function(){
    setTimeout(function(){
        $('#supplier_id').closest('div').find('.btn-white').focus();
    }, 300);
});

