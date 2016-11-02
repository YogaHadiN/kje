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
		  <li role="presentation" class="active"><a href="#harus_diinput" aria-controls="harus_diinput" role="tab" data-toggle="tab">Harus Diinput ( {{count(  $pp_harus_diinput  )}} )</a></li>
		  <li role="presentation"><a href="#tidak_harus_diinput" aria-controls="tidak_harus_diinput" role="tab" data-toggle="tab">Tidak Harus Diinput ( {{$pp_tidak_harus_diinput->count()}} )</a></li>
		  <li role="presentation"><a href="#sudah_diinput" aria-controls="sudah_diinput" role="tab" data-toggle="tab">Sudah Diinput ( {{ count($pp_sudah_diinput) }} )</a></li>
		  </ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="harus_diinput">
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
							@foreach($pp_harus_diinput as $p)
								<tr @if( $p->pcare_submit == '2' ) class="danger" @endif >
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
									{!! Form::open(['url' => 'laporans/pengantar', 'method' => 'post', 'autocomplete' => 'off']) !!}
										{!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
										{!! Form::text('nama', $p->nama_pengantar, ['class' => 'hide nama']) !!}
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
				</div>


			</div>
			<div role="tabpanel" class="tab-pane" id="tidak_harus_diinput">
				<div class="table-responsive">
					<table class="table table-hover table-condensed DT table-bordered" id="table_tidak_harus_diinput">
						<thead>
							<tr>
								<th>Nama Pengantar</th>
								<th>Pasien Sudah <br /> Berobat Tanggal </th>
								<th>Pasien Sudah <br /> Mengantar Tanggal</th>
								<th>Pasien Sudah <br /> Sakit Tanggal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pp_tidak_harus_diinput as $p)
							<tr>
								<td>{{ $p->pengantar->nama }} <br />
									<strong>Tanggal</strong> <br />
									{{App\Classes\Yoga::updateDatePrep(  explode( " ", $p->created_at )[0]  )}} <br />

									{{ $p->pengantar->id }}
									<a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $p->pengantar_id . '/edit') }}">Detail</a>	
								</td>
								<td>
									<ul>
										@foreach( App\Classes\Yoga::pengantarBerobat( $p->pengantar->id, $tanggal ) as $px )
										<li>{{ $px->created_at }}</li>
										@endforeach
									</ul>
								</td>
								<td>
									<ul>
										@foreach( App\Classes\Yoga::pengantarMengantar( $p->pengantar->id, $tanggal ) as $py )
											<li>{{ App\Classes\Yoga::updateDatePrep(  explode(" ", $py->created_at )[0] ) }}</li>
										@endforeach
									</ul>
								</td>
								<td>
									<ul>
									@foreach( App\Classes\Yoga::pengantarKunjunganSakit( $p->pengantar->id, $tanggal ) as $pz )
										<li>{{ App\Classes\Yoga::updateDatePrep(  explode(" ", $pz->created_at )[0] ) }}</li>
										@endforeach
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="sudah_diinput">
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
							@foreach($pp_sudah_diinput as $p)
								<tr @if( $p->pcare_submit == '2' ) class="danger" @endif >
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
		
	$('.pcareSubmit').focus(function(){
		$(this).closest('form').find('.previous').val($(this).val());
	}).change(function(){
		var text = $(this).find('option:selected').text();
		var nama = $(this).closest('form').find('.nama').val();
		var r = confirm('Anda yakin ' + nama + ' ' + text + '?' );
		if(r){
			$(this).closest('form').find('.submit').click();
		} else {
			var previous = $(this).closest('form').find('.previous').val();
			$(this).val(previous);
			$(this).closest('form').find('.previous').val('');
		}
	}).blur(function(){
		$(this).closest('form').find('.previous').val('');
	});

	function dummySubmit(control, nama){
		 var r = confirm('Anda yakin ' + nama + ' sudah diproses di Pcare?');
		 if(r){
		 	$(control).closest('form').find('.submit').click();
		 }
	}
</script>
	
@stop

