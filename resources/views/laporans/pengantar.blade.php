@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pengantar Pasien BPJS

@stop

@section('head') 
<style type="text/css" media="all">
table tr th:first-child, table tr td:first-child {
	width:10%;
}

table tr th:nth-child(2), table tr td:nth-child(2) {
	width:40%;
}

table tr th:nth-child(3), table tr td:nth-child(3) {
	width:40%;
}

table tr th:nth-child(4), table tr td:nth-child(4) {
	width:10%;
}
</style>

@stop
@section('page-title') 
<h2>Laporan Pengantar Pasien BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Pengantar Pasien BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 

<div class="panel panel-success">
<div class="panel-heading">Terdaftar {{ count($pp) }}</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed DT">
				<thead>
					<tr>
						<th>Nama Pengantar</th>
						<th>KTP</th>
						<th>BPJS</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
						@foreach($pp as $p)
							@if( $p->kunjungan_sehat == '1' )
								<tr>
									<td>{{ $p->nama_pengantar }} <br />
										<strong>Tanggal</strong> <br />
										{{App\Classes\Yoga::updateDatePrep(  explode( " ", $p->created_at )[0]  )}} <br />
									
									<a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $p->pasien_id . '/edit') }}">Detail</a>	
									</td>
									<td>
										<img src="{{ url('/'). '/' . $p->ktp }}" alt="" class="img-rounded upload" />
										@if(!empty( $p->no_ktp ))
											<br />  {{ $p->no_ktp }}
										@else
											<br />  Nomor KTP tidak terdaftar
										@endif
									</td>
									<td>
										<img src="{{ url('/'). '/' . $p->bpjs }}" alt="" class="img-rounded upload" />
										@if(!empty( $p->nomor_asuransi_bpjs ))
											<br />  {{ $p->nomor_asuransi_bpjs }}
										@else
											<br />  Nomor BPJS tidak terdaftar
										@endif
									</td>
									<td>
										{!! Form::open(['url' => 'laporans/pengantar', 'method' => 'post']) !!}
										  {!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
										  <button class="btn btn-primary btn-lg btn-block" type="button" onclick="dummySubmit(this, '{{ $p->nama_pengantar }}');return false;">Terdaftar di PCare</button>
										  {!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endif
						@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
			<div class="panel-title">Terdaftar {{ $ks->count() }}</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed DT">
						<thead>
							<tr>
								<th>Informasi</th>
								<th>Status</th>
								<th>Terapi</th>
							</tr>
						</thead>
						<tbody>
								@foreach($ks as $px)
									<tr>
										<td>
											<strong>Tanggal</strong>
											{{ $px->created_at->format('d-m-Y') }}<br /><br />
											{{ $px->periksa->pasien->nama }} <br />
											<strong>({{ $px->periksa->pasien_id }})</strong>
											<strong>Nomor BPJS :</strong> <br />
											{{ $px->periksa->pasien->nomor_asuransi_bpjs }} <br />
											<a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $px->periksa->pasien_id . '/edit') }}">Detail</a>
										</td>
										<td>
											<strong>Anemnesa :</strong> <br />
											{{ $px->periksa->anamnesa }} <br /><br />
											<strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br />
											{{ $px->periksa->pemeriksaan_fisik }} <br />{{ $px->periksa->pemeriksaan_penunjang }} <br /><br />
											<strong>Diagnosa : </strong> <br />
											{{  $px->periksa->diagnosa->diagnosa  }}
											{{ $px->periksa->diagnosa->icd10_id }} - {{ $px->periksa->diagnosa->icd10->diagnosaICD }}

										</td>
										<td>{!! $px->periksa->terapi_html !!} <br />
											{!! Form::open(['url' => 'laporans/kunjungansakit', 'method' => 'post']) !!}
												{!! Form::text('id', $px->id, ['class' => 'hide']) !!}
												{!! Form::submit('Terdaftar di PCare', ['class' => 'btn btn-success btn-block btn-lg', 'onclick' => 'return confirm("Anda yakin pasien ' . $px->periksa->pasien->nama . ' sudah terdaftar di Pcare?"); return false']) !!}
											{!! Form::close() !!}
										</td>
									</tr>
								@endforeach
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
	</div>
</div>

@include('obat')
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
var base = '{{ url('/') }}';
	</script>

	{!! HTML::script('js/informasi_obat.js') !!}
<script type="text/javascript" charset="utf-8">
	function dummySubmit(control, nama){
		 var r = confirm('Anda yakin ' + nama + ' sudah diproses di Pcare?');
		 if(r){
		 	$(control).closest('form').find('.submit').click();
		 }
	}
</script>
	
@stop

