	tambahGambar();
	$('#image_delete').val('[]');
	var sisaJson = gambars;
	sisaJson = sisaJson.replace(/\\/g, '\\\\');
	$('#image_sisa').val(sisaJson);
	function dummySubmit(){
		 $('#submit').click();
	}

	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
			what = a[--L];
			while ((ax = this.indexOf(what)) !== -1) {
				this.splice(ax, 1);
			}
		}
		return this;
	};
	function delImage(control){
		var id = $(control).val();
		$(control).closest('.satu_gambar').slideUp(300);
		var sisa = $('#image_sisa').val();
		sisa = JSON.parse(sisa);
		console.log('sisa awal');
		console.log(sisa);
		var index = '0';
		for (var i = 0; i < sisa.length; i++) {
			if(sisa[i].id == id){
				index = i;
				break;
			}
		}
		console.log('index');
		console.log(index);
		sisa.splice(index, 1);
		console.log('sisa akhir');
		console.log(sisa);
		var sisaJson = JSON.stringify(sisa);
		$('#image_sisa').val(sisaJson);
	}
	
	
	
		
	

