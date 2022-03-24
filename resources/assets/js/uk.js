function uk(umur_kehamilan, hari) {

	$("#" + hari).datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
	}).on("changeDate", function(e) {
		uk_exec(umur_kehamilan, hari);
	});

	$('#' + umur_kehamilan).attr('readonly', 'readonly');
}

function uk_exec(umur_kehamilan, hari) {
	if ($('#' + hari).val() != '') {
	    var HPHT =  $('#' + hari).val();

	    $.post(base +"/anc/uk" , {'hpht': HPHT }, function(data) {
	        data = $.trim(data);
	        $('#' + umur_kehamilan).val(data); 
	    });

	} else {
	    $('#' + umur_kehamilan).val(''); 
	}
}