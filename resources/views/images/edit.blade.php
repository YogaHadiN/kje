@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Gambar Estetika

@stop
@section('page-title') 
<h2>Edit Gambar Estetika</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Gambar Estetika</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open([
		'url'		=> 'periksa/' . $periksa->id . '/images', 
		'method'	=> 'put', 
		'files'		=> 'true'
	]) !!}
		@include('images.form')
	{!! Form::close() !!}
	@include('gambar_periksa')
@stop
@section('footer') 
{!! HTML::script('js/gambar_periksa.js')!!} 
<script type="text/javascript" charset="utf-8">
	tambahGambar();
	$('#image_delete').val('[]');
	var sisaJson = '{!!  $periksa->gambarPeriksa  !!}';
	$('#image_sisa').val(sisaJson);
	function dummySubmit(){
		 $('#submit').click();
	}

	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
			what = a[--L];
			while ((ax = this.indexOf(what)) !== -1) {
				this.splice(ax, 1);
			}
		}
		return this;
	};
	function delImage(control){
		var id = $(control).val();
		$(control).closest('.satu_gambar').slideUp(300);
		var sisa = $('#image_sisa').val();
		sisa = JSON.parse(sisa);
		console.log('sisa awal');
		console.log(sisa);
		var index = '0';
		for (var i = 0; i < sisa.length; i++) {
			if(sisa[i].id == id){
				index = i;
				break;
			}
		}
		console.log('index');
		console.log(index);
		sisa.splice(index, 1);
		console.log('sisa akhir');
		console.log(sisa);
		var sisaJson = JSON.stringify(sisa);
		$('#image_sisa').val(sisaJson);
	}
	
	
	
		
	
</script>
@stop
