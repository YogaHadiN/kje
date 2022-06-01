@if( $status == 'danger' || $status == 'warning' )
	<div class="alert alert-warning" role="alert">
		<h1>PERHATIAN!!</h1>
		<div class="alert alert-info" role="alert">
			<h4>Jika tidak dipenuhi maka halaman ini tidak bisa disubmit</h4>
		</div>
		<div class="alert alert-success" role="alert">
			Label Hijau artinya dalam batas aman
		</div>
		<div class="alert alert-warning" role="alert">
			Label Kuning artinya peringatan mendekati batas minimal
		</div>
		<div class="alert alert-danger" role="alert">
			Label Merah artinya kurang dari batas minimal
		</div>
	</div>
@endif
	<div class="panel panel-{{ $admedikaWarning }}">
		<div class="panel-heading">
			<h3 class="panel-title">Tagihan Admedika</h3>
		</div>
		<div class="panel-body">
			<h3>Piutang Admedika Belum Dikirim</h3>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<tbody>
						@if ( !is_null($pasien_pertama_belum_dikirim) )
							<tr>
								<td>
									<a href="{{ url('pasiens/' . $pasien_pertama_belum_dikirim->pasien_id . '/edit' ) }}" target="_blank">
										{{ $pasien_pertama_belum_dikirim->nama_pasien }}
									</a>
								</td>
								<td>
									<a href="{{ url('periksas/' . $pasien_pertama_belum_dikirim->periksa_id ) }}" target="_blank">
										{{ $pasien_pertama_belum_dikirim->tanggal }}
									</a>
								</td>
								<td>{{ $pasien_pertama_belum_dikirim->nama_asuransi }}</td>
							</tr>
						@else
							<tr>
								<td colspan="3" class="text-center">Belum ada pasien terhutang</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<h1>{{ $jarak_hari }} hari</h1>
			<p>Maksmial 24 hari sudah harus dikirim</p>
		</div>
	</div>

	<div class="panel panel-{{ $mootaWarning }}">
		<div class="panel-heading">
			<h3 class="panel-title">Moota</h3>
		</div>
		<div class="panel-body">
			<h3>Saldo Moota</h3>
			<h1>{{ App\Models\Classes\Yoga::buatrp( $moota_balance ) }}</h1>
			<p>Saldo Moota harus diatas Rp. 10.000,- </p>
		</div>
	</div>

	<div class="panel panel-{{ $denominatorBpjsWarning }}">
		<div class="panel-heading">
			<h3 class="panel-title">Denominator BPJS</h3>
		</div>
		<div class="panel-body">
			<p>Denominator BPJS harus diisi setelah tanggal 6 dan paling lambat tanggal 14 setiap bulannya</p>
			<p> <a href="{{ url('denominator_bpjs') }}">Klik Disini</a> untuk melihat </p>
		</div>
	</div>

	<div class="panel panel-{{ $uploadDataPesertaBpjsWarning }}">
		<div class="panel-heading">
			<h3 class="panel-title">Upload Data Peserta BPJS</h3>
		</div>
		<div class="panel-body">
			<p>Data Peserta Bpjs Harus di Upload Antara tanggal 6 - 14 setiap bulannya</p>
			<p> <a href="{{ url('prolanis') }}">Klik Disini</a> untuk melihat </p>
		</div>
	</div>

	@if ($pasienProlanisBulanIniSudahDiupload)
		<div class="panel panel-{{ $validasiProlanisBpjsWarning }}">
			<div class="panel-heading">
				<h3 class="panel-title">Validasi Prolanis Bpjs</h3>
			</div>
			<div class="panel-body">
				<h3>Validasi Prolanis BPJS</h3>
				<p>Denominator BPJS harus diisi setelah tanggal 6 dan paling lambat tanggal 14 setiap bulannya</p>
				<p> <a href="{{ url('denominator_bpjs') }}">Klik Disini</a> untuk melihat </p>
			</div>
		</div>
	@endif
	<div class="panel panel-{{ $validateReceivedVerification }}">
		<div class="panel-heading">
			<h3 class="panel-title">Verifikasi Invoice Sudah Diterima Admeika</h3>
		</div>
		<div class="panel-body">
			@if ( count($invoiceBelumDiterimaAdmedika) )
				<p>Invoice Yang Belum Verifikasi Diterima Sebanyak  </p>
				<h1><a href="{{ url('invoices/pendingReceivedVerification') }}" target="_blank">{{ count($invoiceBelumDiterimaAdmedika) }} Berkas</a> </h1>
			@else
				<h3>Semua Invoice sudah diverifikasi</h3>
			@endif
		</div>
	</div>
	{{-- <div class="panel panel-{{ $vultrWarning }}"> --}}
	{{-- 	<div class="panel-heading"> --}}
	{{-- 		<h3 class="panel-title">Vultr</h3> --}}
	{{-- 	</div> --}}
	{{-- 	<div class="panel-body"> --}}
	{{-- 		<h3>Credit Vultr</h3> --}}
	{{-- 		<h1>$ {{ abs( $vultr['balance'] + $vultr['pending_charges'] ) }} </h1> --}}
	{{-- 		<p>Credit Vultr harus diatas $15</p> --}}
	{{-- 	</div> --}}
	{{-- </div> --}}


	{{-- <div class="panel panel-{{ $wablasWarning }}"> --}}
	{{-- 	<div class="panel-heading"> --}}
	{{-- 		<h3 class="panel-title">Wablas</h3> --}}
	{{-- 	</div> --}}
	{{-- 	<div class="panel-body"> --}}
	{{-- 		<h3>Credit Wablas</h3> --}}
	{{-- 		<h1>Quota = {{ $quota }}</h1> --}}
	{{-- 		<p>kuota harus diatas 500</p> --}}
	{{-- 		<h1>Expired = {{ $expired }} ( {{ App\Models\Classes\Yoga::dateDiffNow( $expired ) }} hari )</h1> --}}
	{{-- 		<p>expired harus diatas 3 hari</p> --}}
	{{-- 	</div> --}}
	{{-- </div> --}}


		{{-- // ========================================================================================== --}}
		{{-- // HALT BPJS PERBULAN --}}
		{{-- // ========================================================================================== --}}
		{{-- // --}}
		{{-- // --}}
	{{-- <div class="panel panel-{{ $statusBpjsPerBulan }}"> --}}
	{{-- 	<div class="panel-heading"> --}}
	{{-- 		<h3 class="panel-title">Peserta BPJS Perbulan</h3> --}}
	{{-- 	</div> --}}
	{{-- 	<div class="panel-body"> --}}
	{{-- 		<h3>Peserta Bpjs Perbulan harus diupload paling lambat tanggal</h3> --}}
	{{-- 		<h1>10</h1> --}}
	{{-- 		<p>Upload <a href=" {{ url('peserta_bpjs_bulanans') }}" target="_blank">disini</a> </p> --}}
	{{-- 	</div> --}}
	{{-- </div> --}}

