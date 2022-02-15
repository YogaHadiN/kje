@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Laba Rugi

@stop
@section('page-title') 
 <h2>List Laporan Laba Rugi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Laba Rugi</strong>
      </li>
</ol>
@stop
@section('content') 
@if ( $bikinan )
	{!! Form::open(['url' => 'laporan_laba_rugis/bikinan', 'method' => 'post']) !!}
@else
	{!! Form::open(['url' => 'laporan_laba_rugis', 'method' => 'post']) !!}
@endif
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('bulan_awal'))has-error @endif">
		  {!! Form::label('bulan_awal', 'Awal Bulan', ['class' => 'control-label']) !!}
			{!! Form::select('bulan_awal', $bulan, date('m'), array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('bulan_awal'))<code>{{ $errors->first('bulan_awal') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('tahun_awal'))has-error @endif">
		  {!! Form::label('tahun_awal', 'Tahun Awal', ['class' => 'control-label']) !!}
			{!! Form::select('tahun_awal', $tahun, date('Y'), array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('tahun_awal'))<code>{{ $errors->first('tahun_awal') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('bulan_akhir'))has-error @endif">
		  {!! Form::label('bulan_akhir', 'Akhir Bulan', ['class' => 'control-label']) !!}
			{!! Form::select('bulan_akhir', $bulan, date('m'), array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('bulan_akhir'))<code>{{ $errors->first('bulan_akhir') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('tahun_akhir'))has-error @endif">
		  {!! Form::label('tahun_akhir', 'Tahun Akhir', ['class' => 'control-label']) !!}
			{!! Form::select('tahun_akhir', $tahun, date('Y'), array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('tahun_akhir'))<code>{{ $errors->first('tahun_akhir') }}</code>@endif
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
			{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<a class="btn btn-danger btn-block" href="{{ url('home') }}">Cancel</a>
		</div>
	</div>
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
	
</div>

{!! Form::close() !!}
@stop
@section('footer') 
<script>
	function dummySubmit(){
		if (validatePass()) {
		  $('#submit').click();
		}
	}
	function periodeChange(control){
		if( $(control).val() == '1' ){ // Per Bulan
			showBulan();
			showTahun();
			showSubmit();
		}else if (  $(control).val() == '2'  ){ // Per Tahun
			hideBulan();
			showTahun();
			showSubmit();
		} else {
			hideBulan();
			hideTahun();
			hideSubmit();
		}
	}
	function showBulan(){
		$('.rowBulan').find('select').val( $('#bulan').val() );
		$('.rowBulan')
			.removeClass('hide')
			.hide()
			.slideDown(500);
	}
	function showTahun(){
		$('.rowTahun').find('input').val( $('#tahun').val() );
		$('.rowTahun')
			.removeClass('hide')
			.hide()
			.slideDown(500);
	}
	function hideBulan(){
		$('.rowBulan').find('select').val('');
		$('.rowBulan')
			.removeClass('hide')
			.slideUp(500);
	}
	function hideTahun(){
		$('.rowTahun').find('input').val('');
		$('.rowTahun')
			.removeClass('hide')
			.slideUp(500);
	}
	function showSubmit(){
		$('.rowSubmit')
			.removeClass('hide')
			.fadeIn(500);
	}
	function hideSubmit(){
		$('.rowSubmit')
			.fadeOut(500);
	}
</script>

@stop
