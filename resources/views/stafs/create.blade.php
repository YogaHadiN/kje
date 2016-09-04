 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | sign Up

 @stop
 @section('page-title') 
 <h2>Sign Up
</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
          <strong>Sign Up</strong>
      </li>
</ol>
 @stop
 @section('content') 
{!! Form::open(array(
    "url"   => "stafs",
    "class" => "m-t", 
    "role"  => "form",
    "method"=> "post",
    "files"=> "true"
))!!}

@include('stafs.form', [
  'tanggal_mulai' => null,
  'tanggal_lulus' => null,
  'tanggal_lahir' => null,
  'image'         => null,
  'ktp_image'     => null
])

{!! Form::close() !!}

 @stop
 @section('footer') 

	 <script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	 </script>
{!! HTML::script('js/plugins/webcam/photo.js')!!}
{!! HTML::script('js/togglepanel.js')!!}

 @stop

