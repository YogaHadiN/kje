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
					<input type="text" name="tanggal_lahir" id="telpnih" class="form-control" value=""/>
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
					<button class="btn btn-lg btn-block btn-info" type="submit"><h2>Lanjutkan</h2></button>
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
			 var angka = $(control).find('h2').html();
		    	var input = $('#telpnih').val();
			 var hasil = input + angka;
			 if(hasil.length == 2 ||hasil.length ==  5){
			 	hasil = hasil + '-';
			 }
			 $('#telpnih').val(hasil);

		}
		function del(){
			var input = $('#telpnih').val();
			input = input.slice(0, -1);
			 $('#telpnih').val(input);
		}
		
		
		
			
	</script>
</body>

</html>
