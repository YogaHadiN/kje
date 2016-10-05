@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pasien

@stop
@section('page-title') 
 <h2>Pasien</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pasien</strong>
      </li>
</ol>

@stop
@section('content')
	@include('pasiens.form')
@stop
@section('footer') 
<script>
  var base = "{{ url('/') }}";
</script>
{!! HTML::script('js/plugins/webcam/photo.js')!!}
{!! HTML::script('js/togglepanel.js')!!}
{!! HTML::script('js/pasiens.js')!!}
{!! HTML::script('js/cekbpjskontrol.js')!!}
{!! HTML::script('js/peringatan_usg.js')!!}
@stop
