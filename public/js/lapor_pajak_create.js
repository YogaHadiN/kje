function jenisPajakChange(control) {
	var jenis_pajak_id = $(control).val();
	var periodePajakHtml = $(this)[0].outerHTML;
	// $('#periodePajak').datepicker('destroy');
	$.get(base + '/lapor_pajaks/get_periode_pajak',
		{ 
			jenis_pajak_id: jenis_pajak_id 
		},
		function (data, textStatus, jqXHR) {
			var periode_id = $.trim(data);
			$('#periodePajak').remove();
			$('.label-periode-pajak').after(periodePajakHtml);
			if (periode_id == '1') { // bulanan
				//tampilkan bulanan
				$('#periodePajak').datepicker({
					todayBtn: "linked",
					keyboardNavigation: false,
					forceParse: false,
					calendarWeeks: true,
					autoclose: true,
					format: 'mm-yyyy',
					viewMode: "months", 
					minViewMode: "months"
				});

				$('#periodePajak').datepicker('refresh');

			} else {
				$('#periodePajak').datepicker({
					todayBtn: "linked",
					keyboardNavigation: false,
					forceParse: false,
					calendarWeeks: true,
					autoclose: true,
					format: 'yyyy',
					viewMode: "years", 
					minViewMode: "years"
				});
			}
			$('#periode_id').closest('form').attr('autocomplete', 'off');
		}
	);
}
function dummySubmit(control){
	if(validatePass2(control)){
		$('#submit').click();
	}
}

