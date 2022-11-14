@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Hutang Asuransi

@stop
@section('page-title') 
<h2>Hutang Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Hutang Asuransi</strong>
	  </li>
</ol>
@stop
@section('content') 
	<h1>Piutang Asuransi</h1>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th>Bulan Tahun</th>
							<th>Piutang</th>
							<th>Sudah Dibayat</th>
							<th>Sisa Piutang</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(($data_piutang) > 0)
							@foreach($data_piutang as $dp)
								<tr
									@if(   $dp->piutang -  $dp->sudah_dibayar  > 0 )
										class="bg-danger"
									@endif
									>
									<td>{{ date('Y F', strtotime($dp->tanggal)) }}</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $dp->piutang ) }}</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $dp->sudah_dibayar ) }}</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $dp->piutang -  $dp->sudah_dibayar  ) }}</td>
									<td nowrap class="autofit">
										<a class="btn btn-info btn-sm" href="{{ url("hutang_asuransi")}}/{{str_pad($dp->bulan, 2, '0', STR_PAD_LEFT) }}/{{$dp->tahun}}">Show</a>

									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5">Tidak ada data untuk ditampilkan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	<h1>Riwayat Pembayaran</h1>

@stop
@section('footer') 
  <script type="text/javascript" charset="utf-8">
	function dummySubmit(){
		if(validatePass()){
			$('#submit').click();
		}
	}
  </script>
@stop
