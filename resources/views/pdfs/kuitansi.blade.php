<html>
<head>
	<meta charset="UTF-8">
	<title>{{ env("NAMA_KLINIK") }} | Kuitansi</title>
	<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />
</head>
<body style="font-size:12px; font-family:sans-serif">
	<div style="" class="bottom">
		<table width="100%">
			<tr>
				<td class="text-left">
					<table id="header">
						<tr>
							<td>

								<div class="klinik">{{ \Auth::user()->tenant->name }} </div>
								{{ env("ALAMAT_KLINIK_LINE1") }}, Jl. Raya Legok - Parung Panjang km. 3, <br>
								Malangnengah, Pagedangan, Tangerang, Banten 021 98496234

							</td>
						</tr>
					</table>
					<div>
					</div>
					
				</td>

			</tr>
		</table>
	</div>
	<table style="width:100%">
		<tr>
			<td colspan="2" class="status">KUITANSI - {!! $periksa->id !!}</td>
		</tr>
		<tr>
			<td>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td>Nama Pasien</td>
							<td>:</td>
							<td>{!! $periksa->pasien->nama !!}</td>
						</tr>
						<tr>
							<td>Pembayaran</td>
							<td>:</td>
							<td>{!! $periksa->asuransi->nama !!}</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td>Diperiksa Oleh</td>
							<td>:</td>
							<td>{!! $periksa->staf->nama !!}</td>
						</tr>
						<tr>
							<td>No Asuransi</td>
							<td>:</td>
							<td>{!! $periksa->pasien->nomor_asuransi !!}</td>
						</tr>
					</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td class="content2">
				<table width="100%">
					<tbody>
						{!! $periksa->tindakan_html !!}
					</tbody>
					<tfoot>
						<tr class="b-top">
							<td colspan="2">Total Biaya</td>
							<td class="text-right uang">{!! $periksa->total_transaksi !!}</td>
						</tr>
					</tfoot>
				</table>
			</td>

			<td class="content2">
					<strong>RESEP :</strong> <br>
					{!! $periksa->terapi_htmll !!}
			</td>
		</tr>
	</table>
	<div class="margin-top-bottom">Terbilang : {!! $periksa->terbilang !!}</div>
	<div class="text-right bold">Tangerang, {!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}</div>
</body>
</html>
