<html>
<head>
	<meta charset="UTF-8">
	<title>Klinik Jati Elok | Kuitansi</title>
<style>
	@page 
	{
        margin: 2em;
        padding-right: 2em;
    }
	
	.b-top td{
		border-top: 1px solid #000000;
		font-weight: bold;
		font-size: 15px;
	}


	.status
	{
		text-align:center;
		font-size:15px;
		font-weight:bold;
		border: 2px solid black;
	}

	.content2 {
		padding:10px;
		border-collapse: collapse;
		border: 1px solid black;
		width: 50%;
	}

	table{
border-spacing: -1px;
	}
	table td{
		padding:2px;
		vertical-align: text-top;
	}

	.gantung1 {
		padding: 2px 2px 5px 4px;
	}

	.klinik {
		font-size:16px;font-weight:bold;
	}

	.content1 {
		margin:10px 0px;
	}
	
	.text-left{
		text-align: left;
	}	
	.text-right{
		text-align: right;
	}

	.bottom{
		margin-bottom: 10px
	}

	.bold{
		font-weight: bold;
		font-size: 15px;
	}

	.margin-top-bottom {
		padding-top:10px;
	}

	.image {
		height: 50px;
		width: 50px;
	}

	#header td:first-child {
		width:55px;
	}

	.uang {
		text-align: right;
	}
	


</style>
</head>
<body style="font-size:12px; font-family:sans-serif">
	<div style="" class="bottom">
		<table width="100%">
			<tr>
				<td class="text-left">
					<table id="header">
						<tr>
							<td>
								<img src="/home/vagrant/Code/jatielok/public/images/eka.jpg" alt="" class="image"/>
							</td>
							<td>
								<div>
									<div class="klinik">KLINIK JATI ELOK </div>
									Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, <br>
									Malangnengah, Pagedangan, Tangerang, Banten 021 98496234
								</div>
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
	<div class="margin-top-bottom">Terbilang : {!! $terbilang !!}</div>
	<div class="text-right bold">Tangerang, {!! App\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}</div>

</body>
</html>