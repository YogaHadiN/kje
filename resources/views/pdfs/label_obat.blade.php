<html>
<head>
	<meta charset="UTF-8">
	<title>{{ env("NAMA_KLINIK") }} | Label Obat</title>
<style>
	@page 
	{
        margin: 2em;
        padding-right: 2em;
    }
	.padding-left {
		padding-left: 10px;
	}

.font-smaller {
  font-size: 9px;
}

#qr{
	margin-left: 120px;

}
.center {
	  display: block;
	  margin-left: auto;
	  margin-right: auto;
	  width: 100%;
}
.margin-top {
	margin-top: 20px;
}
.tanda-tangan {
 margin-left: 30px;
}
.kop-surat{
	font-size: 15px;
}
.border-all {
	border:0.5px solid black;
	padding:5px;
}
	.status
	{
		text-align:center;
		font-size:18px;
		font-weight:bold;
		border-bottom: 2px solid black;
	}
	.content2 {
		font-size: 12px;
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
		font-size: 15px;
	}
	.content1 td {
		padding : 7px;
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
		font-size: 14px;
		font-weight: bold;
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
		margin: 30px 0px;
	}
	.underline {
		border-bottom: 1px solid #000;
		padding-bottom: 3px;
	}

	.column {
	  float: left;
	}

	.left {
	  width: 25%;
	}

	.right {
	  width: 75%;
	}
	.text-center {
		text-align: center;
	}

</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
	<div style="" class="klinik">
		@foreach ($periksa->terapii as $k => $terapi)
			@if (
				 ucwords($terapi->signa) !== ucwords('puyer' ) &&
				 ucwords($terapi->signa) !== ucwords( 'add')
				)
				<table width="100% text-center">
					<tr>
						<td class="h2 underline text-center">Klinik Jati Elok</td>
					</tr>
					<tr>
						<td class="font-small text-center">{{ \Carbon\Carbon::parse( $periksa->tanggal )->format('d M Y') }}</td>
					</tr>
					<tr>
						<td class="h2 text-center">{{ $periksa->pasien->nama }}</td>
					</tr>
					<tr>
						<td class="h1 text-center">{{ $terapi->signa }}</td>
					</tr>
					<tr>
						<td class="text-center">{{ $terapi->aturan_minum }}</td>
					</tr>
				</table>
				@if ($k != (count($periksa->terapii) -1))
					<div style="page-break-after:always;">
					</div>
				@endif
			@endif
		@endforeach
	</div>
    <script type="text/javascript" charset="utf-8">
        window.print();
    </script>
</body>
</html>
