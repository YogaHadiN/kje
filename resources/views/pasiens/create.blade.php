 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | sign Up

 @stop
 @section('head')
    <link href="{{ url('css/select2custom.css') }}" rel="stylesheet">
 @stop
 @section('page-title') 

 <h2>Pasien Baru</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li class="active">
          <strong>Pasien Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
@if(isset($antrian))
	@include('fasilitas.memproses')
{!! Form::open(array(
	"url"   => "antrians/{$antrian->id}/pasiens",
	"class" => "m-t", 
	"role"  => "form",
	"files"  => "true",
	"method"=> "post"
))!!}
@else
{!! Form::open(array(
	"url"          => "pasiens",
	"class"        => "m-t",
	"role"         => "form",
	"autocomplete" => "off",
	"files"        => "true",
	"method"       => "post"
))!!}
@endif
	@include('pasiens.createForm', ['antrianpolis' => true])
{!! Form::close() !!}
 @stop
 @section('footer') 
<script type="text/javascript" charset="utf-8">
var base = "{{ url('/') }}";
</script>
	{{-- {!! HTML::script('js/plugins/webcam/photo.js')!!} --}}
	{!! HTML::script('js/togglepanel.js')!!}
	{!! HTML::script('js/pasien_create.js')!!}
	{!! HTML::script('js/pasiens.js')!!}
	{!! HTML::script('js/select2custom.js')!!}
	{!! HTML::script('js/peringatan_usg.js')!!}
<script>
    $(document).ready(function() {
		select2Engage('.selectPasien', 'pasiens/ajax/cari')
    });
</script>
@stop


       
