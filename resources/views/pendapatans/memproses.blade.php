<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-success" role="alert">
			<h1>Memproses Pembayaran</h1>
			<h3>{{ $rekening->deskripsi }} sebesar <span class="uang">{{ $rekening->nilai  }}</span> </h3> <br>
			<h3>Ditransfer tanggal {{ $rekening->tanggal->format('d M Y') }}</h3>
		</div>
	</div>
</div>
