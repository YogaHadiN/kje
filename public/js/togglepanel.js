    $('.hide-panel').closest('.panel').find('.panel-heading').css('border', '3px border red');
    $('.hide-panel').closest('.panel').find('.panel-heading').css('cursor', 'pointer');
    $('.hide-panel').closest('.panel').find('.panel-heading').click(function(e) {
    $(this).closest('.panel').find('.hide-panel').slideToggle();
        $('.unhide-panel:not([src="' + base + '/notfound.jpg"])').toggle();
    });;