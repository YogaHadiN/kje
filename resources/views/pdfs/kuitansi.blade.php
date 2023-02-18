<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Kuitansi</title>
    <style>
        table {border: none;}
        @page 
        {
            margin: 2em;
            padding-right: 2em;
          font-size: 12px;
        }
        .uang {
            text-align: right;
        }

    .font-smaller {
      font-size: 9px;
    }
    .pt-8 {
        padding-top: 4px;
    }

    .text-right {
        text-align: right;
    }

    .border-all td{
        border:0.5px solid black;
        padding:5px;
    }
    .border-all th {
        border:0.5px solid black;
        padding:5px;
    }
        .status
        {
            text-align:center;
            font-size:20px;
            font-weight:bold;
        }
        .content2 {
            padding:10px;
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
            font-size:26px;font-weight:bold;margin-bottom: 5px;
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
        }

        .rujukan1 {
            padding-left:20px;
        }
        .sakit0 {
            padding-right:20px;
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

        table.usg tr td{
            padding: 3px 0px;
        }
        .alert{
            padding: 5px;
        }

        table {
            width:100%;
        }

        .bold{
            font-weight: bold;
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
        table{
             font-size:9px !important;
        }
        .text-right{
            text-align:right;
        }
    .detail{
        padding: 30px 0px !important;
        margin-bottom: 30px;
    }
    .no-border th, .border-none td {
        border:none;
    }

	.status
	{
		text-align:center;
		font-size:16px !important;
		font-weight:bold;
	}
    .bb {
		border-bottom: 2px solid black;
    }

    </style>
</head>
<body style="font-size:12px; font-family:sans-serif">
	<div style="" class="bottom">
		<table width="100%">
			<tr>
				<table width="100%" class="status bb">
                    <tr>
                        <td nowrap class="text-left">
                            {{ \Auth::user()->tenant->name }}
                        </td>
                        <td nowrap colspan="3" class="text-right">
                            KUITANSI - {!! $periksa->id !!}
                        </td>
                    </tr>
                </table>
			</tr>
		</table>
	</div>
	<table style="width:100%">
		<tr>
			<td class="bb">
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
			<td class="bb">
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td>Diperiksa Oleh</td>
							<td>:</td>
							<td>{!! tambahkanGelar( 'dr' , $periksa->staf->nama ) !!}</td>
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
                <strong class="detail">Rincian Biaya Obat</strong> <br></br> 
                <table width="100%" class="pt-8 border-all">
                    <thead>
                        <tr>
                            <th>
                                Merek
                            </th>
                            <th>
                                Jumlah
                            </th>
                            <th>
                                Harga Satuan
                            </th>
                            <th>
                                Harga Total
                            </th>
                        </tr>
                    </thead>
					<tbody>
                        @php
                            $total_biaya_obat = 0;
                        @endphp
                        @foreach( $periksa->terapii as $terapi )
                            <tr>
                                <td>{{  $terapi->merek->merek == 'Add Sirup' ? 'Biaya Racik' : $terapi->merek->merek }}</td>
                                <td class="text-right">{{ $terapi->jumlah }}</td>
                                <td class="text-right">{{ buatrp( $terapi->harga_jual_satuan ) }}</td>
                                <td class="text-right">{{ buatrp(   $terapi->harga_jual_satuan * $terapi->jumlah  ) }}</td>
                                @php
                                    $total_biaya_obat += $terapi->harga_jual_satuan * $terapi->jumlah  ;
                                @endphp
                            </tr>
                        @endforeach
					</tbody>
					<tfoot>
						<tr class="b-top">
							<td colspan="3">Total Biaya</td>
							<td class="text-right uang">{{ buatrp( $total_biaya_obat ) }}</td>
						</tr>
					</tfoot>
				</table>
                <br></br>
                <strong class="detail">Rincian Biaya Pelayanan</strong> <br></br> 
				<table width="100%" class="border-all">
					<tbody>
                        @php
                            $total_biaya_transaksi = 0;
                        @endphp
                        @foreach( $periksa->transaksii as $transaksi )
                            <tr>
                                <td>{{ $transaksi->jenisTarif->tipe_jenis_tarif_id == 1? 'Jasa Dokter dan Administrasi' : $transaksi->jenisTarif->jenis_tarif   }}</td>
                                <td>:</td>
                                <td class="text-right">{{ buatrp(  $transaksi->biaya  ) }}</td>
                                @php
                                    $total_biaya_transaksi += $transaksi->biaya;
                                @endphp
                            </tr>
                        @endforeach
					</tbody>
					<tfoot>
						<tr class="b-top">
							<td colspan="2">Total Biaya</td>
							<td class="text-right uang">{{ buatrp( $total_biaya_transaksi ) }}</td>
						</tr>
					</tfoot>

				</table>
                <div class="pt-8">
                    <br>
                    Terbilang : 
                    <br>
                    <br>
                    <h3>
                        {!! $periksa->terbilang !!}
                    </h3>
                </div>
			</td>

			<td class="content1">
					<strong>RESEP :</strong> <br>
					{!! $periksa->terapi_htmlll !!}
                    <br></br>
                <div class="text-right bold pt-8">Tangerang, {!! \Carbon\Carbon::parse($periksa->tanggal)->format('d M Y') !!}</div>
			</td>
		</tr>
	</table>
</body>
</html>
