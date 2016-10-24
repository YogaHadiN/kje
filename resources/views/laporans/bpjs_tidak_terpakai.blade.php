@extends('layout.master')

@section('title') 
Klinik Jati Elok | BPJS tidak pakai BPJS

@stop
@section('page-title') 
<h2>BPJS tidak pakai BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>BPJS tidak pakai BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
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
											<strong>Tanggal</strong><br />
											{{ $px->created_at->format('d-m-Y') }}<br />
											<strong>Jam</strong><br />
											{{ $px->created_at->format('H:i:s') }}<br /><br />
											{{ $px->periksa->pasien->nama }} <br />
											<strong>({{ $px->periksa->pasien_id }})</strong> <br /><br />
											<strong>Nomor BPJS :</strong> <br />
											{{ $px->periksa->pasien->nomor_asuransi_bpjs }} <br /><br />
											<strong>Pembayaran saat ini :</strong> <br />
											{{ $px->periksa->asuransi->nama }} <br />
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
@stop

