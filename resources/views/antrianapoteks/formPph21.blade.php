@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Cetak Bukti Potong Pajak

@stop
@section('page-title') 
<h2>Cetak Bukti Potong Pajak</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cetak Bukti Potong Pajak</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panelLeft">
				<div class="panel-title">Cetak Bukti Potong Pajak</div>
			</div>
			<div class="panelRight">
			  
			</div>
		</div>
		<div class="panel-body">
			{!! Form::open(['url' => 'stafs/cetakPph21', 'method' => 'post']) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('staf_id'))has-error @endif">
							{!! Form::label('staf_id', 'Nama Dokter', ['class' => 'control-label']) !!}
							{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
								'class'         => 'form-control rq '
							))!!}
						  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('bulan'))has-error @endif">
							{!! Form::label('bulan', 'bulan', ['class' => 'control-label']) !!}
							{!! Form::select('bulan', App\Models\Classes\Yoga::bulanList(), date('m'), array(
								'class'         => 'form-control rq '
							))!!}
						  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('tahun'))has-error @endif">
							{!! Form::label('tahun', 'tahun', ['class' => 'control-label']) !!}
							{!! Form::text('tahun', date('Y'), array(
								'class'         => 'form-control angka'
							))!!}
						  @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-success" type="button" onclick='dummySubmit();return false;'>Submit</button>
						{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger" href="{{ url('laporans') }}">Cancel</a>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
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
