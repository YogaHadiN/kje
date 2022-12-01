<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Status</title>
<style>
	@page 
	{
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
		font-size:20px;
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
		padding:5px;
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
		font-size: 25px;
	}
	.title2{
		text-align: center;
		font-size: 16px;
		text-decoration: underline;
		margin: 15px 0px;
	}

	#header .nama_klinik{
		text-align: center;
        font-size: 40px;
        margin:10px !important;
	}

	#header .alamat_klinik{
		text-align: center;
        font-size: 16px;
        margin:10px !important;
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
	table {
		border-collapse : collapse;
	}
	table td, table th{
		border-collapse : collapse;
		border : 1px solid #2f4050;
        font-size: 12px;
	}

	table th{
        font-size: 16px;
        padding: 10px;
	}
	table{
		 font-size:9px !important;
	}
	.text-right{
		text-align:right;
	}
	.uang {
		text-align:right;
	}
    .p-0 {
        padding: 0px;
    }

</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
    <div id="header" class="text-center">
        <p class="nama_klinik">{{ ucwords( \Auth::user()->tenant->name ) }}</p>
      <p class="alamat_klinik">{{ ucwords( \Auth::user()->tenant->address_line1 ) }}</p>
      <p class="alamat_klinik">{{ ucwords( \Auth::user()->tenant->address_line2 ) }}</p>
      <p class="alamat_klinik">{{ ucwords( \Auth::user()->tenant->address_line3 ) }}</p>
    </div>
    <hr>
    <div class="p-0">
        <p class="title">Laporan Tindakan Harian Tanggal {{ \Carbon\Carbon::parse( $tanggal )->format('d M Y') }}</p>
    </div>
	@include('laporans.formTindakanHarian')
</body>
</html>
