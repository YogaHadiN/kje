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

</head>

<body class="gray-bg">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if (Session::has('pesan'))
				{!! Session::get('pesan')!!}
			@endif
		</div>
	</div>
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">KJE+</h1>
            </div>
            <h3>Selamat Datang di Klinik Jati Elok</h3>
            <p>Silahkan tekan tombol sesuai tujuan Anda</p>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="btn btn-lg btn-block btn-success" href="{{ url('fasilitas/antrian_pasien/umum') }}">Dokter Umum</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="btn btn-lg btn-block btn-primary" href="{{ url('fasilitas/antrian_pasien/gigi') }}">Dokter Gigi</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="btn btn-lg btn-block btn-info" href="{{ url('fasilitas/antrian_pasien/kb 1 bulan') }}">Suntik KB 1 Bulan</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="btn btn-lg btn-block btn-info" href="{{ url('fasilitas/antrian_pasien/kb 3 bulan') }}">Suntik KB 3 Bulan</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="btn btn-lg btn-block btn-warning" href="{{ url('antrian_pasien/estetika') }}">Kecantikan</a>
				</div>
			</div>


            <p>Khusus Untuk Pasien Lama Yang Sudah Mendaftarkan No HP untuk membuat akun baru</p> 
        </div>
    </div>

    <!-- Mainly scripts -->

    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}

</body>

</html>
