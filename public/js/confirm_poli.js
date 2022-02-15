$('#confirm_staf').on('show.bs.modal', function(){
    $('#confirm_staf input[type!="hidden"]').val('');
});

$('#confirm_staf').on('shown.bs.modal', function(){
    $('#email').focus();
});

function confirmStaf(){
    if(validatePass()){
       $('#submit_confirm_staf').click(); 
    }    
}
