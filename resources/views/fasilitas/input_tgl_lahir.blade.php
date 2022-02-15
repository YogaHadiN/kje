<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/animate.css')!!}
    {!! HTML::style('css/style.css')!!}
  {{--   <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> --}}
	<style type="text/css" media="all">
		h2{
			font-size:50 !important;
			font-weight:bold !important;
		}
		.logo-name{
			font-size:100px !important;

		}
		.form-control{
			height:100px;
			font-size:35pt !important;
		}
		.aturLebar {
			width:50% !important;
			margin:auto !important;
		}
		.height{
			height:70px;
		}

		.error{
			  border: 3px solid #A94442 !important;
		}

		.ok{
			  border: 3px solid #3C7B50 !important;
		}
		.loaded {
		  -webkit-transition: all 0.5s ease-in-out;
		  -moz-transition: all 0.5s ease-in-out;
		  -o-transition: all 0.5s ease-in-out;
		  transition: all 0.5s ease-in-out;
		}
	</style>

</head>

<body class="gray-bg">
	{!! Form::open(['url' => 'fasilitas/antrian_pasien/' . $poli . '/tanggal', 'method' => 'post']) !!}
		
	

    <div class="text-center loginscreen aturLebar animated fadeInDown">
        <div>
            <h3>Silahkan Masukkan Tanggal Lahir Anda</h3>
            <h3>Contoh : 19 Juli 1983, ketik 19-07-1983</h3>
			<div class="row">
				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
					<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
						{!! Form::text('tanggal_lahir' , null, ['class' => 'form-control loaded', 'id'=>'telpnih']) !!}
					  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<button class="btn btn-danger height btn-lg btn-block" type="button" onclick="del();return false">Hapus</button>
				</div>
			</div>


			<br />

			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>1</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>2</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>3</h2></button>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>4</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>5</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>6</h2></button>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>7</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>8</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>9</h2></button>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="klik(this);return false;"><h2>0</h2></button>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-lg btn-block btn-info" type="button" onclick="dummySubmit();return false;"><h2>Lanjutkan</h2></button>
					<button class="btn btn-lg btn-block btn-info hide" type="submit" id="lanjutkan"><h2>Lanjutkan</h2></button>
				</div>
			</div>


            <p>Khusus Untuk Pasien Lama Yang Sudah Mendaftarkan No HP untuk membuat akun baru</p> 
			@include('fasilitas.kembali')
        </div>
    </div>

	{!! Form::close() !!}
    <!-- Mainly scripts -->

    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}

	<script type="text/javascript" charset="utf-8">
		var input = $('#telpnih').val();
		console.log('input');
		console.log(input);
		function klik(control){
		    var input = $('#telpnih').val();
			if(input.length < 10){
				 var angka = $(control).find('h2').html();
				 var hasil = input + angka;
				 if(hasil.length == 2 ||hasil.length ==  5){
					hasil = hasil + '-';
				 }
				 rubahWarna(hasil);
			}	
		}
		function del(){
			var input = $('#telpnih').val();
			input = input.slice(0, -1);
			rubahWarna(input);
		}
		
		function testDate(str) {
		  return str.match(/(^(((0[1-9]|1[0-9]|2[0-8])[-](0[1-9]|1[012]))|((29|30|31)[-](0[13578]|1[02]))|((29|30)[-](0[4,6,9]|11)))[-](19|[2-9][0-9])\d\d$)|(^29[-]02[-](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/);
		}
		function rubahWarna(hasil){
			 $('#telpnih').val(hasil);
			if( testDate(hasil) && $('#telpnih').closest('.form-group').hasClass('has-error') ){
				$('#telpnih').closest('.form-group').removeClass('has-error');
				$('#telpnih').closest('.form-group').addClass('has-success');
				$('#telpnih').closest('.form-group').find('code').remove();
			} else if (!$('#telpnih').closest('.form-group').hasClass('has-error')){
				$('#telpnih').closest('.form-group').removeClass('has-success');
				$('#telpnih').closest('.form-group').addClass('has-error');
			} else if( !testDate(hasil) && !$('#telpnih').closest('.form-group').hasClass('has-error') ){
				$('#telpnih').closest('.form-group').removeClass('has-success');
				$('#telpnih').closest('.form-group').addClass('has-error');
			}
		}
		function dummySubmit(){
			if( $('#telpnih').closest('.form-group').hasClass('has-error') || $('#telpnih').val() == '' ){ 
				$('#telpnih').closest('.form-group').append('<code>Format tanggal salah</code>');
			} else {
				 $('#lanjutkan').click();
			}
		}
	</script>
</body>

</html>
