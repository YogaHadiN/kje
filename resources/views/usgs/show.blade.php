@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | USG {{ $periksa->pasien->nama }} - {{ $periksa->id }}

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


		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active"><a href="#usg" aria-controls="usg" role="tab" data-toggle="tab">USG</a></li>
			  <li role="presentation"><a href="#anc" aria-controls="anc" role="tab" data-toggle="tab">ANC</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			  <div role="tabpanel" class="tab-pane active" id="usg">
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
			{!! $periksa->usg->fl !!} @if($periksa->usg->fl_mm) ( {!! $periksa->usg->fl_mm !!} ) @endif
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
	{!! $periksa->usg->ac !!} @if($periksa->usg->ac_mm) ( {!! $periksa->usg->ac_mm !!} mm  ) @endif
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
			  <div role="tabpanel" class="tab-pane" id="anc">
				  @include('ancs.form')
			  </div>
		  </div>


	  
	  </div>
</div>


@stop
@section('footer') 
	
@stop

