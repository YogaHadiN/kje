<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Tunggu Verifikasi</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/style.css')!!}
	<style type="text/css" media="all">
.middle {
	margin:auto;
}
	</style>

</head>
<body class="gray-bg">
	
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 middle loginscreen  animated fadeInDown">
			<div>
				<div class="text-center alert alert-success">
					<h2>Pendaftaran Telah Berhasil</h2>
					<h2>Mohon tunggu pengecekan oleh petugas kami</h2>

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title">Data Yang Sudah Masuk</div>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover table-condensed">
										<tbody class="text-left">
											<tr>
												<th class="text-left">Nama Pasien</th>
												<td>{{ $fb->nama_pasien }}</td>
											</tr>
											<tr>
												<th class="text-left">Pembayaran</th>
												<td>{{ $fb->pembayaran }}</td>
											</tr>
											<tr>
												<th class="text-left">Tujuan Poli</th>
												<td>{{ $fb->pilihan_poli }}</td>
											</tr>
										</tbody>
									</table>
								</div>
								
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										{!! Form::open(array('url' => 'facebook/' . $fb->id, 'method' => 'DELETE'))!!} 
											{!! Form::submit('Batalkan Antrian', array('class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Anda yakin mau batal berobat?")')) !!}
										{!! Form::close() !!}
										
									</div>
									
								</div>
								
							</div>
						</div>
					<hr />
					<h3>Terima Kasih Atas Kerjasamanya</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 middle loginscreen  animated fadeInDown">
			
		</div>
		
	</div>
	
	
    <!-- Mainly scripts -->
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
    {!! HTML::script('js/all.js')!!}
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
</body>

</html>
