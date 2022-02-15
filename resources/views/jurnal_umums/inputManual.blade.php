@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Input Jurnal Umum Manual

@stop
@section('head') 
<style type="text/css" media="all">
	.margin-top{
		margin-top : 25px;
	}
</style>
@stop
@section('page-title') 
<h2>Input Jurnal Umum Manual</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Input Jurnal Umum Manual</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			@include('jurnal_umums.formManualInput')
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<div class="panel-title">Submit</div>
						</div>
						<div class="panel-body">
						{!! Form::open(['url' => 'jurnal_umums/manual', 'method' => 'post']) !!}
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('tanggal'))has-error @endif">
									  {!! Form::label('tanggal', 'Tanggal Submit', ['class' => 'control-label']) !!}
										{!! Form::text('tanggal', null, array(
											'class'         => 'form-control rq tanggal'
										))!!}
									  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('keterangan'))has-error @endif">
										{!! Form::label('keterangan', 'Keterangan', ['class' => 'control-label']) !!}
										{!! Form::textarea('keterangan', null, array(
											'class' => 'form-control textareacustom',
											'id'    => 'keterangan'
										))!!}
									  @if($errors->has('keterangan'))<code>{{ $errors->first('keterangan') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									{!! Form::textarea('temp', '[]', ['class' => 'form-control hide', 'id' => 'temp']) !!}
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<button class="btn btn-success btn-block" type="button" onclick='dummySubmit();return false;'>Submit</button>
									{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a class="btn btn-danger btn-block" href="{{ url('laporans') }}">Cancel</a>
								</div>
							</div>
						{!! Form::close() !!}	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			@include('jurnal_umums.peringatan')
		</div>
	</div>
@stop
@section('footer') 
<script src="{!! asset('js/jurnalManual.js') !!}"></script>
<script type="text/javascript" charset="utf-8">
	temp = parseTemp();
	render(temp);
	function dummySubmit(){
		var debit = 0;
		var kredit = 0;
		var temp = parseTemp();
		if( temp.length < 1 ){
			alert('Tidak ada jurnal umum yang dimasukkan. Harus ada jurnal umum yang masuk');
			return false;
		}
		 for (var i = 0; i < temp.length; i++) {
			if( temp[i].debit == 1 ){
				debit += temp[i].nilai;
			} else {
				kredit += temp[i].nilai;
			}
		 }
		if( debit != kredit ){
			alert('Debit dan Kredit Belum Seimbang')
			return false;
		}
		if( $('#keterangan').val() == '' ){
			alert('Keterangan Harus Diisi')
			validasi1( $('#keterangan'), 'Harus Diisi' );
			return false;
		}
		$('#submit').click();
	}
</script>
@stop
