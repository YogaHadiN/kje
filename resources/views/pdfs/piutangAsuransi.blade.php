<html>
<head>
	<meta charset="UTF-8">
	<title>{{ env("NAMA_KLINIK") }} | Piutang Asuransi </title>
<style>
	@page 
	{
        margin: 2em;
        padding-right: 2em;
    }

	body{
		font-size : 5px !important;
	}
.font-smaller {
  font-size: 9px;
}

.border-all {
	border:0.5px solid black;
	padding:5px;
}
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
	<h1>Asuransi {{ $asuransi->nama }} (Update tanggal {{ date('d F Y') }})</h1>
	<h3> Piutang  {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }} ({{ count( $piutangs ) }} pasien)</h3>

		<table class="table text3">
			<thead>
				<tr>
					<th>Tanggal Periksa</th>
					<th>ID PERIKSA</th>
					<th>Nama</th>
					<th>Tunai</th>
					<th>Piutang</th>
					{{-- <th>Sudah Dibayar</th> --}}
					{{-- <th>Sisa Piutang</th> --}}
				</tr>
			</thead>
			<tbody>
				@if(count($piutangs) > 0)
					@foreach($piutangs as $p)
						<tr>
							<td>{{ date('d M y', strtotime( $p->tanggal_periksa )) }}</td>
							<td> {{ $p->periksa_id }}</td>
							<td> {{ $p->nama_pasien }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->tunai) }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang) }}</td>
							{{-- <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->sudah_dibayar) }}</td> --}}
							{{-- <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang  - $p->sudah_dibayar) }}</td> --}}
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
				<tr>
					<td colspan="3"></td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_tunai ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</h2>
					</td>
					{{-- <td class="text-right"> --}}
					{{-- 	<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h2> --}}
					{{-- </td> --}}
					{{-- <td class="text-right"> --}}
					{{-- 	<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang - $total_sudah_dibayar ) }}</h2> --}}
					{{-- </td> --}}
				</tr>
			</tbody>


		</table>
</body>
</html>
