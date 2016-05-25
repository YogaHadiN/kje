(function(){

		var video = document.getElementById('ktp_video');
		canvas = document.getElementById('ktp_canvas');
		context = canvas.getContext('2d');
		photo = document.getElementById('ktp_photo');
		vendorUrl = window.URL || window.webkitURL;


		navigator.getMedia = 	navigator.getUserMedia ||
								navigator.webkitGetUserMedia ||
								navigator.mozGetUserMedia ||
								navigator.msGetUserMedia;

		navigator.getMedia({
			video:true,
			audio:false
		}, function(stream){
			video.src = vendorUrl.createObjectURL(stream);
			video.play();
		}, function(error){
			// an error occured
			// error.code
			
		});



})();

function capture(){
	context.drawImage(video, 0, 0, 400, 300);
	photo.setAttribute('src', canvas.toDataURL('image/png', 0.5));
	document.getElementById("ktp_image").value = canvas.toDataURL('image/png');
	$('.hide-panel').closest('.panel').find('.panel-heading').click();
}


