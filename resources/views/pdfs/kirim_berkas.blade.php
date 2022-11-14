<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Status</title>
<style>
	@page 
	{
        margin: 2em;
        padding-right: 2em;
    }

.font-smaller {
  font-size: 12px;
}
.border-all {
	border:0.5px solid black;
	padding:5px;
}
	.tanda-tangan{
		text-align:center;
	}
	table.tanda-tangan tr td{
		padding-top:40px;
	}
	.status
	{
		text-align:center;
		font-size:18px;
		font-weight:bold;
		border-bottom: 2px solid black;
	}
	.content2 {
		padding:5px;
		border-collapse: collapse;
		border: 1px solid black;
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
		font-size:16px;font-weight:bold;margin-bottom: 5px;
	}

	.content1 {
		margin:5px 0px 0px;
	}
	
	.text-left{
		text-align: left;
	}	
	.text-right{
		text-align: right;
	}	
	.text-center{
		text-align: center;
	}

	.half
		width: 40%;
	}

	.text {
		margin : 5px 0px 10px 0px;
	}
	.text3 {
		font-size: 12px;
	}

	.text2 {
		margin : 5px 0px;
	}

	.identitas table{
	}

	.identitas table tr td:first-child{
		width:30%;
	}

	.identitas table tr td:nth-child(2){
		width:5%;
	}

	.rujukan0 {
		padding-right:20px;
		border-right: 1px solid #000000;
	}

	.rujukan1 {
		padding-left:20px;
	}
	.sakit0 {
		padding-right:20px;
		border-right: 1px solid #000000;
		color:#fff;
	}

	.sakit1 {
		padding-left:20px;
	}

	.tandaTangan {
		margin-left: 60%;
		text-align: center;
	}

	h3 {
		margin: 2px 0px;
	}

	.font-small {
		font-size: 10px;
		
	}

	.foot-note {
		border:1px solid black;
		text-align: center;
		margin-top: 10px;
	}

	.title{
		text-align: center;
		font-size: 15px;
		margin-bottom: 5px;
	}
	.title2{
		text-align: center;
		font-size: 16px;
		text-decoration: underline;
		margin: 15px 0px;
	}
	.underline {
		text-decoration: underline;
	}

	.header{
		text-align: center;
	}
	.status-pasien{
		font-size: 13px;
	}
	.h1{
		font-size: 18px;
		font-weight: bold;
	}
	.h2{
		font-size: 12px;
	}
	.h3{
		font-size: 12px;
	}
	.font-weight-normal{
		font-weight: normal;
	}

	.min-margin {
		margin:0;
		padding:0;
	}

	.isi-usg{
		padding: 10px 20px;
	}

	table.usg tr td{
		padding: 3px 0px;
	}
	.alert{
		border : 0.5px solid #000000;
		padding: 5px;
	}

	table {
		width:100%;
	}

	.bold{
		font-weight: bold;
	}

	.border td, .border th{
		border : 0.5px solid black;
	}
	.noBorder td, .noBorder th{
		border : none;
	}

	#qc{
		height: 50px;
	}
	.tabelTerapi td{
   white-space: nowrap;

	}
	table{
		font-size:10px;
		border-collapse:collapse;
	}
	.klinik {
		font-size:30px;font-weight:bold;margin-bottom: 5px;
	}
	.title{
		text-align: center;
		font-size: 15px;
		margin-bottom: 5px;
	}
	.status-pasien tr td, .status-pasien tr th{
		padding : 4px;
		border: 1px solid black;
	}
	.status-pasien tr th{
		font-size : 15px;
	}

</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
	<table id="header">
		<tr>
			<td class="text-center">
				<div class="klinik">{{ \Auth::user()->tenant->name }} </div>
				<div class="title">
					Jl. Raya Legok - Parung Panjang km. 3, <br>
					Malangnengah, Pagedangan, Tangerang, Banten 021 5977529
				</div>
			</td>
		</tr>
	</table>
<hr />
<div class="text-center">
	<h1>FORM PENGIRIMAN BERKAS</h1>
</div>
	<table style="width:100%" class="status-pasien">
		<thead>
			<tr>
				<th>Invoice</th>
				<th>Asuransi</th>
				<th>Jumlah</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($kirim_berkas->rekap_tagihan as $k => $tagihan)	
				<tr>
					<td>{{ $tagihan['nomor_invoice'] }}</td>
					<td>{{ $k }}</td>
					<td class="text-right">{{ $tagihan['jumlah_tagihan'] }} Tagihan</td>
					<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $tagihan['total_tagihan'] ) }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2"></th>
				<th class="text-right">{{ $jumlah_tagihan }} Tagihan</th>
				<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_tagihan ) }}</th>
			</tr>
		</tfoot>
	</table>
	<br />
	
	<div class="status-pasien">
		Tanggal : {{ $kirim_berkas->tanggal->format('d M Y') }}
	</div>
	<table style="width:100%" class="tanda-tangan status-pasien">
		<tbody>
				<tr>
					@foreach($kirim_berkas->petugas_kirim as $staf)	
						<td>
							<span class="underline">
								{{ $staf->staf->nama }}
							</span>
							<br />
								{{ $staf->role_pengiriman->role_pengiriman }}
						</td>
					@endforeach
				</tr>
		</tbody>
	</table>
    <script type="text/javascript" charset="utf-8">
        window.print();
    </script>
</body>
</html>
