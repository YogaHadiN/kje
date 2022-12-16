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
	.padding-left {
		padding-left: 10px;
	}

.font-smaller {
  font-size: 12px;
}

#qr{
	margin-left: 120px;

}
.border-all td {
	border:1px solid black;
}
.tanda_tangan_evaluasi_obat td{
    text-align: center;
    width: 50%;
    height: 50px;
	border:1px solid black;
}
.border-all td:first-child {
    width: 1px;white-space: nowrap;
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

	.column {
	  float: left;
	}

	.left {
	  width: 25%;
	}

	.right {
	  width: 75%;
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
				<td nowrap colspan="2" >STATUS - {!! $periksa->id !!}</td>
				<td nowrap class="text-right">
					DOKUMEN RAHASIA!!
				</td>
			</tr>
		</table>
	</div>
	<table style="width:100%" class="status-pasien">
		<tr>
			<td nowrap>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td nowrap>Nama Pasien</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->pasien->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tanggal Lahir</td>
							<td nowrap>:</td>
							<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->pasien->tanggal_lahir) !!}</td>
						</tr>
						<tr>
							<td nowrap>Pembayaran</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->asuransi->nama !!}</td>
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
							<td nowrap>{!! $periksa->pasien->nomor_asuransi !!}</td>
						</tr>
						<tr>
							<td nowrap>Diperiksa Oleh</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->staf->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tangal Periksa</td>
							<td nowrap>:</td>
							<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}</td>
						</tr>
					</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="content1 padding-left">
				Alamat : 
				{!! $periksa->pasien->alamat !!}
			</td>
		</tr>
        @if($periksa->poli->poli != 'Poli ANC' && $periksa->poli->poli !='Poli USG Kebidanan')
			<tr class="content2">
				<td class="half">
					<strong>Anamnesa :</strong> <br>
					{!! $periksa->anamnesa !!}<br>
					<strong>Pemeriksaan Fisik :</strong><br>
					{!! $periksa->pemeriksaan_fisik !!}<br>
					@if( !empty($periksa->sistolik) || !empty($periksa->diastolik) )
						<strong>Tekanan Darah</strong><br>
						{!! $periksa->sistolik !!} / {!! $periksa->diastolik !!} mmHg<br>
					@endif
					@if($periksa->pemeriksaan_penunjang != '')
						<strong>Pemeriksaan Penunjang dan Tindakan</strong><br>
						{!! $periksa->pemeriksaan_penunjang !!} <br>
					@endif
					<strong>Diagnosis Kerja</strong><br>
					{!! $periksa->diagnosa->diagnosa !!} ({!! $periksa->diagnosa->icd10_id!!} - 
					{!! $periksa->diagnosa->icd10->diagnosaICD !!})
					@if(isset( $periksa->rujukan ))
						<strong>Diagnosis Merujuk</strong><br>
						{!! $periksa->rujukan->diagnosa->diagnosa !!} ({!! $periksa->rujukan->diagnosa->icd10_id!!} - 
						{!! $periksa->rujukan->diagnosa->icd10->diagnosaICD !!})
					@endif
					@if( isset( $perika->rujukan ) && $periksa->rujukan->tacc )
						<strong>TACC</strong>
					@endif
	              @if($periksa->suratSakit)
	                @include('pdfs.suratSakit')
	              @endif
				</td>

				<td class="content2 half">
					<strong>RESEP : 
                        @if( 
                            !is_null($periksa->antrian) &&
                            !$periksa->antrian->menunggu
                            )
                            (Pasien menungu di rumah)
                        @endif
                    </strong>
					{!! $periksa->terapi_htmlll !!}
                   @if (!empty($periksa->resepluar))
                       Resep ditebut di apotek di Luar : <br>
                       {!! $periksa->resepluar !!}
                   @endif
					<br>
					@if($periksa->rujukan)
						dirujuk ke 
						@if($periksa->rujukan->tujuanRujuk)
							{!! $periksa->rujukan->tujuanRujuk->tujuan_rujuk !!} 
						@endif
						karena 

                        @if( $periksa->asuransi->tipe_asuransi_id == '5' )
							@if( !empty( $periksa->rujukan->time ) )
								<strong>(Time)</strong>{!! $periksa->rujukan->time!!}
							@endif	
							@if( !empty($periksa->rujukan->age) )
								<strong>(Age)</strong>{!! $periksa->rujukan->age!!}
							@endif	
							@if( !empty($periksa->rujukan->comorbidity) )
								<strong>(Comorbidity)</strong>{!! $periksa->rujukan->comorbidity!!}
							@endif	
							@if( !empty($periksa->rujukan->complication) )
								<strong>(Complication)</strong>{!! $periksa->rujukan->complication!!}
							@endif	

						@else
							{!! $periksa->rujukan->complication!!}
						@endif
					@endif
					@if($bayarGDS)
						@include('warninggds2', ['pasien_id' => $periksa->pasien_id, 'periksa' => $periksa ])
					@endif
					@if($periksa->asuransi_id == 0 && !empty($periksa->keterangan))
						<div class="alert alert-danger">
							{{ $periksa->keterangan }}
						</div>
					@endif
                    @if($periksa->asuransi->tipe_asuransi_id == '5' && $biaya > 0)
						<div class="alert alert-danger">
							Pasien BPJS ada biaya tambahan sebesar <strong>Rp. {{ $biaya }},-</strong> <br>
						</div>
					@endif
					@if(
					$periksa->asuransi->tipe_asuransi_id == '4' &&
					($biayaObat > $tarifObatFlat))
						<div class="alert alert-danger">
							Pasien <strong> {{ $periksa->asuransi->nama }}</strong> ini ada biaya tambahan sebesar <strong>Rp. {{ $biayaObat - $tarifObatFlat }},-</strong> <br>
						</div>
					@endif
                    <table class="border-all">
                        <tbody>
                            <tr>
                                <td>Tepat Nama dan Tanggal Lahir Pasien</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tepat Obat</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tepat Jumlah</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tepat Identifikasi LASA</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tepat Edukasi Cara Pakai</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tepat Edukasi Masa Pakai</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="tanda_tangan_evaluasi_obat">
                        <tbody>
                            <tr>
                                <td>Td Tangan Pasien / Wali</td>
                                <td>Td Tangan Petugas Obat</td>
                            </tr>
                        </tbody>
                    </table>
				</td>
			</tr>
			<table width="100%" id="qc" class="border">
				<tbody>
					<tr>
						<td>Ttd Peracik</td>
						@if($puyerAdd)
						<td>Ttd Saksi Puyer/Add</td>
						@endif
						<td>Ttd Quality Control</td>
						<td>Ttd Pemeriksa</td>
					</tr>
				</tbody>
			</table>
		@else
			<tr>
				<td colspan="2" class="content1">
					<table style="width:100%" class="border">
						<tr>
							<th>Anamnesa</th>
							<th>Pemeriksaan Penunjang</th>
							<th>Terapi</th>
						</tr>
						<tr>
							<td>{!! $periksa->anamnesa !!}</td>
							<td>{!! $periksa->pemeriksaan_penunjang!!}</td>
							<td>{!! $periksa->terapi_inline !!}</td>
                               @if (!empty($periksa->resepluar))
                                   Resep ditebut di apotek di Luar : <br> 
                                   {!! $periksa->resepluar !!}
                               @endif
						</tr>
					</table>
					<div class="content1">
						Diagnosa dan diagnosa tambahan : {!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!} <strong>({!!$periksa->diagnosa->icd10_id!!})</strong> <br>
							{!! $periksa->keterangan_diagnosa!!}
					</div>
					<table class="content1">
						<tr>
							<td>
								<table style="width:100%">
									<tr>
										<td nowrap class="bold">Nama Suami</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->nama_suami !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Buku</td>
										<td nowrap>
											@if(isset($periksa->registerAnc->registerHamil->buku->buku))
                                                {!! $periksa->registerAnc->registerHamil->buku->buku !!}
											@else
                                                Tidak Ada Buku
											@endif
										</td>
									</tr>
									<tr>
										<td nowrap class="bold">Golongan Darah</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->golongan_darah !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Tinggi Badan</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->tinggi_badan !!} cm</td>
									</tr>
									<tr>
										<td nowrap class="bold">BB Sebelum Hamil</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->bb_sebelum_hamil !!} kg</td>
									</tr>
									<tr>
										<td nowrap class="bold">Riwayat Obstetri</td>
										<td nowrap>G{!! $periksa->registerAnc->registerHamil->g !!}P{!! $periksa->registerAnc->registerHamil->p !!}A{!! $periksa->registerAnc->registerHamil->a !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold" colspan="2">Riwayat Persalinan Sebelumnya</td>
									</tr>
									<tr>
										<td nowrap colspan="2">
											{!! $periksa->registerAnc->registerHamil->riwobs !!}
										</td>
									</tr>
								</table>
							</td>
							<td nowrap>
								<table>
									<tr>
										<td nowrap class="bold">HPHT</td>
										<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->registerAnc->registerHamil->hpht) !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Umur Kehamilan</td>
										<td nowrap>{!! App\Models\Classes\Yoga::umurKehamilan($periksa->registerAnc->registerHamil->hpht, date('Y-m-d')) !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Rencana Penolong</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_penolong !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Rencana Tempat</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_tempat !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Rencana Pendamping</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_pendamping !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Rencana Transportasi</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_transportasi !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Rencana Pendonor</td>
										<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_pendonor !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Umur Anak Terakhir</td>
										<td nowrap>{!! App\Models\Classes\Yoga::datediff($periksa->registerAnc->registerHamil->tanggal_lahir_anak_terakhir, $periksa->tanggal) !!}</td>
									</tr>
									<tr>
										<td nowrap class="bold">Catat di Buku KIA</td>
										<td nowrap>{!!App\Models\Classes\Yoga::returnConfirm($periksa->registerAnc->catat_di_kia) !!}</td>
										{{-- <td nowrap>{!!$periksa->registerAnc->catat_di_kia !!}</td> --}}
									</tr>
								</table>
							</td>
							<td nowrap>
								<table>
									<tr>
										<td class="bold" nowrap>Tekanan Darah</td>
										<td nowrap>
											{!! $periksa->registerAnc->td !!} mmHg
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>TFU</td>
										<td nowrap>
											{!! $periksa->registerAnc->tfu !!} cm
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>LILA</td>
										<td nowrap>
											{!! $periksa->registerAnc->lila !!}cm
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>BB</td>
										<td nowrap>
											{!! $periksa->registerAnc->bb !!} kg
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>Refleks Patella</td>
										<td nowrap>
											{!! $periksa->registerAnc->refleksPatela->refleks_patela !!}
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>DJJ</td>
										<td nowrap>
											{!! $periksa->registerAnc->djj !!} bpm
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>Kepala Thd PAP</td>
										<td nowrap>
											{!! $periksa->registerAnc->kepalaTerhadapPap->kepala_terhadap_pap !!}
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>Presentasi</td>
										<td nowrap>
											{!! $periksa->registerAnc->presentasi->presentasi !!}
										</td>
									</tr>
									<tr>
										<td class="bold" nowrap>Status Gizi</td>
										<td nowrap>
											{!! App\Models\Classes\Yoga::statusGizi($periksa->registerAnc->lila) !!}
										</td>
									</tr>
									@if($periksa->usg)
									<tr>
										<td class="bold" nowrap>Perujuk</td>
										<td nowrap>
											@if(isset( $periksa->usg->perujuk ))
												{!! $periksa->usg->perujuk->nama !!}
											@else
												Tidak Ada Perujuk
											@endif
										</td>
									</tr>
									@endif
								</table>

							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
				  @if($periksa->suratSakit)
					@include('pdfs.suratSakit');
	              @endif
				</td>
				<td>
					@if($periksa->rujukan)
                        @if( $periksa->asuransi->tipe_asuransi_id == '5' )
							@if( !empty( $periksa->rujukan->time ) )
								<strong>(Time)</strong>{!! $periksa->rujukan->time!!}
							@endif	
							@if( !empty($periksa->rujukan->age) )
								<strong>(Age)</strong>{!! $periksa->rujukan->age!!}
							@endif	
							@if( !empty($periksa->rujukan->comorbidity) )
								<strong>(Comorbidity)</strong>{!! $periksa->rujukan->comorbidity!!}
							@endif	
							@if( !empty($periksa->rujukan->complication) )
								<strong>(Complication)</strong>{!! $periksa->rujukan->complication!!}
							@endif	

						@else
							{!! $periksa->rujukan->complication!!}
						@endif
					@endif
				</td>
			</tr>
		@endif
	</table>
	@if(!empty($periksa->rujukan->id))
	<div style="page-break-after:always;">
	</div>
		<div class="screen">
			<table width="100%">
				<tr>
					@for($i = 0; $i < 2; $i++)
					<td class="rujukan{!!$i!!}">
						<div class="text-center">
							<table>
								<tbody>
									<tr>
										<td>
											<h3>{{ \Auth::user()->tenant->name }}</h3>
										</td>
										<td class="text-right">
											<h3>SURAT RUJUKAN</h3>
											
										</td>
									</tr>
									<tr>
										<td colspan="2" class="font-smaller">
											{{ \Auth::user()->tenant->address_line1 }}<br>
											{{ \Auth::user()->tenant->address_line2 }}
										</td>
									</tr>
								</tbody>
							</table>

							<hr>
						</div>
						<div class="text">
							Kepada Yth dr. 
							@if($periksa->rujukan->tujuanRujuk)
								{!! $periksa->rujukan->tujuanRujuk->tujuan_rujuk !!}<br>
							@endif
							Mohon Evaluasi dan Tatalaksana Pasien
						</div>
						<div class="identitas">
							<table>
								<tr>
									<td>Nama</td>
									<td>:</td>
									<td>{!! $periksa->pasien->nama !!}, {!! App\Models\Classes\Yoga::umurSaatPeriksa($periksa->pasien->tanggal, date('Y-m-d'))!!}</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>:</td>
									<td>{!! $periksa->anamnesa !!}, {!!$periksa->pemeriksaan_fisik!!}</td>
								</tr>
								<tr>
									<td>Diagnosa Kerja</td>
									<td>:</td>
									<td>
										{!! $periksa->diagnosa->diagnosa !!} ({!! $periksa->diagnosa->icd10_id!!} - 
										{!! $periksa->diagnosa->icd10->diagnosaICD !!})
										@if( $periksa->rujukan->tacc )
											<strong>TACC</strong>
										@endif
									</td>
								</tr>
								@if( $periksa->rujukan )
									<tr>
										<td>Diagnosa Merujuk</td>
										<td>:</td>
										<td>
											{!! $periksa->rujukan->diagnosa->diagnosa !!} ({!! $periksa->rujukan->diagnosa->icd10_id!!} - 
											{!! $periksa->rujukan->diagnosa->icd10->diagnosaICD !!})
											@if( $periksa->rujukan->tacc )
												<strong>TACC</strong>
											@endif
										</td>
									</tr>
								@endif
								<tr>
									<td>Alasan Rujuk</td>
									<td>:</td>
									<td>
										@if($periksa->rujukan)
                                            @if( $periksa->asuransi->tipe_asuransi_id == '5' )
												@if( !empty( $periksa->rujukan->time ) )
													<strong>(Time)</strong>{!! $periksa->rujukan->time!!}
												@endif	
												@if( !empty($periksa->rujukan->age) )
													<strong>(Age)</strong>{!! $periksa->rujukan->age!!}
												@endif	
												@if( !empty($periksa->rujukan->comorbidity) )
													<strong>(Comorbidity)</strong>{!! $periksa->rujukan->comorbidity!!}
												@endif	
												@if( !empty($periksa->rujukan->complication) )
													<strong>(Complication)</strong>{!! $periksa->rujukan->complication!!}
												@endif	

											@else
												{!! $periksa->rujukan->complication!!}
											@endif
										@endif
									</td>
								</tr>
								<tr>
									<td>Tindakan Awal</td>
									<td>:</td>
									<td>{!! $periksa->pemeriksaan_penunjang !!}</td>
								</tr>
							</table>
							<div class="font-smaller">
								{!! $periksa->terapi_htmllll !!}
                               @if (!empty($periksa->resepluar))
                                   Resep ditebut di apotek di Luar : <br>
                                   {!! $periksa->resepluar !!}
                               @endif
							</div>
						</div>
							<div class="text2">
								Atas Perhatian dan Kerjasamanya kami ucapkan terimakasih
							</div>
							<table>
								<tbody>
									<tr>
										<td class="border-all">
											Rujukan ke :  <br>
											@if($periksa->rujukan->rumahSakit)
												{!! $periksa->rujukan->rumahSakit->nama !!}
											@endif
											<span class="font-smaller">
											@if($periksa->rujukan->rumahSakit)
												{!! $periksa->rujukan->rumahSakit->alamat !!}, {!! $periksa->rujukan->rumahSakit->telepon !!}, telp UGD : {!! $periksa->rujukan->rumahSakit->ugd !!}
											@endif
											</span>
                                            @if($periksa->asuransi->tipe_asuransi_id=='5')
											<br>BPJS Center :
											<div class="font-smaller">
												@if($periksa->rujukan->rumahSakit)
													@foreach($periksa->rujukan->rumahSakit->bpjsCenter as $telp)
														{!! $telp->telp !!} ({!! $telp->nama !!}), 
													@endforeach
												@endif
											</div>
											@endif
										</td>
										<td nowrap class="text-center">
											Tangerang, {!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}
											<br><br><br><br><br>
											{!! $periksa->staf->nama !!}
										</td>
									</tr>
								</tbody>
							</table>
							
					 @if($i == 0)
						</td>
					 @else
					 	<div class="foot-note">
					 		ARSIPKAN!
					 	</div>
					 </td>
					 @endif
					@endfor
					
				</tr>
			</table>
		</div>
	@endif
	@if($periksa->usg)
		@for($i = 0; $i < $cetak_usg; $i++)

	<div style="page-break-after:always;">
	</div>
		<div class="screen">
			<table width="100%">
				<tr>
					<td class="rujukan">
						@include('pdfs.titel')
	<table width="100%">
		<tr>
			<td nowrap>
				<table style="width:100%" class="content1">
					<tbody>
						<tr>
							<td nowrap>Nama Pasien</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->pasien->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tanggal Lahir</td>
							<td nowrap>:</td>
							<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->pasien->tanggal_lahir) !!}</td>
						</tr>
						<tr>
							<td nowrap>Pembayaran</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->asuransi->nama !!}</td>
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
							<td nowrap>{!! $periksa->pasien->nomor_asuransi !!}</td>
						</tr>
						<tr>
							<td nowrap>Diperiksa Oleh</td>
							<td nowrap>:</td>
							<td nowrap>{!! $periksa->staf->nama !!}</td>
						</tr>
						<tr>
							<td nowrap>Tangal Periksa</td>
							<td nowrap>:</td>
							<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}</td>
						</tr>
					</tbody>
			</table>
			</td>
		</tr>
	</table>
	<hr>
					<div class="title isi-usg"><strong>ULTRASONOGRAFI - {!! $periksa->id !!}</strong></div>
						<table width="100%" class="usg">
							<tr>
								<td>
									Presentasi
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->presentasi !!}
								</td>
								<td>
									Femur Length
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->fl !!}  @if($periksa->usg->fl_mm) ( {!! $periksa->usg->fl_mm !!} mm) @endif
								</td>
							</tr>
							<tr>
								<td>
									Biparietal Diameter
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->bpd !!}  @if($periksa->usg->bpd_mm) ( {!! $periksa->usg->bpd_mm !!} mm) @endif
								</td>
								<td>
									Sex
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->sex !!}
								</td>
							</tr>

							@if($periksa->usg->hc)
								<tr>
									<td>Head Circumference</td>
									<td>
										:
									</td>
									<td>
										{!! $periksa->usg->hc !!}  @if($periksa->usg->hc_mm) ( {!! $periksa->usg->hc_mm !!} mm) @endif
									</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							@endif
							<tr>
								<td>
									Lilitan Tali Pusat
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->ltp !!} 
								</td>
								<td>
									Estimated Fetal Weight
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->efw !!}
								</td>

							</tr>
							<tr>
								<td>
									Fetal Heart Rate
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->djj !!} bpm
								</td>
								<td>
									Amniotic Fluid Index
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->ica !!}
								</td>
							</tr>
							<tr>
								<td>
									Abdominal Circumference
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->ac !!}  @if($periksa->usg->ac_mm) ( {!! $periksa->usg->ac_mm !!} mm) @endif
								</td>
								<td>
									Plasenta
								</td>
								<td>
									:
								</td>
								<td>
									{!! $periksa->usg->plasenta !!}
								</td>

							</tr>
						</table>
							<div class="text">
									<strong>Kesimpulan :</strong> <br>
									{!! $periksa->usg->kesimpulan !!}

							</div>
							<div class="text">
									<strong>Saran :</strong> <br>
									{!! $periksa->usg->saran !!}

							</div>
					</td>
				</tr>
			</table>
		</div>
		@endfor
	@endif
	  @if($periksa->suratSakit)
		<div style="page-break-after:always;">
		</div>

	<div style="page-break-after:always;">
	</div>
		<div class="screen">
			<table width="100%">
				<tr>
					<td class="rujukan">
						@include('pdfs.titel')
						<h1 class="min-margin text-center margin-top">SURAT KETERANGAN SAKIT</h1>
						<hr>
							<table width="100%">
								<tr>
									<td nowrap>
										<table style="width:100%" class="content1">
											<tbody>
												<tr>
													<td nowrap>Nama Pasien</td>
													<td nowrap>:</td>
													<td nowrap>{!! $periksa->pasien->nama !!}</td>
												</tr>
												<tr>
													<td nowrap>Tanggal Lahir</td>
													<td nowrap>:</td>
													<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->pasien->tanggal_lahir) !!}</td>
												</tr>
												<tr>
													<td nowrap>Alamat</td>
													<td nowrap>:</td>
													<td nowrap>{!! $periksa->pasien->alamat !!}</td>
												</tr>
												<tr>
													<td colspan="3">
														Pada pemeriksaan jasmani saat ini dalam keadaan sakit maka perlu istirahat selama
													</td>
												</tr>
												<tr>
													<td colspan="3">
														<strong>{{ $periksa->suratSakit->hari }} ({{ App\Models\Classes\Yoga::terbilang($periksa->suratSakit->hari) }}  ) Hari, terhitung tanggal {{ \Carbon\Carbon::parse( $periksa->suratSakit->tanggal_mulai )->format( 'd M Y' ) }} s/d {{ \Carbon\Carbon::parse( $periksa->suratSakit->tanggal_mulai)->addDays( (int) $periksa->suratSakit->hari - 1 )->format('d M Y') }}</strong>
													</td>
												</tr>
												<tr>
													<td colspan="3">Harap yang berkepentingan maklum</td>
												</tr>
												<tr>
													<td colspan="3"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="row text-center">
			<div class="column left">
				<img id="qr" height="200px" class="text-right" src="{{ $base64 }}" />
			</div>
			<div class="column right tanda-tangan content1">
				Tangerang, {{ \Carbon\Carbon::parse($periksa->tanggal)->format('d M Y') }}
				<br>
				<br>
				Dokter Pemeriksa
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<u>dr. {{ $periksa->staf->nama }}<br></br></u>
				SIP. {{ $periksa->staf->sip }}
			</div>
		</div>
	  @endif
	  @if($periksa->gdp_bpjs)
		<div style="page-break-after:always;">
		</div>

	<div style="page-break-after:always;">
	</div>
		<div class="screen">
			<table width="100%">
				<tr>
					<td class="rujukan">
						@include('pdfs.titel')
						<h1 class="min-margin text-center margin-top">PERMINTAAN PEMERIKSAAN LABORATORIUM</h1>
						<hr>
							<table width="100%">
								<tr>
									<td nowrap>
										<table style="width:100%" class="content1">
											<tbody>
												<tr>
													<td nowrap colspan="3">Mohon agar dapat dilakukan pemeriksaan <strong>Gula Darah Puasa</strong> untuk pasien :</td>
												</tr>
												<tr>
													<td nowrap>Nama Pasien</td>
													<td nowrap>:</td>
													<td nowrap>{!! $periksa->pasien->nama !!}</td>
												</tr>
												<tr>
													<td nowrap>Tanggal Lahir</td>
													<td nowrap>:</td>
													<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->pasien->tanggal_lahir) !!}</td>
												</tr>
												<tr>
													<td nowrap>Alamat</td>
													<td nowrap>:</td>
													<td nowrap>{!! $periksa->pasien->alamat !!}</td>
												</tr>
												<tr>
													<td nowrap>No BPJS</td>
													<td nowrap>:</td>
													<td nowrap>{!! $periksa->pasien->nomor_asuransi_bpjs !!}</td>
												</tr>
												<tr>
													<td colspan="3" class="border-all">
														<strong class="padding">
															Hasil Pemeriksaan : {{ $periksa->gdp_bpjs  }} mg/dL
														</strong>
													</td>
												</tr>
												<tr>
													<td colspan="3">Atas Kerja Samanya kami ucapkan terima kasih</td>
												</tr>
												<tr>
													<td colspan="3"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="row text-center">
			<div class="column left content1">
				Pasien
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				{{ $periksa->pasien->nama }}
			</div>
			<div class="column right tanda-tangan content1">
				Tangerang, {{ \Carbon\Carbon::parse($periksa->tanggal)->format('d M Y') }}
				<br>
				<br>
				Kepala FKTP
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				dr. Puri Widiyani M
			</div>
		</div>
	  @endif
    <script type="text/javascript" charset="utf-8">
        window.print();
    </script>
</body>
</html>
