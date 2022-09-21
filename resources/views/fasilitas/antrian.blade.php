<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    {{-- {!! HTML::style('css/animate.css')!!} --}}
    {!! HTML::style('css/style.css')!!}
	<style type="text/css" media="all">
		.text-center {
			text-align: center;
		}
		.fit-width{
			width: 100%;
		}

		h2{
			font-size : 20px;
		}
		h3{
			font-size : 40px;
		}
		.margin-top {
			margin-top: 10px;
		}
		.bold {
			font-weight: bold;
		}
		table {
			font-size: 13px;
			text-align: left !important;
		}
		.box-border{
			border: 1px solid black;
		}
		.underline{
			text-decoration: underline;
		}
		.paddingTop{
			margin-top: 20px;
		}
		.welcome_title {
			font-size: 30px;
		}
		.alamat_klinik {
			font-size: 20px;
		}

		@media screen {
			#section-to-print {
				visibility: hidden;
			}
		} 
		@media print {
		  body * {
			visibility: hidden;
		  }
		.receipt { 
			width: 80mm 
		} 
		@media print { body.receipt { width: 80mm } } /* this line is needed for fixing Chrome's bug */
			html body.receipt .sheet { 
				width: 80mm; 
			} 
			html, body {
			  height:100vh; 
			  margin: 0 !important; 
			  padding: 0 !important;
			  overflow: hidden;
			}
		  #section-to-print, #section-to-print * {
			visibility: visible;
		  }
		  #section-to-print {
			position: absolute;
			left: 0;
			top: 0;
		  }
		}
		.imgKonfirmasi {
			width : 300px;
			height : 300px;
		}
		.superbig{
			font-size:50px;
		}

		.superbig-button{
			padding : 50px;
			font-size : 50px;
			border-radius : 20px;
		}
		.content-secondary{
			padding : 0px 150px;
		}
		h1{
			font-size: 100px !important;
			margin-bottom : 50px;
		}
		h2{
			font-size: 75px !important;
			margin-bottom : 30px;
		}

        .small{
			font-size: 25px !important;
        }
	</style>

</head>

<body class="receipt gray-bg A5" onclick="returnFocus();return false;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if (Session::has('pesan'))
				{!! Session::get('pesan')!!}
			@endif
		</div>
	</div>
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="content-secondary">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<h1>Klinik Jati Elok</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<h2>Pilih Antrian</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="submitAntrian(1)" class="btn btn-lg btn-block btn-success superbig-button">Dokter Umum</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="submitAntrian(3)" class="btn btn-lg btn-block btn-info superbig-button">Bidan</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="submitAntrian(7)" class="btn btn-lg btn-block btn-primary superbig-button">Rapid Test</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="submitAntrian(8)" class="btn btn-lg btn-block btn-success superbig-button">Medical Checkup</button>
				</div>
			</div>
			<br>
			<hr>
			<div class="row text-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-info">
						<h3>
							Peserta BPJS <small>yang berobat ke </small>Dokter Umum <small>silahkan Scan Kartu / Barcode Aplikasi untuk mendapatkan Nomor Antrian</small>
						</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
			{{-- <div class="row"> --}}
			{{-- 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> --}}
			{{-- 		<button type="button" onclick="submitAntrian(2)" class="btn btn-lg btn-block btn-primary superbig-button">Dokter Gigi</button> --}}
				
			{{-- 	</div> --}}
			{{-- 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> --}}
			{{-- 		<button type="button" onclick="submitAntrian(4)" class="btn btn-lg btn-block btn-warning superbig-button">Estetika</button> --}}
			{{-- 	</div> --}}
			{{-- </div> --}}
		</div>
		{!! Form::text('nomor_bpjs', null, ['class' => 'form-control', 'id' => 'nomor_bpjs']) !!}
	</div>
	<div id="section-to-print">
	  <section class="sheet">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center">
                    <div class="text-center border-top welcome_title">
						Selamat Datang di
						<br />Klinik Jati Elok
					</div>
                    <div class="text-center border-bottom border-top alamat_klinik">
					</div>
                </div>
				<div class="text-center alamat_klinik">Nomor Antrian </div>
                <div class="text-center superbig strong" id="nomor_antrian">
							A50
                </div>
				<div class="text-center welcome_title" id="jenis_antrian">Poli Umum</div>
                <div class="alamat_klinik text-center bold">Kode Unik : <span  id="kode_unik"></span></div>
                <div class="text-center">
                    <img src="" id="qr_code" alt="">
                </div>
				<div class="text-center alamat_klinik">Scan QR Code di atas, anda akan dialihkan menuju whatsapp</div>
				<br />
	  </section>
	</div>
    <!-- Mainly scripts -->
	<script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	</script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/antrian.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
</body>

</html>
