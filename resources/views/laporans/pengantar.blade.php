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
	<div class="panel-heading">
		<div class="panel-title">Harus Diinput</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Nama Pengantar</th>
						<th>KTP</th>
						<th>BPJS</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($pp) > 0)
						@foreach($pp as $p)
							@if( $p->kunjungan_sehat == '1' )
								<tr>
									<td>{{ $p->nama_pengantar }} <br />
										<strong>Tanggal</strong> <br />
										{{App\Classes\Yoga::updateDatePrep(  explode( " ", $p->created_at )[0]  )}} <br />
									
									<a class="btn btn-primary btn-xs btn-block" href="{{ url('pasiens/' . $p->pasien_id . '/edit') }}">Detail</a>	
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
										  <button class="btn btn-success btn-xs btn-block" type="button" onclick="dummySubmit(this, '{{ $p->nama_pengantar }}');return false;">Submit</button>
										  {!! Form::submit('Submit', ['class' => 'hide submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endif
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function dummySubmit(control, nama){
		 var r = confirm('Anda yakin ' + nama + ' sudah diproses di Pcare?');
		 if(r){
		 	$(control).closest('form').find('.submit').click();
		 }
	}
</script>
	
@stop

