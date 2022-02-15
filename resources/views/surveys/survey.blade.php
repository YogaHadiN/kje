<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>{{ env("NAMA_KLINIK") }} | Survey </title>
		<link href="{!! asset('css/all.css') !!}" rel="stylesheet" media="screen">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
		<style type="text/css" media="all">
@import url('https://fonts.googleapis.com/css?family=Exo:400,700');

*{
    margin: 0px;
    padding: 0px;
}
body{
    font-family: 'Exo', sans-serif;
}

.img-logo {
  display: block;
  max-width:300px;
  max-height:130px;
  width: auto;
  height: auto;
  margin: auto;
}


.img-seru {
  display: block;
  max-width:80px;
  max-height:80px;
  width: auto;
  height: auto;
  margin: auto;
  border-radius: 125px;
  border: 1px solid black;
  
}

.context {
    width: 100%;
    position: absolute;
    top:50vh;
    
}

.context h1{
    text-align: center;
    color: #fff;
    font-size: 50px;
}


.area{
    background: #4e54c8;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
    height:100vh;
    
   

}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
    
}

.circles li:nth-child(1){
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}


.circles li:nth-child(2){
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3){
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4){
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5){
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6){
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7){
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8){
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9){
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10){
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}



@keyframes animate {

    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }

}
body, html {
	background : white;
	margin: 0px;
}

img, a{
	border : none;
}

.angry, .angry:hover, .angry:focus {
	color : red;
}

.kuning, .kuning:hover, .kuning:focus {
	color : #f5d742;
}

.grey {
	color : grey;
}

.green, .green:hover, .green:focus {
	color : green;
}
.smiley-icon {
	font-size: 30px;
}


.header, .footer {
    padding-top: 20px;
	color: black;
    border:none;
    text-align: center;
}
.header {
	margin-top :-20px;
	padding : 15px;
    padding-top: 70px;
}

.footer {
    padding-bottom: 70px;
}
.container {
	height:100%;
	padding-top: 35px;
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
.margin-up {
    margin-top: 20px;
}
.bold {
    font-weight: 400;
    font-size: 60px;
}

.bg {
  /* The image used */
  background-image: url("{{ url('images/grad.jpeg') }}");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
		</style>
	</head>
	<body>
        <div class="bg"></div>
        <div id="price">
            
        </div>
		<div class="header ">
			<div class="text-center">
                <h1 class="bold ">Mohon Berikan Penilaian Pelayanan Kami Hari Ini</h1>
                {{-- <h1 class="bold ">{{ \Auth::id() }}</h1> --}}
			</div>
		</div>
		<div class="wrapper">
			<div class="container">
                <div class="text-center">
                    <img class="img-seru animate__animated animate__bounce animate__infinite" src="{{ url('images/seru.png') }}" alt=""/>
                </div>
				<div class="text-center article">
					<div class="row margin-up">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<a href="#" class="angry smiley-icon" onclick="survey(0);return false">
								<i class="far fa-angry fa-8x"></i>
                                 <br> Kecewa
							</a>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<a href="#" class="kuning smiley-icon" onclick="survey(1);return false">
								<i class="far fa-meh fa-8x"></i>
                                 <br> Biasa
							</a>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<a href="#" class="green smiley-icon" onclick="survey(2);return false">
								<i class="far fa-smile fa-8x"></i>
                                 <br> Puas
							</a>
						</div>
					</div>
				</div>
				<div class="row hide">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        {!! Form::text('surveyable_id', null, ['class' => 'form-control', 'id' => 'surveyable_id']) !!}
                        {!! Form::text('surveyable_type', null, ['class' => 'form-control', 'id' => 'surveyable_type']) !!}
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					</div>
				</div>
				<div class="footer text-center">
                    <img class="img-logo" src="{{ url('img/logokje.png') }}" alt="" />
				</div>
			</div>
		</div>
    <script charset="utf-8">
        var base = "{{ url('/') }}";
		var base_s3 = "{{ env('AWS_URL') }}";
    </script>
    <script src="{!! asset('js/all.js') !!}"></script>
    <script src="{!! asset('js/app.js') !!}"></script>
    <script src="{!! asset('js/fasilitas_survey.js') !!}"></script>
    <script ></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{!! asset('js/survey_kepuasan_pelanggan.js') !!}"></script>
    <script src="https://kit.fontawesome.com/888ab79ab3.js" crossorigin="anonymous"></script>
</body>
</html>
