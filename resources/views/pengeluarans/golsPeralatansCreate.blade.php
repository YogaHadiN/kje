@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Golongan Peralatan Baru

@stop
@section('page-title') 
<h2>Golongan Peralatan Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Golongan Peralatan Baru</strong>
	  </li>
</ol>
@stop
@section('content') 
	{!! Form::open(['url' => 'pengeluarans/peralatans/golongan_peralatans/store', 'method' => 'post']) !!}
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Golongan peralatan Baru</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<div class="form-group @if($errors->has('golongan_peralatan'))has-error @endif">
							{!! Form::label('golongan_peralatan', 'Golongan Peralatan', ['class' => 'control-label']) !!}
							{!! Form::text('golongan_peralatan', null, array(
								'class'         => 'form-control rq'
							))!!}
						  @if($errors->has('golongan_peralatan'))<code>{{ $errors->first('golongan_peralatan') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group @if($errors->has('masa_pakai'))has-error @endif">
							{!! Form::label('masa_pakai', 'Masa Pakai', ['class' => 'control-label']) !!}
							<div class="input-group">
								{!! Form::text('masa_pakai', null, array(
									'class'         => 'form-control angka rq',
									'dir'         => 'rtl'
								))!!}
								<span class="input-group-addon anchor" id="showModal1" data-toggle="modal" data-target="#exampleModal"> tahun</span>
							</div>
						  @if($errors->has('masa_pakai'))<code>{{ $errors->first('masa_pakai') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-success btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
						{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger btn-block" href="{{ url('/') }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		
	{!! Form::close() !!}
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
