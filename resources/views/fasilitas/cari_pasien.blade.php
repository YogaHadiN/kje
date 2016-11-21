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
		
	

	<div class="text-center loginscreen aturLebar animated fadeInDown">
		<h3>Ada {{ $pasiens->count() }} Pasien yang memiliki Tanggal Lahir {{ App\Classes\Yoga::updateDatePrep($tanggal) }}</h3>	
		<h3>Pilih yang lebih cocok dengan diri Anda</h3>	

		<div>
			@foreach($pasiens as $pasien)	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!! Form::open(['url' => 'fasilitas/antrian_pasien/'. $poli . '/tanggal/' . $pasien->id, 'method' => 'post']) !!}
							<button class="btn btn-lg btn-block btn-info" type="submit">
								<h2>{{ $pasien->nama }}</h2>
								<h3>{{ $pasien->alamat }}</h3>
								<h3>{{ $pasien->no_telp }}</h3>
							</button>
						{!! Form::close() !!}
					</div>
				</div>
				<br /> <br />
			@endforeach
		</div>
		@include('fasilitas.kembali')
	</div>

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
