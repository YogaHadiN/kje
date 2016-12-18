@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Diskon Baru

@stop
@section('page-title') 
<h2>Buat Diskon Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Diskon Baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Buat Diskon Baru</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'discounts', 'method' => 'post']) !!}
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('jenis_tarif_id'))has-error @endif">
							  {!! Form::label('jenis_tarif_id', 'Jenis Tarif', ['class' => 'control-label']) !!}
							  {!! Form::select('jenis_tarif_id' , $jenisTarifList, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
							  @if($errors->has('jenis_tarif_id'))<code>{{ $errors->first('jenis_tarif_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
							  {!! Form::label('asuransi_id', 'Untuk Asuransi', ['class' => 'control-label']) !!}
							  {!! Form::select('asuransi_id' , $asuransiList, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
							  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('discount'))has-error @endif">
							  {!! Form::label('discount', 'Besar Diskon Dalam Persen', ['class' => 'control-label']) !!}
							  {!! Form::text('discount' , null, ['class' => 'form-control angka']) !!}
							  @if($errors->has('discount'))<code>{{ $errors->first('discount') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('dimulai'))has-error @endif">
							  {!! Form::label('dimulai', 'Tanggal Mulai Diskon', ['class' => 'control-label']) !!}
							  {!! Form::text('dimulai' , null, ['class' => 'form-control tanggal']) !!}
							  @if($errors->has('dimulai'))<code>{{ $errors->first('dimulai') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('berakhir'))has-error @endif">
							  {!! Form::label('berakhir', 'Tanggal Berakhir Diskon', ['class' => 'control-label']) !!}
							  {!! Form::text('berakhir' , null, ['class' => 'form-control tanggal']) !!}
							  @if($errors->has('berakhir'))<code>{{ $errors->first('berakhir') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group">
										<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Submit</button>
										{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
									</div> 
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
								</div>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
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

