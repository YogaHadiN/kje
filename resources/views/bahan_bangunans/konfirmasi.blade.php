@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Konfirmasi Bahan Bangunan

@stop
@section('page-title') 
<h2>Konfirmasi Bahan Bangunan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Konfirmasi Bahan Bangunan</strong>
	  </li>
</ol>
@stop
@section('content') 
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Konfirmasi</div>
			</div>
			<div class="panel-body">
				{!! Form::open(['url' => 'bahan_bangunans/konfirmasi/'.$bulan.'/' . $tahun, 'method' => 'post']) !!}
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('konfirmasi'))has-error @endif">
								{!! Form::label('konfirmasi', 'konfirmasi', ['class' => 'control-label']) !!}
								{!! Form::select('konfirmasi', App\Models\Classes\Yoga::konfirmasi(), null, array(
									'class'         => 'form-control rq'
								))!!}
							  @if($errors->has('konfirmasi'))<code>{{ $errors->first('konfirmasi') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('bangunan_permanen'))has-error @endif">
								{!! Form::label('bangunan_permanen', 'Bangunan Permanen', ['class' => 'control-label']) !!}
								{!! Form::select('bangunan_permanen', App\Models\Classes\Yoga::bangunanPermanen(), null, array(
									'class'         => 'form-control rq'
								))!!}
							  @if($errors->has('bangunan_permanen'))<code>{{ $errors->first('bangunan_permanen') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('tanggal_renovasi_selesai'))has-error @endif">
								{!! Form::label('tanggal_renovasi_selesai', 'tanggal_renovasi_selesai', ['class' => 'control-label']) !!}
								{!! Form::text('tanggal_renovasi_selesai', date('d-m-Y'), array(
									'class'         => 'form-control tanggal'
								))!!}
							  @if($errors->has('tanggal_renovasi_selesai'))<code>{{ $errors->first('tanggal_renovasi_selesai') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
							{!! Form::submit('Submit', ['class' => 'btn btn-success hide submit']) !!}
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-danger btn-block" href="{{ url('laporans') }}">Cancel</a>
						</div>
					</div>
					{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Daftar Bahan Bangunan Yang Perlu Dikonfirmasi</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Tanggal Pembelian</th>
								<th>Bahan Bangunan</th>
								<th>Harga Beli</th>
							</tr>
						</thead>
						<tbody>
							@if($datas->count() > 0)
								@foreach( $datas as $d )
									<tr>
										<td>{{ $d->fakturBelanja->tanggal->format('d M Y') }}</td>
										<td>{{ $d->keterangan }}</td>
										<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $d->harga_satuan * $d->jumlah )}}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="">Tidak ada data untuk ditampilkan</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function dummySubmit(control){
		if(validatePass()){
			$(control).closest('div').find('.submit').click();
		}
	}
</script>
@stop
