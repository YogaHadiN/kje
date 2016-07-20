$(function () {
	$('#dummySubmitSupplier').click(function(){
		if( $('#nama_supplier').val() == '' ){
			alert('nama supplier harus diisi');
			validasi('#nama_supplier', 'Harus Disi');
			$('#nama_supplier').focus();
		} else {
			$('#supplier_submit input[type="submit"]').click();
		}
	});
});
	 
