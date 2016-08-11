<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>Klinik Jati Elok | Survey </title>
		<link href="{!! asset('css/all.css') !!}" rel="stylesheet" media="screen">
		<style type="text/css" media="all">
body, html {
	background : white;
	margin: 0px;
}

img, a{
	border : none;
}


.header, .footer {
	background : green;
	color: white;
}
.header {
	margin-top :-20px;
	padding : 15px;
}
.container {
	height:100%;
	padding-top: 75px;
}

.nama_klinik {
	 font-size : 120px;
}
.smiley, .terima_kasih {
	 display:none;
}
.no_telp {
	 font-size : 50px;
}
		</style>
	</head>
	<body>
		<div class="header">
			<div class="text-center">
				<h1 class="preface no_telp">021 5977529</h1>
				<h1 class="smiley">Berikan Penilaian Pelayanan Kami Hari Ini</h1>
			</div>
		</div>
		<div class="wrapper">
			<div class="container">
				<div class="text-center article">
					<div class="row text-center">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h1 class="preface nama_klinik">Klinik Jati Elok</h1>
							<h1 class="preface nama_klinik">Dokter 24 Jam</h1>
						</div>
					</div>
					<div class="row smiley">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<div>
									<a href="#" onclick="puas();return false">
										<img src="{{ url('img/marah.jpeg') }}" class="img-thumbnail kecewa" height="300px" width="300px" >
									</a>
								</div>
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<div>
									<a href="#"  onclick="biasa();return false">
										<img src="{{ url('img/regular.png') }}" class="img-thumbnail biasa" height="300px" width="300px">
									</a>
								</div>
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
									<div>
									<a href="#"  onclick="tidak();return false">
										<img src="{{ url('img/smile.jpg') }}"  class="img-thumbnail puas" height="300px" width="300px">
									</a>
								</div>
							</div>
					</div>
					<div class="row smiley">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<h1>Kecewa</h1>
						</div>
						
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<h1>Biasa</h1>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<h1>Puas</h1>
						</div>
					</div>
					<div class="terima_kasih">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<img src="{{ url('img/terima_kasih.png') }}"  class="img-thumbnail puas" height="400px" width="400px">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					</div>
				</div>
				<div class="footer text-center">
					<h1 class="preface">Komplek Bumi Jati Elok Blok A I No. 7</h1>
					<h1 class="smiley"> Bagaimana Pelayanan Kami Hari Ini?  </h1>
				</div>
			</div>
		</div>
		
<script src="{!! asset('js/all.js') !!}"></script>
<script type="text/javascript" charset="utf-8">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(function () {
		var callSurvey = setInterval(function(){
			$.post('{{ url("monitor/survey") }}',
				{},
				function (data) {
					if(data == '1'){
						 smiley();
					} else {
						preface();
					}
				}
			);
		}, 1000);

	});
	function puas(){
		$.post('{!! url("monitors/puas") !!}', {}, function(data) {
			response(data);
		});
	}
	function biasa(){
		$.post('{!! url("monitors/biasa") !!}', {}, function(data) {
			response(data);
		});
	}
	function tidak(){
		$.post('{!! url("monitors/kecewa") !!}', {}, function(data) {
			response(data);
		});
	}
	function smiley(){
		$('.preface').hide();
		$('.smiley').show();
		var i = 20; 
		clearInterval(callSurvey);
		setInterval(function(){
			
			if(i > 0){
				i--;
			} else {
				callSurvey();
				setMonitorsIdPeriksa_0();
			}

		}, 1000);
	}

	function preface(){
		 $('.preface').show();
		 $('.smiley').hide();
	}
	function berhasil(){
		console.log('berhasil');
		terimaKasih();
		setTimeout(function () {
			preface();
		}, 2000)
	}
	function gagal(){
		console.log('gagal');
		alert('gagal');
		preface();
	}
	function response(data){
		data = $.trim(data);
		if( data == '0' ){
			gagal();
		} else {
			berhasil();
		}
	}
	function terima_kasih(){
		 $('.terima_kasih').show();
		 $('.smiley').hide();
		 $('.preface').hide();
	}
function callSurvey(){
	setInterval(function(){
		$.post('{{ url("monitor/survey") }}',
			{},
			function (data) {
				if(data == '1'){
					 smiley();
				} else {
					preface();
				}
			}
		);
	}, 1000);
}
function setMonitorsIdPeriksa_0(){
	$.post('{!! url("monitors/buatIdPeriksaNol") !!}', {}, function(data) {
		response(data);
	});
}
</script>
	</body>
</html>
