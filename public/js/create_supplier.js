$(function () {
	$('#dummySubmitSupplier').click(function(){
		if( $('#nama_supplier').val() == '' ){
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text:'nama supplier harus diisi'
			});
			validasi('#nama_supplier', 'Harus Disi');
			$('#nama_supplier').focus();
		} else {
			$('#supplier_submit input[type="submit"]').click();
		}
	});
});
	 
