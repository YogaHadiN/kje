    $('.hide-panel').closest('.panel').find('.panel-heading').css('border', '3px border red');
    $('.hide-panel').closest('.panel').find('.panel-heading').css('cursor', 'pointer');
    $('.hide-panel').closest('.panel').find('.panel-heading').click(function(e) {
        if ( $('#resepluar').val() ==  ''){
            $(this).closest('.panel').find('.hide-panel').slideToggle(function(){
                $(this).closest('.panel').find('.resepluar').focus(); 
            });
            $('.unhide-panel:not([src="' + base + '/notfound.jpg"])').toggle();
        }
    });;
