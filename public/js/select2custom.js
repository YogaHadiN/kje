function select2Engage(selectClass, ajaxPath){
	ajaxPath = '/' + ajaxPath;
	$( selectClass).select2({        
		ajax: {
			url: base + ajaxPath,
			dataType: 'json',
			delay: 250,
			data: function (params) {
			  return {
				q: params.term, // search term
				page: params.page
			  };
			},
			processResults: function (data, params) {
			  // parse the results into the format expected by Select2
			  // since we are using custom formatting functions we do not need to
			  // alter the remote JSON data, except to indicate that infinite
			  // scrolling can be used
			  params.page = params.page || 1;

			  return {
				results: data.items,
				pagination: {
				  more: (params.page * 30) < data.total_count
				}
			  };
			},
			cache: true
		},
		width:'100%',
		selectOnClose:true,
		minimumInputLength: 2,
		escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		templateResult: formatRepo, // omitted for brevity, see the source of this page
		//templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});
}

function formatRepo (repo) {

	  var markup = "<dnamaiv class='select2-result-repository clearfix'>" +
		"<div class='select2-result-repository__avatar'><img src='" + base + repo.bpjs + "' /></div>" +
		"<div class='select2-result-repository__meta'>" +
		"<div class='select2-result-repository__title'>" + repo.text + "</div>";
	  markup += "<div class='select2-result-repository__description'><strong>Tanggal Lahir</strong> : " + repo.tanggal_lahir + "</div>";
	  markup += "<div class='select2-result-repository__description'><strong>Alamat</strong> : " + repo.alamat + "</div>";

	  return markup;
}
