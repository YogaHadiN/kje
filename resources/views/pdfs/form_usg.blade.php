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
		text-decoration: underline;
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
	table.usg {
		border-collapse:collapse;
		padding-top:20px;
	}

	table.usg tr td{
		padding: 10px;
		border: 1px solid black;
	}

	table.usg tr td:first-child{
		width:25%;
	}
	table.usg tr td:nth-child(2){
		width:25%;
		text-align:center;
	}
	table.usg tr td:nth-child(3){
		width:25%;
	}
	table.usg tr td:nth-child(4){
		width:25%;
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

</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
	<div style="" class="klinik">
		<table width="100%" class="status">
			<tr>
				<td nowrap class="text-left">
					{{ \Auth::user()->tenant->name }}
				</td>
				<td nowrap colspan="2" >{{ $pasien->nama }}</td>
				<td nowrap class="text-right">
					DOKUMEN RAHASIA!!
				</td>
			</tr>
		</table>
	</div>
	<table style="width:100%">
		<tr>
			<td nowrap>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td nowrap>Nama Pasien</td>
							<td nowrap>:</td>
							<td nowrap>{!! $pasien->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tanggal Lahir</td>
							<td nowrap>:</td>
							<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($pasien->tanggal_lahir) !!}</td>
						</tr>
						<tr>
							<td nowrap>Pembayaran</td>
							<td nowrap>:</td>
							<td nowrap>{!! $asuransi->nama !!}</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td nowrap>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td nowrap>No Asuransi</td>
							<td nowrap>:</td>
							<td nowrap>{!! $pasien->nomor_asuransi !!}</td>
						</tr>
						<tr>
							<td nowrap>Diperiksa Oleh</td>
							<td nowrap>:</td>
							<td nowrap>{!! $pasien->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tangal Periksa</td>
							<td nowrap>:</td>
							<td nowrap>{!! date('d-m-Y') !!}</td>
						</tr>
					</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="gantung1">
				Alamat : 
				{!! $pasien->alamat !!}
			</td>
		</tr>
	</table>
<table width="100%" class="usg">
	<tr>
		<td>
			Presentasi
		</td>
		<td>
		</td>
		<td>
			Femur Length
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Biparietal Diameter
		</td>
		<td>
		</td>
		<td>
			Sex
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>Head Circumference</td>
		<td>
		</td>
		<td>
			Abdominal Circumference
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			Lilitan Tali Pusat
		</td>
		<td>
		</td>
		<td>
			Estimated Fetal Weight
		</td>
		<td>
		</td>

	</tr>
	<tr>
		<td>
			Fetal Heart Rate
		</td>
		<td>
		</td>
		<td>
			Amniotic Fluid Index
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Plasenta
		</td>
		<td colspan="3">
		</td>

	</tr>
</table>
</body>
</html>
