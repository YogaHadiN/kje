<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Diagnosa Rujukan BPJS</title>
<style>
	@page 
	{
        margin: 2em;
        padding-right: 2em;
    }

	html * {
		font-family: "Times New Roman", Times, serif !important;
	}
.font-smaller {
  font-size: 9px;
}

.border-all {
	border:0.5px solid black;
	padding:5px;
}

thead { display: table-header-group }
tfoot { display: table-row-group }
tr { page-break-inside: avoid }

	.status
	{
		text-align:center;
		font-size:15px;
		font-weight:bold;
		border-bottom: 2px solid black;
	}
	.content2 {
		padding:5px;
		border-collapse: collapse;
		border: 1px solid black;
	}
	.table{
		border-spacing: -1px;
		border-collapse: collapse;
	}
	.table td , .table th{
		padding:2px;
		vertical-align: text-top;
		border:1px solid black;
		border-collapse: collapse;
	}

	.table td , .table th{
		padding:2px;
		vertical-align: text-top;
		border:1px solid black;
		border-collapse: collapse;
	}
	.gantung1 {
		padding: 2px 2px 5px 4px;
	}

	.klinik {
		font-size:30px;font-weight:bold;margin-bottom: 5px;
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
		width:25%;
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

	.header{
		text-align: center;
	}
	h1{
		font-size: 18px;
		font-weight: bold;
	}
	h2{
		font-size: 12px;
	}
	h3{
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
	.table-bordered td{
		border-collapse : collapse;
		border : 1px solid black;
	}
	table {
		 font-size:9px;
	}

</style>
</head>
<body>
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
<h1>Laporan Diagnosa Rujukan BPJS bulan {{ $bulan->format('M Y') }} ( updated {{ date('d M Y H:i:s') }} )</h1>
<h1>{{ count($periksas) }} Pasien</h1>

<table class="table text3">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nama Pasien</th>
				<th>Nomor Asuransi</th>
				<th>Diagnosa</th>
			</tr>
		</thead>
		<tbody>
			@if(count($periksas) > 0)
				@foreach($periksas as $periksa)
					<tr>
						<td>{{ $periksa->tanggal }}</td>
						<td>{{ ucwords( $periksa->nama_pasien ) }}</td>
						<td>{{ $periksa->nomor_asuransi_bpjs }}</td>
						<td>{{ $periksa->diagnosa }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
				</tr>
			@endif
		</tbody>
	</table>
</body>
</html>
