@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Gabung Pasien Dobel

@stop
@section('page-title') 
<h2>Gabung Pasien Dobel</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Gabung Pasien Dobel</strong>
	  </li>
</ol>

@stop
@section('content') 
	@include('pasiens.form', ['createLink' => false])
	<div class="row" id="bodyGabung">
	</div>
	{!! Form::open(['url' => 'pasiens/ajax/cari/pasien', 'method' => 'post']) !!}
		{!! Form::textarea('tempArray', '[]', ['class' => 'form-control textareacustom rq hide', 'id' =>'tempArray']) !!}
		<div class="row" id='submitDiv'>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
					<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Merge/Gabung</button>
					{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
				</div> 
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
			</div>
		</div>
	{!! Form::close() !!}
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			var r = confirm('Anda yakin mau menggabungkan pasien ini? Semua pasien ini akan dihapus dan akan disisakan hanya satu yang biru muda');
			if(r){
				if(validatePass2()){
					$('#submit').click();
				}
			}
		}
		var base = "{{ url('/') }}";
	</script>
{!! HTML::script('js/pasienGabung.js')!!}
@stop

