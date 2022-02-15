@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Laba Rugi

@stop
@section('page-title') 
 <h2>List Laporan Laba Rugi Bikinan</h2>
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
{!! Form::open(['url' => 'laporan_laba_rugis/bikinan', 'method' => 'post']) !!}
	@include('laporan_laba_rugis.form_index')
{!! Form::close() !!}
{!! Form::text('bulan', date('m'), ['class' => 'form-control hide', 'id' => 'bulan']) !!}
{!! Form::text('tahun', date('Y'), ['class' => 'form-control hide', 'id' => 'tahun']) !!}
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
