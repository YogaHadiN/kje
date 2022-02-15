@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Pengantar Pasien BPJS

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

#table_tidak_harus_diinput tr th:first-child, #table_tidak_harus_diinput tr td:first-child {
	width:10%;
}

#table_tidak_harus_diinput tr th:nth-child(2), #table_tidak_harus_diinput tr td:nth-child(2) {
	width:30%;
}

#table_tidak_harus_diinput tr th:nth-child(3), #table_tidak_harus_diinput tr td:nth-child(3) {
	width:30%;
}

#table_tidak_harus_diinput tr th:nth-child(4), #table_tidak_harus_diinput tr td:nth-child(4) {
	width:30%;
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
		<div class="panel-title">Pengantar Pasien</div>
	</div>
	<div class="panel-body">
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		  <li role="presentation" class="active"><a href="#harus_diinput" aria-controls="harus_diinput" role="tab" data-toggle="tab">Harus Diinput</a></li>
		  <li role="presentation"><a href="#sudah_diinput" aria-controls="sudah_diinput" role="tab" data-toggle="tab">Sudah Diinput</a></li>
		  </ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="harus_diinput">
				<div class="table-responsive">
					{{ $pp_harus_diinput->links() }}
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
							@foreach($pp_harus_diinput as $p)
								<tr @if( $p->pcare_submit == '2' ) class="danger" @endif >
									<td>{{ $p->pengantar->nama }} <br />
										<strong>Tanggal </strong> <br />
										{{ $p->created_at->format('d M Y') }} <br />
										<a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $p->pasien_id . '/edit') }}">Detail</a>	
									</td>
									<td>
										<img src="{{ url('/'). '/' . $p->pengantar->ktp_image }}" alt="" class="img-rounded upload" />
										@if(!empty( $p->pengantar->nomor_ktp ))
										<br />  {{ $p->pengantar->nomor_ktp }}
										@else
										<br />  Nomor KTP tidak terdaftar
										@endif
									</td>
									<td>
										<img src="{{ url('/'). '/' . $p->pengantar->bpjs_image }}" alt="" class="img-rounded upload" />
										@if(!empty( $p->pengantar->nomor_asuransi_bpjs ))
											<br />  {{ $p->pengantar->nomor_asuransi_bpjs }}
										@else
										<br />  Nomor BPJS tidak terdaftar
										@endif
									</td>
									<td>
									{!! Form::open(['url' => 'laporans/pengantar', 'method' => 'post', 'autocomplete' => 'off']) !!}
										{!! Form::text('id', $p->pengantar_id, ['class' => 'form-control hide']) !!}
										{!! Form::text('nama', $p->pengantar->nama, ['class' => 'hide nama']) !!}
										{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
										{!! Form::text('kunjungan_sehat', '1', ['class' => 'form-control hide kunjungan_sehat']) !!}
										{!! Form::select('pcare_submit', $pcare_submits, $p->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
										{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $pp_harus_diinput->links() }}
				</div>


			</div>
			<div role="tabpanel" class="tab-pane" id="sudah_diinput">
				<div class="table-responsive">
					{{ $pp_sudah_diinput->links() }}
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
							@foreach($pp_sudah_diinput as $p)
								<tr @if( $p->pcare_submit == '2' ) class="danger" @endif >
									<td>{{ $p->nama_pengantar }} <br />
										<strong>Tanggal</strong> <br />
										{{App\Models\Classes\Yoga::updateDatePrep(  explode( " ", $p->created_at )[0]  )}} <br />
										{{-- <br>{{ $p->pcare_submit }} --}}
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
									{!! Form::open(['url' => 'laporans/pengantar', 'method' => 'post', 'autocomplete' => 'off']) !!}
										{!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
										{!! Form::text('nama', $p->nama_pengantar, ['class' => 'hide nama']) !!}
										{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
										{!! Form::text('kunjungan_sehat', '1', ['class' => 'kunjungan_sehat']) !!}
										{!! Form::select('pcare_submit', $pcare_submits, $p->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
										{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $pp_sudah_diinput->links() }}
				</div>
			</div>
		  </div>
		</div>
	</div>
</div>



@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">

var previous = '';
		
	pcareSubmit()

	function dummySubmit(control, nama){
		 var r = confirm('Anda yakin ' + nama + ' sudah diproses di Pcare?');
		 if(r){
		 	$(control).closest('form').find('.submit').click();
		 }
	}
</script>
	
@stop

