  function pilihPoli(control){
	  if ( $(control).val() == 'estetika' ) {
		   $('#ddlPembayaran')
			   .attr('readonly', 'readonly')
			   .val('0');
		   return false;
	  } else {
		   $('#ddlPembayaran')
			   .removeAttr('readonly')
			   .val('');
	  }
	   if( $(control).val() == 'usg' ||  $(control).val() == 'usgabdomen'  ){
	   	$('#peringatan_trimester_pertama_usg').removeClass('hide');
	   	$('#peringatan_usg_abdomen').removeClass('hide');
		if( $(control).val() == 'usg' ){
			$('#peringatan_trimester_pertama_usg')
				.hide()
				.fadeIn(500);
			$('#peringatan_usg_abdomen').hide();
		}
		if( $(control).val() == 'usgabdomen' ){
			$('#peringatan_trimester_pertama_usg').hide();
			$('#peringatan_usg_abdomen')
				.hide()
				.fadeIn(500);
		}
	   } else {
			$('#dummyButton').removeAttr('onclick');
		   if( $('#peringatan_trimester_pertama_usg').is(':visible')  ){
			   $('#peringatan_trimester_pertama_usg').fadeOut(500, function(){
				   if( !$('#peringatan_trimester_pertama_usg').hasClass('hide')  ){
						$('#peringatan_trimester_pertama_usg').addClass('hide');
				   }
			   });
		   } else {
			   if( !$('#peringatan_trimester_pertama_usg').hasClass('hide')  ){
				   $('#peringatan_trimester_pertama_usg').fadeOut(500, function(){
					   if( !$('#peringatan_trimester_pertama_usg').hasClass('hide')  ){
							$('#peringatan_trimester_pertama_usg').addClass('hide');
					   }
				   });
			   }
		   }
		   if( !$('#peringatan_usg_abdomen').is(':visible')  ){
			   $('#peringatan_usg_abdomen').fadeOut(500, function(){
				   if( !$('#peringatan_usg_abdomen').hasClass('hide')  ){
						$('#peringatan_usg_abdomen').addClass('hide');
				   }
			   });
		   } else {

			   if( !$('#peringatan_usg_abdomen').hasClass('hide')  ){
				   $('#peringatan_usg_abdomen').fadeOut(500, function(){
					   if( !$('#peringatan_usg_abdomen').hasClass('hide')  ){
							$('#peringatan_usg_abdomen').addClass('hide');
					   }
				   });
			   
			   }
		   }
	   }
  }
