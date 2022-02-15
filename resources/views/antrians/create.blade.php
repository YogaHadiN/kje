<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>INSPINIA | Login</title>

    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/animate.css')!!}
    {!! HTML::style('css/style.css')!!}
	<style type="text/css" media="all">
		.imgKonfirmasi {
			width : 300px;
			height : 300px;
		}
		.middle{
			width:50% !important;
			margin:auto !important;
		}
		.text-big{
			font-size:110px !important;
		}

		@media print {
		  body * {
			visibility: hidden;
		  }
		  .printThis, .printThis * {
			visibility: visible;
		  }
		  .printThis {
			position: absolute;
			left: 0;
			top: 0;
		  }
		}
	</style>
</head>
<body class="gray-bg">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if (Session::has('pesan'))
				{!! Session::get('pesan')!!}
			@endif
		</div>
	</div>
    <div class="middle text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">KJE+</h1>
            </div>
            <h3>Selamat Datang di {{ env("NAMA_KLINIK") }}</h3>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-lg btn-block btn-info" type="button" onclick="antrianBaru();return false;">
						<h1>Dokter Umum</h1>
					</button>
				</div>
			</div>
<br />
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-lg btn-block btn-warning" type="button" onclick="antrianBaru();return false;">
						<h1>Dokter Gigi</h1>
					</button>
				</div>
			</div>

<br />
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-lg btn-block btn-success" type="button" onclick="antrianBaru();return false;">
						<h1>Dokter Kecantikan</h1>
					</button>
				</div>
			</div>
<br />
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-lg btn-block btn-primary" type="button" onclick="antrianBaru();return false;">
						<h1>Suntik KB</h1>
					</button>
				</div>
			</div>
        </div>
    </div>

	<div class="modal fade" tabindex="-1" role="dialog" id="modalAntrian">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-body text-center">

			<h1 class="strong">{{ env("NAMA_KLINIK") }}</h1>
			<h1>Antrian Nomor</h1>
			<h1 id="antrianMaster" class="text-big"></h1>

		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="printThis text-center">
		<h1 class="strong">{{ env("NAMA_KLINIK") }}</h1>
		<h2>Antrian Nomor</h2>
		<div id="nomorAntrian" class="text-big"></div>
		<h2>Poli Gigi</h2>
	</div>
    <!-- Mainly scripts -->
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
	<script type="text/javascript" charset="utf-8">
		
		function antrianBaru(){

			$('#modalAntrian').on('shown.bs.modal', function (){
				setTimeout(function(){
					$('#modalAntrian').modal('hide');
				}, 2000);
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.post('{{ url("antrians/print") }}', {}, function(data) {
				data = $.trim(data);
				$('#nomorAntrian').html(data);
				$('#antrianMaster').html(data);
				$('#modalAntrian').modal('show');
				{{--print_tanpa_dialog()--}}
				window.print();
			});
		}
	

	</script>
</body>

</html>
