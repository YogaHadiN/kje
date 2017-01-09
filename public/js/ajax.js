var options = {
	ajax          : {
		url     : base + '/mereks/ajax/obat',
		type    : 'POST',
		dataType: 'json',
		data    : {
			q: "{{{q}}}" 
		}
	},
	locale        : {
		emptyTitle: 'Select and Begin Typing'
	},
	log           : 3,
	requestDelay  : 100,
	preprocessData: function (data) {
		var i, l = data.length, array = [];
		if (l) {
			for (i = 0; i < l; i++) {
				var temp = '<ul>';
				for (var o = 0;o < data[i].komposisi.length; o++) {
					temp += '<li>' + data[i].komposisi[o] +  '</li>';
				}
				temp += '</ul>';
				array.push($.extend(true, data[i], {
					text : data[i].merek,
					value: data[i].merek_id,
					data : {
						subtext: '<br />' + temp
					}
				}));
			}
		}
		// You must always return a valid array when processing data. The
		// data argument passed is a clone and cannot be modified directly.
		return array;
	}
};
$('.selectpickerAjax').selectpicker().filter('.with-ajax').ajaxSelectPicker(options);
$('select').trigger('change');

