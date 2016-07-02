@extends('layout.master')

@section('title') 
Klinik Jati Elok | USG {{ $periksa->pasien->nama }} - {{ $periksa->id }}

@stop
@section('page-title') 
<h2>Hasil Pemeriksaan USG </h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li>
          <a href="{{ url('pasiens/' . $periksa->pasien_id )}}">Riwayat Pemeriksaan</a>
      </li>
      <li class="active">
          <strong>USG </strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
            	Hasil USG
            </div>
      </div>
      <div class="panel-body">
            <table width="100%" class='table table-condensed'>
				<tr>
					<td nowrap>
						<table style="width:100%" class="content1">
							<tbody>
								<tr>
									<td nowrap>Nama Pasien</td>
									<td nowrap>:</td>
									<td nowrap>{{ $periksa->pasien_id }} - {!! $periksa->pasien->nama !!}</td>
								</tr>
								<tr>
									<td nowrap>Tanggal Lahir</td>
									<td nowrap>:</td>
									<td nowrap>{!! App\Classes\Yoga::updateDatePrep($periksa->pasien->tanggal_lahir) !!}</td>
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
									<td nowrap>{!! App\Classes\Yoga::updateDatePrep($periksa->tanggal) !!}</td>
								</tr>
							</tbody>
					</table>
					</td>
				</tr>
			</table>
      <hr>

		<h1 class="text-center">ULTRASONOGRAFI - {!! $periksa->id !!}</h1>
		<br>

      <table width="100%" class="table table-condensed">
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
			{!! $periksa->usg->fl !!}
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
			{!! $periksa->usg->bpd !!}
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
			{!! $periksa->usg->ac !!}
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
<hr><br>
	<div class="alert alert-success">
			<strong>Kesimpulan :</strong> <br>
			{!! $periksa->usg->kesimpulan !!}

	</div>
	<div class="alert alert-success">
			<strong>Saran :</strong> <br>
			{!! $periksa->usg->saran !!}

	</div>
      </div>
</div>


@stop
@section('footer') 
	
@stop